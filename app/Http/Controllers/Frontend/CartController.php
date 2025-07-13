<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

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

        $cartSubtotal = str_replace(',', '', Cart::instance('cart')->subtotal());
        if ($coupon->type == 'percent') {
            $discountAmount = ($coupon->value / 100) * $cartSubtotal;
        } else {
            $discountAmount = $coupon->value;
        }




        // Store coupon in session
        session([
            'applied_coupon' => [
                'code' => $coupon->code,
                'discount_percent' => $coupon->value,
                'discount_amount' => $discountAmount
            ]
        ]);

        return back()->with('coupon_message', 'Coupon applied! You got ' . $coupon->discount . '% off.');
    }
}
