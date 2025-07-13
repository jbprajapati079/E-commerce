<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Brand::select(['id', 'name', 'slug', 'image', 'status'])->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = asset('brand/' . $row->image);
                    return '<img src="' . $url . '" width="50" height="50" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'Active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('brand.edit', $row->id);
                    $deleteUrl = route('brand.delete', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                ';
                })



                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.brand.index');
    }

    public function create()
    {
        try {
            return view('admin.brand.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:brands,slug',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('brand'), $imageName);
            }

            Brand::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imageName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Brand created successfully!',
                'redirect' => route('brand.index')
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
            $data = Brand::findOrFail($id);
            return view('admin.brand.edit', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;

        if ($request->hasFile('image')) {
            // delete old image
            if ($brand->image && file_exists(public_path('brand/' . $brand->image))) {
                unlink(public_path('brand/' . $brand->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('brand'), $filename);
            $brand->image = $filename;
        }

        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully!',
            'redirect' => route('brand.index')
        ]);
    }

    public function delete($id)
    {
        try {
            $data = Brand::findOrFail($id)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully!',
                'redirect' => route('brand.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
