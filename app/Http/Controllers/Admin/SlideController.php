<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SlideController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Slide::orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $url = asset('slider/' . $row->image);
                    return '<img src="' . $url . '" width="50" height="50" />';
                })
                ->addColumn('status', function ($row) {
                    return $row->status === 'Active'
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('slide.edit', $row->id);
                    $deleteUrl = route('slide.delete', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                ';
                })



                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admin.slide.index');
    }

    public function create()
    {
        try {
            return view('admin.slide.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'tagline' => 'required|string',
                'title' => 'required|string|',
                'subtitle' => 'required|string|',
                'link' => 'required|string|',
                'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalName();
                $image->move(public_path('slider'), $imageName);
            }

            Slide::create([
                'tagline' => $request->tagline,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'link' => $request->link,
                'image' => $imageName,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Slider created successfully!',
                'redirect' => route('slide.index')
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
            $data = Slide::findOrFail($id);
            return view('admin.slide.edit', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'tagline' => 'required|string',
            'title' => 'required|string|',
            'subtitle' => 'required|string|',
            'link' => 'required|string|',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $slide = Slide::findOrFail($id);
        $slide->tagline = $request->tagline;
        $slide->title = $request->title;
        $slide->subtitle = $request->subtitle;
        $slide->link = $request->link;
        $slide->status = $request->status;

        if ($request->hasFile('image')) {
            // delete old image
            if ($slide->image && file_exists(public_path('slider/' . $slide->image))) {
                unlink(public_path('slider/' . $slide->image));
            }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('slider'), $filename);
            $slide->image = $filename;
        }

        $slide->save();

        return response()->json([
            'success' => true,
            'message' => 'Slider updated successfully!',
            'redirect' => route('slide.index')
        ]);
    }

    public function delete($id)
    {
        try {
            $data = Slide::findOrFail($id)->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Slide deleted successfully!',
                'redirect' => route('slide.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
