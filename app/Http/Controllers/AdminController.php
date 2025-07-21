<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $year = now()->year;

            $orders = DB::table('orders')
                ->select(
                    DB::raw("MONTH(created_at) as month"),
                    DB::raw("SUM(CASE WHEN status = 'ordered' THEN total ELSE 0 END) as ordered_price"),
                    DB::raw("SUM(CASE WHEN status = 'ordered' THEN 1 ELSE 0 END) as ordered_count"),

                    DB::raw("SUM(CASE WHEN status = 'delivered' THEN total ELSE 0 END) as delivered_price"),
                    DB::raw("SUM(CASE WHEN status = 'delivered' THEN 1 ELSE 0 END) as delivered_count"),

                    DB::raw("SUM(CASE WHEN status = 'canceled' THEN total ELSE 0 END) as canceled_price"),
                    DB::raw("SUM(CASE WHEN status = 'canceled' THEN 1 ELSE 0 END) as canceled_count")
                )
                ->whereYear('created_at', $year)
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->get();

            $monthly = array_fill(0, 12, [

                'ordered_price' => 0,
                'ordered_count' => 0,

                'delivered_price' => 0,
                'delivered_count' => 0,

                'canceled_price' => 0,
                'canceled_count' => 0,
            ]);

            foreach ($orders as $order) {
                $i = $order->month - 1;
                $monthly[$i] = [

                    'ordered_price' => (float) $order->ordered_price,
                    'ordered_count' => (int) $order->ordered_count,

                    'delivered_price' => (float) $order->delivered_price,
                    'delivered_count' => (int) $order->delivered_count,

                    'canceled_price' => (float) $order->canceled_price,
                    'canceled_count' => (int) $order->canceled_count,
                ];
            }


            return view('admin.dashboard', [
                'categorytotal' => Category::where('status', 'Active')->count(),
                'brandtotal' => Brand::where('status', 'Active')->count(),
                'producttotal' => Product::where('status', 'Active')->count(),
                'totalordertotal' => Order::count(),
                'ordertotal' => Order::where('status', 'ordered')->count(),
                'deliveredtotal' => Order::where('status', 'delivered')->count(),
                'canceledtotal' => Order::where('status', 'canceled')->count(),

                // Chart data

                'orderedPrices' => array_column($monthly, 'ordered_price'),
                'orderedCounts' => array_column($monthly, 'ordered_count'),

                'deliveredPrices' => array_column($monthly, 'delivered_price'),
                'deliveredCounts' => array_column($monthly, 'delivered_count'),

                'canceledPrices' => array_column($monthly, 'canceled_price'),
                'canceledCounts' => array_column($monthly, 'canceled_count'),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function profile(Request $request)
    {
        try {
            $data = Auth::user();
            return view('admin.profile', compact('data'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function profile_update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'mobile' => 'required|digits:10',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);


            User::findOrFail($id)->update([]);

            $data = User::findOrFail($id);
            $data->name = $request->name;
            $data->email = $request->email;
            $data->mobile = $request->mobile;

            if ($request->hasFile('image')) {
                // delete old image
                if ($data->image && file_exists(public_path('admin/profile/' . $data->image))) {
                    unlink(public_path('admin/profile/' . $data->image));
                }

                $file = $request->file('image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('admin/profile'), $filename);
                $data->image = $filename;
            }

            $data->save();
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'redirect' => url()->previous()
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
