<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class SizeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Size::orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('size.edit', $row->id);
                    $deleteUrl = route('size.delete', $row->id);
                    return '
                    <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                    <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                ';
                })



                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.size.index');
    }

    public function create()
    {
        try {
            return view('admin.size.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:sizes,name',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            Size::create([
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Size created successfully!',
                'redirect' => route('size.index')
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
            $data = Size::findOrFail($id);
            return view('admin.size.edit', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sizes,name,' . $id,
        ]);

        $size = Size::findOrFail($id);
        $size->name = $request->name;
        $size->save();

        return response()->json([
            'success' => true,
            'message' => 'Size updated successfully!',
            'redirect' => route('size.index')
        ]);
    }

    public function delete($id)
    {
        try {
            $data = Size::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Size deleted successfully!',
                'redirect' => route('size.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
