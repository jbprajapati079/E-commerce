<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $items = Cart::instance('wishlist')->content();
            $productIds = $items->pluck('id');
            $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

            $wishlistItems = $items->map(function ($item) use ($products) {
                $product = $products[$item->id] ?? null;
                $item->slug = $product?->slug;
            });

            return view('frontend.wishlist.index', compact('items'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function addWishList(Request $request)
    {
        $item = Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');
        return redirect()->back();
    }

    public function qty_increase($rowId)
    {
        try {
            $product = Cart::instance('wishlist')->get($rowId);
            if (!$product) {
                return response()->json(['error' => 'Wishlist item not found.'], 404);
            }

            $qty = $product->qty + 1;
            Cart::instance('wishlist')->update($rowId, $qty);

            return response()->json([
                'success' => true,
                'qty' => $qty,
                'rowId' => $rowId,
                'itemSubtotal' => number_format($qty * $product->price, 2),
                'cartSubtotal' => Cart::instance('wishlist')->subTotal(),
                'cartTotal' => Cart::instance('wishlist')->total()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function qty_reduce($rowId)
    {
        try {
            $product = Cart::instance('wishlist')->get($rowId);
            if (!$product) {
                return response()->json(['error' => 'Wishlist item not found.'], 404);
            }

            $qty = $product->qty - 1;
            if ($qty < 1) {
                return response()->json(['error' => 'Minimum quantity is 1.'], 400);
            }

            Cart::instance('wishlist')->update($rowId, $qty);

            return response()->json([
                'success' => true,
                'qty' => $qty,
                'rowId' => $rowId,
                'itemSubtotal' => number_format($qty * $product->price, 2),
                'cartSubtotal' => Cart::instance('wishlist')->subTotal(),
                'cartTotal' => Cart::instance('wishlist')->total()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }

    public function remove($rowId)
    {
        try {
            Cart::instance('wishlist')->remove($rowId);

            return response()->json([
                'success' => true,
                'redirect' => route('wishlist.index'),
                'rowId' => $rowId,
                'cartSubtotal' => Cart::instance('wishlist')->subTotal(),
                'cartTax' => Cart::instance('wishlist')->tax(),
                'cartTotal' => Cart::instance('wishlist')->total()
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Failed to remove item.'], 500);
        }
    }

    public function clear()
    {
        try {
            Cart::instance('wishlist')->destroy();

            return response()->json([
                'success' => true,
                'redirect' => route('wishlist.index')
            ]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear wishlist.'
            ], 500);
        }
    }
}
