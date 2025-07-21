<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        try {
            $order = $request->query('order') ?? -1;
            $filter_brand = $request->query('brands');
            $filter_category = $request->query('category');
            $min_price = $request->query('min_price') ? $request->query('min_price') : 10;
            $max_price = $request->query('max_price') ? $request->query('max_price') : 15000;

            $sizes_selected = explode(',', $request->query('sizes', ''));
            switch ($order) {
                case 1:
                    $o_column = 'created_at';
                    $o_order = 'ASC';
                    break;
                case 2:
                    $o_column = 'created_at';
                    $o_order = 'DESC';
                    break;
                case 3:
                    $o_column = 'price';
                    $o_order = 'ASC';
                    break;
                case 4:
                    $o_column = 'price';
                    $o_order = 'DESC';
                    break;
                default:
                    $o_column = 'id';
                    $o_order = 'DESC';
            }
            $brands = Brand::where('status', 'Active')->get();
            $categories = Category::where('status', 'Active')->get();
            $sizes = Size::get();

            $query = Product::query();

            // brand filter
            if ($request->brands) {
                $query->whereIn('brand_id', explode(',', $filter_brand));
            }

            // category filter
            if ($request->category) {
                $query->whereIn('category_id', explode(',', $filter_category));
            }

            //size
            if ($request->sizes) {
                $filter_sizes = explode(',', $request->sizes);
                $query->whereHas('sizes', function ($q) use ($filter_sizes) {
                    $q->whereIn('sizes.id', $filter_sizes);
                });
            }
            // price filter
            if ($request->min_price) {
                $minPrice = $request->min_price;
                $query->where(function ($q) use ($minPrice) {
                    $q->where('price', '>=', $minPrice)
                        ->orWhere('sale_price', '>=', $minPrice);
                });
            }

            if ($request->max_price) {
                $maxPrice = $request->max_price;
                $query->where(function ($q) use ($maxPrice) {
                    $q->where('price', '<=', $maxPrice)
                        ->orWhere('sale_price', '<=', $maxPrice);
                });
            }
            $query->orderBy($o_column, $o_order);

            $data = $query->paginate(6)->withQueryString();
            return view('frontend.shop.index', compact('data', 'order', 'brands', 'sizes','sizes_selected', 'filter_brand', 'categories', 'filter_category', 'min_price', 'max_price'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function product_details($slug_id)
    {
        try {
            $data = Product::with(['category', 'brand'])->where('slug', $slug_id)->first();
            $related_products = Product::with(['category', 'brand'])->where('slug', '!=', $slug_id)->get();
            return view('frontend.shop.product_detail', compact('data', 'related_products'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
