<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        try {
            return view('user.dashboard');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function order(Request $request)
    {
        if ($request->ajax()) {
            $data = Order::with('user')
                ->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $status = strtolower($row->status);
                    $badge = match ($status) {
                        'ordered' => '<span class="badge bg-success">Ordered</span>',
                        'delivered' => '<span class="badge bg-info">Delivered</span>',
                        'canceled' => '<span class="badge bg-danger">Canceled</span>',
                        default => '<span class="badge bg-secondary">' . ucfirst($status) . '</span>',
                    };
                    return $badge;
                })
                ->addColumn('order_date', fn ($row) => $row->created_at->format('d-m-Y h:i A'))
                ->addColumn('total_item', fn ($row) => $row->orderItem->count())
                ->addColumn('delivered_on', fn ($row) => $row->delivered_at ? $row->delivered_at->format('d-m-Y') : 'Not Delivered')
                ->addColumn('action', function ($row) {
                    $viewUrl = route('user.order.view', $row->id);
                    $status = strtolower($row->status);
                    $btn = '';

                    // Show "View" button for all statuses
                    if (in_array($status, ['canceled'])) {
                        $btn .= '<a href="' . $viewUrl . '" class="btn btn-sm btn-success">View</a>';
                    }

                    // Show "Cancel" button only if status is 'ordered'
                    if (in_array($status, ['ordered', 'delivered'])) {
                        $btn .= '<a href="' . $viewUrl . '" class="btn btn-sm btn-success">View</a>';
                        $btn .= ' <button class="btn btn-sm btn-danger cancel-order-btn" data-id="' . $row->id . '">Cancel</button>';
                    }

                    return $btn;
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('user.list');
    }


    public function view($id)
    {
        try {
            $order = Order::find($id);
            return view('user.view', compact('order'));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function cancelOrder($id)
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->status === 'ordered' || $order->status === 'delivered') {
                $order->status = 'canceled';
                $order->canceled_date = Carbon::now('Asia/Kolkata');
                $order->save();
                return response()->json(['success' => true, 'message' => 'Order canceled successfully.']);
            }

            return response()->json(['success' => false, 'message' => 'Order already processed.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error canceling order.']);
        }
    }
}
