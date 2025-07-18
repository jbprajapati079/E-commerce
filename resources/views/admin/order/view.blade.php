@extends('layouts.admin')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
            <li class="breadcrumb-item active" aria-current="page">View Order</li>
        </ol>
        <a href="{{ route('order.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <!-- Order Info -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-primary text-white">Order Details</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Order ID</th>
                                <td>#{{ $order->order_id }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                @if($order->status == 'ordered')
                                <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                                @elseif($order->status == 'delivered')
                                <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                                @elseif($order->status == 'canceled')
                                <td><span class="badge bg-danger">{{ ucfirst($order->status) }}</span></td>
                                @endif
                            </tr>
                            <tr>
                                <th>Subtotal</th>
                                <td>₹{{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Discount</th>
                                <td>₹{{ number_format($order->discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>₹{{ number_format($order->total, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Ordered On</th>
                                <td>{{ $order->created_at?->format('d M Y, h:i A') ?? $order->updated_at?->format('d M Y, h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>Delivered On</th>
                                <td>
                                    {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d M Y h:i A') : '--' }}
                                </td>

                            </tr>
                            <tr>
                                <th>Cancelled On</th>
                                <td>  {{ $order->canceled_date ? \Carbon\Carbon::parse($order->canceled_date)->format('d M Y h:i A') : '--' }}</td>
                               
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Shipping Info -->
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-secondary text-white">Shipping Address</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->name }}</p>
                    <p><strong>Phone:</strong> {{ $order->phone }}</p>
                    <p><strong>Address:</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->locality }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zipcode }}<br>
                        {{ $order->country }}
                    </p>
                    <p><strong>Landmark:</strong> {{ $order->landmark ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Table -->
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-info text-white">Order Items</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Price (₹)</th>
                                <th>Qty</th>
                                <th>Total (₹)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItem as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset('product/image/' . $item->product->image) }}" width="60" height="60">
                                </td>
                                <td>{{ $item->product->name ?? '--' }}</td>
                                <td>{{ $item->product->SKU ?? '--' }}</td>
                                <td>{{ $item->product->category->name ?? '--' }}</td>
                                <td>{{ $item->product->brand->name ?? '--' }}</td>
                                <td>{{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ number_format($item->price * $item->qty, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Info -->
    <div class="row">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header bg-success text-white">Transaction Info</div>
                <div class="card-body">
                    <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'COD' }}</p>
                    <p><strong>Transaction ID:</strong> {{ optional($order->transaction)->transaction_id ?? '--' }}</p>

                    <p><strong>Payment Status:</strong>
                        @if($order->payment_status == 'paid')
                        <span class="badge bg-success">Paid</span>
                        @else
                        <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection