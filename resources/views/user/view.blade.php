@extends('layouts.app')

@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Order Details</h2>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <ul class="account-nav">
                    <li><a href="{{ route('user.dashboard') }}" class="menu-link">Dashboard</a></li>
                    <li><a href="{{ route('user.order.list') }}" class="menu-link">Orders</a></li>
                    <li><a href="{{ url('/account-addresses') }}" class="menu-link">Addresses</a></li>
                    <li><a href="{{ url('/account-details') }}" class="menu-link">Account Details</a></li>
                    <li><a href="{{ url('/account-wishlists') }}" class="menu-link">Wishlist</a></li>
                    <li>
                        <form method="POST" action="{{ url('/logout') }}" id="logout-form">
                            @csrf
                            <a href="{{ url('/logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        </form>
                    </li>
                </ul>
            </div>

            <div class="col-lg-10">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">Order Details</div>
                            <div class="card-body">
                                <p><strong>Order ID:</strong> #{{ $order->order_id }}</p>
                                <p><strong>Status</strong>
                                    @if($order->status == 'ordered')
                                    <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                                    @elseif($order->status == 'delivered')
                                    <td><span class="badge bg-info">{{ ucfirst($order->status) }}</span></td>
                                    @elseif($order->status == 'canceled')
                                    <td><span class="badge bg-danger">{{ ucfirst($order->status) }}</span></td>
                                    @endif
                                </p>
                                <p><strong>Subtotal:</strong> ₹{{ number_format($order->subtotal, 2) }}</p>
                                <p><strong>Discount:</strong> ₹{{ number_format($order->discount, 2) }}</p>
                                <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
                                <p><strong>Ordered On:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                                <p><strong>Delivered On:</strong> {{ $order->delivered_date ? \Carbon\Carbon::parse($order->delivered_date)->format('d M Y h:i A') : '--' }}</p>
                                <p><strong>Cancelled On:</strong>{{ $order->canceled_date ? \Carbon\Carbon::parse($order->canceled_date)->format('d M Y h:i A') : '--' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
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

                <div class="card mb-4">
                    <div class="card-header bg-info text-white">Order Items</div>
                    <div class="card-body">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
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
                                        <img src="{{ asset('product/image/' . $item->product->image) }}" width="60" height="60" alt="Product Image">
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

                <div class="card mb-4 col-md-6">
                    <div class="card-header bg-success text-white">Transaction Info</div>
                    <div class="card-body">
                        <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'COD' }}</p>
                        <p><strong>Transaction ID:</strong> {{ $order->transaction->transaction_id ?? '-' }}</p>
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
    </section>
</main>
@endsection