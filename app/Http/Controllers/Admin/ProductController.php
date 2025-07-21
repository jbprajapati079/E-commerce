<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with(['category', 'brand'])->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = asset('product/image/' . $row->image);
                    return '<img src="' . $url . '" width="50" height="50" />';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })

                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })

                ->addColumn('stock_status', function ($row) {
                    return $row->stock_status === 'in_stock'
                        ? '<span class="badge bg-success">In Stock</span>'
                        : '<span class="badge bg-danger">Out Of Stock</span>';
                })

                ->addColumn('status', function ($row) {
                    return $row->status === 'Active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('featured', function ($row) {
                    return $row->featured == true
                        ? '<span class="badge bg-success">Yes</span>'
                        : '<span class="badge bg-danger">No</span>';
                })

                ->addColumn('action', function ($row) {
                    $editUrl = route('product.edit', $row->id);
                    $deleteUrl = route('product.delete', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                    ';
                })

                ->rawColumns(['image', 'stock_status', 'status', 'featured', 'action'])
                ->make(true);
        }

        return view('admin.product.index');
    }

    public function create()
    {
        try {
            $categories = Category::where('status', 'Active')->get();
            $brands = Brand::where('status', 'Active')->get();
            $sizes = Size::all();
            return view('admin.product.add', compact(['categories', 'brands', 'sizes']));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'category_id'     => 'required',
                'brand_id'        => 'required',
                'size'            => 'required',
                'name'            => 'required|string|max:255',
                'slug'            => 'required|string|max:255|unique:products,slug',
                'quantity'        => 'required|integer|min:1',
                'price'           => 'required|numeric|min:10',
                'sale_price'      => 'nullable|numeric|min:0|lte:price',
                'SKU'             => 'nullable|string|max:255',
                'stock_status'    => 'required',
                'featured'        => 'nullable',
                'image'           => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
                'gallery'         => 'nullable|array',
                'gallery.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('product/image'), $imageName);
            }

            $galleryPaths = [];

            if ($request->hasFile('gallery')) {
                foreach ($request->file('gallery') as $file) {
                    $galleryfilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('product/gallery'), $galleryfilename);
                    $galleryPaths[] =  $galleryfilename;
                }
            }

            Product::create([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'name' => $request->name,
                'slug' => $request->slug,
                'short_description' => $request->short_description,
                'description' => $request->description,
                'quantity' => $request->quantity,
                'price' => $request->price,
                'sale_price' => $request->sale_price,
                'SKU' => $request->SKU,
                'stock_status' => $request->stock_status,
                'featured' => $request->featured ? true : false,
                'size' => $request->size,
                'image' => $imageName,
                'gallery' => json_encode($galleryPaths),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully!',
                'redirect' => route('product.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }


    public function edit($id)
    {
        try {
            $categories = Category::where('status', 'Active')->get();
            $brands = Brand::where('status', 'Active')->get();
            $sizes = Size::all();
            $data = Product::findOrFail($id);
            return view('admin.product.edit', compact(['categories', 'brands', 'data','sizes']));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'category_id'     => 'required',
            'brand_id'        => 'required',
            'size'            => 'required',
            'name'            => 'required|string|max:255',
            'slug'            => 'required|string|max:255|unique:products,slug' . $id,
            'quantity'        => 'required|integer|min:1',
            'price'           => 'required|numeric|min:10',
            'sale_price'      => 'nullable|numeric|min:0|lte:price',
            'SKU'             => 'nullable|string|max:255',
            'stock_status'    => 'required',
            'featured'        => 'nullable',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery'         => 'nullable|array',
            'gallery.*'       => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = Product::findOrFail($id);
        $filename = $data->image;

        if ($request->hasFile('image')) {
            // delete old image
            if ($data->image && file_exists(public_path('product/image/' . $data->image))) {
                unlink(public_path('product/image/' . $data->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('product/image/'), $filename);
        }

        $galleryPaths = json_decode($data->gallery, true) ?? [];

        if ($request->hasFile('gallery')) {
            if ($data->gallery) {
                foreach (json_decode($data->gallery, true) as $oldImagePath) {
                    $fullPath = public_path('product/gallery/' . $oldImagePath);
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            $galleryPaths = [];

            foreach ($request->file('gallery') as $file) {
                $galleryfilename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('product/gallery'), $galleryfilename);
                $galleryPaths[] = $galleryfilename;
            }
        }


        $data->category_id = $request->category_id;
        $data->brand_id = $request->brand_id;
        $data->name = $request->name;
        $data->slug = $request->slug;
        $data->short_description = $request->short_description;
        $data->description = $request->description;
        $data->quantity = $request->quantity;
        $data->price = $request->price;
        $data->sale_price = $request->sale_price;
        $data->SKU = $request->SKU;
        $data->stock_status = $request->stock_status;
        $data->featured = $request->featured ? true : false;
        $data->size = $request->size;
        $data->status = $request->status;
        $data->image = $filename;
        $data->gallery = json_encode($galleryPaths);
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully!',
            'redirect' => route('product.index')
        ]);
    }

    public function delete($id)
    {
        try {
            $data = Product::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!',
                'redirect' => route('product.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
