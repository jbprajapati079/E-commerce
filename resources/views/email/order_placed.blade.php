<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        .row-box {
            display: flex;
            gap: 20px;
            /* space between boxes */
            margin-bottom: 20px;
        }

        .box {
            flex: 1;
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 8px;
        }

        .box-title {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .badge-paid {
            color: white;
            background-color: green;
            padding: 3px 8px;
            border-radius: 4px;
        }

        .badge-pending {
            color: black;
            background-color: yellow;
            padding: 3px 8px;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h2>Thank you for your order!</h2>
    <p>Hi {{ $order->name }},</p>

    <p>Your order <strong>#{{ $order->order_id }}</strong> has been placed successfully.</p>



    <div class="row-box">
        <!-- Shipping Address -->
        <div class="box">
            <h3 class="box-title">Shipping Address</h3>
            <p><strong>Name:</strong> {{ $order->name }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Address:</strong><br>
                {{ $order->address }}<br>
                {{ $order->locality }}, {{ $order->city }}, {{ $order->state }} - {{ $order->zipcode }}<br>
                {{ $order->country }}
            </p>
            <p><strong>Landmark:</strong> {{ $order->landmark ?? '-' }}</p>
        </div>

        <!-- Transaction Info -->
        <div class="box">
            <h3 class="box-title">Transaction Info</h3>
            <p><strong>Payment Method:</strong> {{ $order->payment_method ?? 'COD' }}</p>
            <p><strong>Transaction ID:</strong> {{ optional($order->transaction)->transaction_id ?? '--' }}</p>

            <p><strong>Payment Status:</strong>
                @if($order->payment_status == 'paid')
                <span class="badge-paid">Paid</span>
                @else
                <span class="badge-pending">Pending</span>
                @endif
            </p>
        </div>
    </div>


    <h3>Order Summary</h3>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            @foreach($items as $key => $item)
            <tr style="text-align: center;">
                <td>{{ $key + 1 }}</td>
                <td>
                    <img src="{{ asset('product/image/' . $item->product->image) }}" alt="{{ $item->product->name }}" width="50" height="50" style="border-radius: 50%;">
                </td>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->qty * $item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>

        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Subtotal:</strong></td>
                <td>₹{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Discount:</strong></td>
                <td>- ₹{{ number_format($order->discount_amount, 2) }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align: right;"><strong>Final Price:</strong></td>
                <td><strong>₹{{ number_format($order->total, 2) }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <p>We will notify you once your order is shipped.</p>
    <p>Thank you for shopping with us!</p>
</body>

</html>