<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::select(['id', 'name', 'slug', 'image', 'status'])->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = asset('category/' . $row->image);
                    return '<img src="' . $url . '" width="50" height="50" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'Active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('category.edit', $row->id);
                    $deleteUrl = route('category.delete', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                ';
                })



                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.category.index');
    }

    public function create()
    {
        try {
            return view('admin.category.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('category'), $imageName);
            }

            Category::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'image' => $imageName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'redirect' => route('category.index')
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
            $data = Category::findOrFail($id);
            return view('admin.category.edit', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;

        if ($request->hasFile('image')) {
            // delete old image
            if ($category->image && file_exists(public_path('category/' . $category->image))) {
                unlink(public_path('category/' . $category->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('category'), $filename);
            $category->image = $filename;
        }

        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Category updated successfully!',
            'redirect' => route('category.index')
        ]);
    }

    public function delete($id)
    {
        try {
            $data = Category::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!',
                'redirect' => route('category.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
