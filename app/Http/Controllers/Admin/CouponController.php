<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Coupon::orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('expiry_date', function ($row) {
                    return Carbon::parse($row->expiry_date)->format('d-m-Y');
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('coupon.edit', $row->id);
                    $deleteUrl = route('coupon.delete', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger delete-btn" data-id="' . $row->id . '" id="delete">Delete</button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.coupon.index');
    }

    public function create()
    {
        try {
            return view('admin.coupon.add');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255',
                'type' => 'required',
                'value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'cart_value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'expiry_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            Coupon::create([
                'code' => $request->code,
                'type' => $request->type,
                'value' => $request->value,
                'cart_value' => $request->cart_value,
                'expiry_date' => $request->expiry_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coupon created successfully!',
                'redirect' => route('coupon.index')
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
            $data = Coupon::findOrFail($id);
            return view('admin.coupon.edit', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255',
                'type' => 'required',
                'value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'cart_value' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
                'expiry_date' => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }


            Coupon::findOrFail($id)->update([
                'code' => $request->code,
                'type' => $request->type,
                'value' => $request->value,
                'cart_value' => $request->cart_value,
                'expiry_date' => $request->expiry_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Coupon updated successfully!',
                'redirect' => route('coupon.index')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!',
                'error' => $th->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $data = Coupon::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted successfully!',
                'redirect' => route('coupon.index')
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
