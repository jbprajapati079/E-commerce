<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $data = Slide::where('status', 'Active')->take(3)->get();
            $categories = Category::where('status', 'Active')->get();
            $products = Product::where('status', 'Active')->take(4)->get();
            $fproducts = Product::where('status', 'Active')->where('featured', 1)->take(4)->get();
            return view('index', compact('data', 'categories', 'products', 'fproducts'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function search(Request $request)
    {
        $keyword = $request->input('search_keyword');

        if (!$keyword) {
            return response()->json([
                'status' => false,
                'html' => '<p class="text-danger">Please enter a keyword.</p>'
            ]);
        }

        $products = \App\Models\Product::where('name', 'LIKE', "%{$keyword}%")->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'html' => '<p class="text-danger">No products found.</p>'
            ]);
        }

        $html = '';
        foreach ($products as $product) {
            $imageUrl = asset('product/image/' . $product->image); // path to image
            $productUrl = route('shop.product_detail', $product->slug); // detail page URL

            $html .= '<a href="' . $productUrl . '" class="text-decoration-none text-dark">';
            $html .= '<div class="border p-3 mb-3 d-flex align-items-start gap-3">';
            $html .= '<img src="' . $imageUrl . '" alt="' . e($product->name) . '" style="width: 80px; height: 80px; object-fit: cover;">';
            $html .= '<div>';
            $html .= '<strong>' . e($product->name) . '</strong><br>';
            $html .= 'Price: ₹' . number_format($product->price, 2);
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</a>';
        }

        return response()->json([
            'status' => true,
            'html' => $html
        ]);
    }
}
