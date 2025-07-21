<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Mail\OrderPlacedMail;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    public function index()
    {
        try {
            $item = Cart::instance('cart')->content();
            return view('frontend.cart.index', compact('item'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function add_to_cart(Request $request)
    {
        try {
            $item = Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function qty_increase($rowId)
    {
        try {
            $product = Cart::instance('cart')->get($rowId);
            if (!$product) {
                return response()->json(['error' => 'Cart item not found.'], 404);
            }

            $qty = $product->qty + 1;
            Cart::instance('cart')->update($rowId, $qty);

            return response()->json([
                'success' => true,
                'qty' => $qty,
                'rowId' => $rowId,
                'itemSubtotal' => number_format($qty * $product->price, 2),
                'cartSubtotal' => Cart::instance('cart')->subTotal(),
                // 'cartTotal' => Cart::instance('cart')->total(),
                'cartTotal' => Cart::instance('cart')->subTotal()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }


    // public function qty_increase($rowId)
    // {
    //     try {
    //         $product = Cart::instance('cart')->get($rowId);
    //         if (!$product) {
    //             return response()->json(['error' => 'Cart item not found.'], 404);
    //         }

    //         $qty = $product->qty + 1;
    //         Cart::instance('cart')->update($rowId, $qty);

    //         // Get raw subtotal (as float)
    //         $rawSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
    //         $cartTotal = $rawSubtotal;
    //         $discountAmount = 0;
    //         $discountPercent = 0;

    //         if (session()->has('applied_coupon')) {
    //             $discountAmount = session('applied_coupon.discount_amount');
    //             $discountPercent = session('applied_coupon.discount_percent');
    //             $cartTotal = $rawSubtotal - $discountAmount;
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'qty' => $qty,
    //             'rowId' => $rowId,
    //             'itemSubtotal' => number_format($qty * $product->price, 2),
    //             'cartSubtotal' => number_format($rawSubtotal, 2),
    //             'discountAmount' => number_format($discountAmount, 2),
    //             'discountPercent' => $discountPercent,
    //             'cartTotal' => number_format($cartTotal, 2),
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => 'Something went wrong.'], 500);
    //     }
    // }


    public function qty_reduce($rowId)
    {
        try {
            $product = Cart::instance('cart')->get($rowId);
            if (!$product) {
                return response()->json(['error' => 'Cart item not found.'], 404);
            }

            $qty = $product->qty - 1;
            if ($qty < 1) {
                return response()->json(['error' => 'Minimum quantity is 1.'], 400);
            }

            Cart::instance('cart')->update($rowId, $qty);

            return response()->json([
                'success' => true,
                'qty' => $qty,
                'rowId' => $rowId,
                'itemSubtotal' => number_format($qty * $product->price, 2),
                'cartSubtotal' => Cart::instance('cart')->subTotal(),
                // 'cartTotal' => Cart::instance('cart')->total();
                'cartTotal' => Cart::instance('cart')->subTotal()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    // public function qty_reduce($rowId)
    // {
    //     try {
    //         $product = Cart::instance('cart')->get($rowId);
    //         if (!$product) {
    //             return response()->json(['error' => 'Cart item not found.'], 404);
    //         }

    //         $qty = $product->qty - 1;
    //         Cart::instance('cart')->update($rowId, $qty);

    //         // Get raw subtotal (as float)
    //         $rawSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
    //         $cartTotal = $rawSubtotal;
    //         $discountAmount = 0;
    //         $discountPercent = 0;

    //         if (session()->has('applied_coupon')) {
    //             $discountAmount = session('applied_coupon.discount_amount');
    //             $discountPercent = session('applied_coupon.discount_percent');

    //             $cartTotal = $rawSubtotal - $discountAmount;
    //         }

    //         return response()->json([
    //             'success' => true,
    //             'qty' => $qty,
    //             'rowId' => $rowId,
    //             'itemSubtotal' => number_format($qty * $product->price, 2),
    //             'cartSubtotal' => number_format($rawSubtotal, 2),
    //             'discountAmount' => number_format($discountAmount, 2),
    //             'discountPercent' => $discountPercent,
    //             'cartTotal' => number_format($cartTotal, 2),
    //         ]);
    //     } catch (\Throwable $th) {
    //         return response()->json(['error' => 'Something went wrong.'], 500);
    //     }
    // }


    public function remove($rowId)
    {
        try {
            Cart::instance('cart')->remove($rowId);

            return response()->json([
                'success' => true,
                'redirect' => route('cart.index'),
                'rowId' => $rowId,
                'cartSubtotal' => Cart::instance('cart')->subTotal(),
                'cartTax' => Cart::instance('cart')->tax(),
                'cartTotal' => Cart::instance('cart')->total()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to remove item.'], 500);
        }
    }

    public function clear()
    {
        try {
            Cart::instance('cart')->destroy();

            return response()->json([
                'success' => true,
                'redirect' => route('cart.index')
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart.'
            ], 500);
        }
    }


    // public function apply(Request $request)
    // {
    //     $request->validate([
    //         'coupon_code' => 'required|string'
    //     ]);

    //     $coupon = Coupon::where('code', $request->coupon_code)->first();

    //     if (!$coupon) {
    //         return back()->with('coupon_message', 'Invalid coupon code.');
    //     }

    //     if ($coupon->expires_date && $coupon->expires_date < now()) {
    //         return back()->with('coupon_message', 'Coupon has expired.');
    //     }

    //     // Calculate discount
    //     $cartSubtotal = floatval(\Cart::instance('cart')->subtotal()); // subtotal without discount

    //     if ($coupon->type == 'percent') {
    //         $discountAmount = ($coupon->value / 100) * $cartSubtotal;
    //     } else {
    //         $discountAmount = ($coupon->value / 100) * $cartSubtotal;
    //     }


    //     // Store coupon in session
    //     session([
    //         'applied_coupon' => [
    //             'code' => $coupon->code,
    //             'discount_percent' => $coupon->value,
    //             'discount_amount' => $discountAmount
    //         ]
    //     ]);

    //     return back()->with('coupon_message', 'Coupon applied! You got ' . $coupon->discount . '% off.');
    // }

    public function apply(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return back()->with('coupon_message', 'Invalid coupon code.');
        }

        if ($coupon->expiry_date && $coupon->expiry_date < Carbon::now('Asia/Kolkata')) {

            return back()->with('coupon_message', 'Coupon has expired.');
        }

        //         $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        // dump($cartSubtotal);
        //         if ($coupon->type == 'percent') {
        //             $discountAmount = ($coupon->value / 100) * $cartSubtotal;
        //             dd($discountAmount);
        //         } else {
        //             $discountAmount = $coupon->value;
        //         }

        // $cartSubtotal = str_replace(',', '', Cart::instance('cart')->subtotal());
        // $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
        // if ($coupon->type == 'percent') {
        //     $discountAmount = ($coupon->value / 100) * $cartSubtotal;
        // } else {
        //     $discountAmount = $coupon->value;
        // }

        // Store coupon in session
        // session([
        //     'applied_coupon' => [
        //         'code' => $coupon->code,
        //         'discount_percent' => $coupon->value,
        //         'discount_amount' => $discountAmount
        //     ]
        // ]);

        // session([
        //     'applied_coupon' => [
        //         'code' => $coupon->code,
        //         'discount_percent' => $coupon->value,
        //         'discount_amount' => $discountAmount,
        //         'subtotal' => $cartSubtotal,
        //     ]
        // ]);

        $cartSubtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));

        if ($coupon->type == 'percent') {
            $discountAmount = ($coupon->value / 100) * $cartSubtotal;
        } else {
            $discountAmount = $coupon->value;
        }

        $total = $cartSubtotal - $discountAmount;
        session([
            'applied_coupon' => [
                'code' => $coupon->code,
                'discount_percent' => $coupon->value,
                'discount_amount' => $discountAmount,
                'subtotal' => $cartSubtotal,
                'total' => $total
            ]
        ]);


        // Now update the checkout values
        $this->setAmountForCheckout();

        return back()->with('coupon_message', 'Coupon applied! You got ' . $coupon->discount . '% off.');
    }

    public function checkout()
    {
        try {

            if (!Auth::check()) {
                return redirect()->route('login');
            } else {
                $address = Address::where('user_id', Auth::id())->where('is_default', 1)->first();
                return view('frontend.cart.checkout', compact('address'));
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function order_place(Request $request)
    // {
    //     try {

    //         $address = Address::where('user_id', Auth::id())->where('is_default', true)->first();

    //         if (!$address) {
    //             $validator = Validator::make($request->all(), [
    //                 'name' => 'required|string|max:255',
    //                 'address' => 'required|string',
    //                 'phone' => 'required|digits:10',
    //                 'zipcode' => 'required|digits:6',
    //                 'country' => 'required|string',
    //                 'state' => 'required|string',
    //                 'city' => 'required|string',
    //                 'locality' => 'required|string',
    //                 'landmark' => 'required|string'
    //             ]);

    //             $address = Address::create([
    //                 'user_id' => Auth::id(),
    //                 'name' => $request->name,
    //                 'address' => $request->address,
    //                 'phone' => $request->phone,
    //                 'zipcode' => $request->zipcode,
    //                 'country' => $request->country,
    //                 'state' => $request->state,
    //                 'city' => $request->city,
    //                 'locality' => $request->locality,
    //                 'landmark' => $request->landmark,
    //                 'is_default' => true
    //             ]);


    //             $this->setAmountForCheckout();

    //             $order = Order::create([
    //                 'user_id' => Auth::id(),
    //                 'subtotal' => Session::get('checkout')['subtotal'],
    //                 'discount' => Session::get('checkout')['discount'],
    //                 'total' => Session::get('checkout')['subtotal'],
    //                 'name' => $address->name,
    //                 'phone' => $address->phone,
    //                 'locality' => $address->locality,
    //                 'address' => $address->address,
    //                 'country' => $address->country,
    //                 'state' => $address->state,
    //                 'city' => $address->city,
    //                 'landmark' => $address->landmark,
    //                 'zipcode' => $address->zipcode,
    //             ]);


    //             foreach (Cart::instance('cart')->content() as $item) {

    //                 $orderItem = OrderItem::create([
    //                     'product_id' => $item->id,
    //                     'order_id' => $order->id,
    //                     'price' => $item->price,
    //                     'qty' => $item->qty,
    //                 ]);
    //             }


    //             if ($request->mode == 'cod') {
    //                 $transaction = Transaction::create([
    //                     'user_id' => Auth::id(),
    //                     'order_id' => $order->id,
    //                     'mode' => $request->mode,
    //                 ]);
    //             }

    //             else if($request->mode == 'paypal'){

    //             }

    //             else if($request->mode == 'card'){

    //             }


    //             Cart::instance('cart')->destroy;
    //             Session::forget('checkout');
    //             Session::forget('applied_coupon');
    //             Session::put('order_id',$order->id);
    //             return redirect()->route('cart.order_confirm');
    //         }
    //     } catch (\Throwable $th) {
    //         throw $th;
    //     }
    // }

    public function order_place(Request $request)
    {
        try {

            // Step 1: Get or create default address
            $address = Address::where('user_id', Auth::id())->where('is_default', true)->first();

            if (!$address) {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'address' => 'required|string',
                    'phone' => 'required|digits:10',
                    'zipcode' => 'required|digits:6',
                    'country' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'locality' => 'required|string',
                    'landmark' => 'required|string',
                    'mode'     => 'required',
                ]);



                $address = Address::create([
                    'user_id' => Auth::id(),
                    'name' => $request->name,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'zipcode' => $request->zipcode,
                    'country' => $request->country,
                    'state' => $request->state,
                    'city' => $request->city,
                    'locality' => $request->locality,
                    'landmark' => $request->landmark,
                    'is_default' => true
                ]);
            }

            $this->setAmountForCheckout();

            $checkout = Session::get('checkout');
            
            $orderID = rand(1111, 9999);
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => $orderID,
                'subtotal' => floatval(str_replace(',', '', $checkout['subtotal'])),
                'discount' => floatval(str_replace(',', '', $checkout['discount'] ?? 0)),
                'discount_amount' => floatval(str_replace(',', '', $checkout['discount_amount'] ?? 0)),
                'total' => floatval(str_replace(',', '', $checkout['total'])),
                'name' => $address->name,
                'phone' => $address->phone,
                'locality' => $address->locality,
                'address' => $address->address,
                'country' => $address->country,
                'state' => $address->state,
                'city' => $address->city,
                'landmark' => $address->landmark,
                'zipcode' => $address->zipcode,
            ]);

            // Step 4: Add cart items to order
            foreach (Cart::instance('cart')->content() as $item) {
                OrderItem::create([
                    'product_id' => $item->id,
                    'order_id' => $order->id,
                    'price' => $item->price,
                    'qty' => $item->qty,
                ]);
            }

            // Step 5: Handle payment mode
            $transactionId =  mt_rand(100000000000, 999999999999);
            if ($request->mode === 'cod') {
                Transaction::create([
                    'user_id' => Auth::id(),
                    'transaction_id' => $transactionId,
                    'order_id' => $order->id,
                    'mode' => $request->mode,
                ]);
            }

            // Future payment modes
            elseif ($request->mode === 'paypal') {
                // Implement PayPal flow here
            } elseif ($request->mode === 'card') {
                // Implement Card payment here
            }

            // Step 6: Clean up session/cart
            Cart::instance('cart')->destroy();
            Session::forget('checkout');
            Session::forget('applied_coupon');
            Session::put('order_id', $order->id);

            Mail::to(Auth::user()->email)->send(new OrderPlacedMail($order));
            return redirect()->route('cart.order_confirm');
        } catch (\Throwable $th) {
            // Optionally log the error
            throw $th;
        }
    }


    public function setAmountForCheckout()
    {

        try {

            if (!Cart::instance('cart')->content()->count() > 0) {
                Session::forget('checkout');
                return;
            }

            if (Session::has('applied_coupon')) {


                $applied = Session::get('applied_coupon');

                Session::put('checkout', [
                    'discount' => floatval(str_replace(',', '', $applied['discount_percent'] ?? 0)),
                    'discount_amount' => floatval(str_replace(',', '', $applied['discount_amount'] ?? 0)),
                    'subtotal' => floatval(str_replace(',', '', $applied['subtotal'] ?? 0)),
                    'total' => floatval(str_replace(',', '', $applied['total'] ?? 0)),
                ]);
            } else {
                Session::put('checkout', [
                    'discount' => 0,
                    'subtotal' => Cart::instance('cart')->subtotal(),
                    'total' => Cart::instance('cart')->subtotal(),
                ]);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function order_confirm()
    {

        try {

            if (Session::has('order_id')) {
                $order = Order::find(Session::get('order_id'));
                return view('frontend.cart.order_confirm', compact('order'));
            }

            return redirect()->route('cart.index');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
