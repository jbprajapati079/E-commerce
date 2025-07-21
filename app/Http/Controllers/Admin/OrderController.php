<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with(['user','orderItem'])->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = strtolower($row->status); // normalize to lowercase

                    switch ($status) {
                        case 'ordered':
                            $badge = '<span class="badge bg-success">Ordered</span>';
                            break;
                        case 'delivered':
                            $badge = '<span class="badge bg-info">Delivered</span>';
                            break;
                        case 'canceled':
                            $badge = '<span class="badge bg-danger">Cancelled</span>';
                            break;
                        default:
                            $badge = '<span class="badge bg-secondary">' . ucfirst($status) . '</span>';
                            break;
                    }

                    return $badge;
                })

                // ->addColumn('order_date', function ($row) {
                //     return $row->created_at->format('d-m-Y h:i A');
                // })

                ->addColumn('order_date', function ($row) {
                    return $row->created_at
                        ? \Carbon\Carbon::parse($row->created_at)->format('d M Y, h:i A')
                        : '--';
                })

                ->addColumn('total_item', function ($row) {
                    return $row->orderItem->count();
                })

                ->addColumn('delivered_on', function ($row) {
                    return $row->delivered_date
                        ? \Carbon\Carbon::parse($row->delivered_date)->format('d M Y, h:i A')
                        : '--';
                })

                ->addColumn('action', function ($row) {
                    $viewUrl = route('order.view', $row->id);

                    return '
                        <a href="' . $viewUrl . '" class="btn btn-sm btn-success">View</a>
                        <button class="btn btn-sm btn-warning updateStatusBtn" 
                            data-id="' . $row->id . '" 
                            data-status="' . $row->status . '">
                            Update Status
                        </button>
                    ';
                })


                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.order.index');
    }


    public function view($id)
    {
        try {

            $order = Order::find($id);
            return view('admin.order.view', compact('order'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);


        if ($request->status == 'ordered') {
            $order->status = $request->status;
            $order->updated_at = Carbon::now('Asia/Kolkata');
            $order->save();
        } elseif ($request->status == 'delivered') {
            $order->status = $request->status;
            $order->delivered_date = Carbon::now('Asia/Kolkata');
            $order->save();
        } elseif ($request->status == 'canceled') {
            $order->status = $request->status;
            $order->canceled_date = Carbon::now('Asia/Kolkata');
            $order->save();
        }

        $order->save();

        return response()->json(['message' => 'Order status updated successfully.']);
    }
}
