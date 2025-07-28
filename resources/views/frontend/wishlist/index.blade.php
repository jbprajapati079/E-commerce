@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Cart</h2>
        <div class="checkout-steps">
            <a href="javascript:void(0)" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">02</span>
                <span class="checkout-steps__item-title">
                    <span>Shipping and Checkout</span>
                    <em>Checkout Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item">
                <span class="checkout-steps__item-number">03</span>
                <span class="checkout-steps__item-title">
                    <span>Confirmation</span>
                    <em>Review And Submit Your Order</em>
                </span>
            </a>
        </div>

        @if($items->count()>0)
        <div class="mt-3">
            <button class="btn btn-light" id="clear-cart-btn">CLEAR WISHLIST</button>
        </div>
        @endif
        <div class="shopping-cart">

            @if($items->count()>0)

            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($items as $value)
                        <tr>
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{asset('product/image/'.$value->model->image)}}" width="120" height="120" alt="{{$value->name}}" />
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>
                                        <a href="{{ route('shop.product_detail', $value->slug) }}">{{$value->name}}</a>
                                    </h4>
                                    <ul class="shopping-cart__product-item__options">
                                        <li>Color: Yellow</li>
                                        <li>Size: L</li>
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__product-price">${{$value->price}}</span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="remove-cart" data-row-id="{{ $value->rowId }}">
                                    <svg width="10" height="10" viewBox="0 0 10 10" fill="#767676" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0.259435 8.85506L9.11449 0L10 0.885506L1.14494 9.74056L0.259435 8.85506Z" />
                                        <path d="M0.885506 0.0889838L9.74057 8.94404L8.85506 9.82955L0 0.97449L0.885506 0.0889838Z" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p>No item found</p>
            <a href="{{route('shop.index')}}" class="btn btn-info">shop now</a>
            @endif
        </div>
    </section>
</main>
@endsection


@push('scripts')
<script>
    $('.remove-cart').click(function() {
        const rowId = $(this).data('row-id');

        $.ajax({
            url: `/wishlist/remove/${rowId}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Remove row from table
                    $('#cart-row-' + response.rowId).remove();

                    // Update totals
                    $('.cart-subtotal-value').text(`$${response.cartSubtotal}`);
                    $('.cart-tax-value').text(`$${response.cartTax}`);
                    $('.cart-total-value').text(`$${response.cartTotal}`);
                    window.location.reload()

                    toastr.success('Item removed from wishlist successfully!');
                }
            },
            error: function(xhr) {
                toastr.error('Failed to remove item. Please try again.');
            }
        });
    });


    $(document).on('click', '#clear-cart-btn', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "This will remove all items from your cart.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, clear it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('wishlist.clear') }}",
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            // Clear cart rows
                            $('.cart-table tbody').empty();

                            // Reset totals
                            $('.cart-subtotal-value').text(`$0`);
                            $('.cart-tax-value').text(`$0`);
                            $('.cart-total-value').text(`$0`);

                            // Show Toastr message
                            window.location.href = response.redirect;
                            toastr.success('wishlist cleared successfully!');
                        }
                    },
                    error: function() {
                        toastr.error('Failed to clear the wishlist. Please try again.');
                    }
                });
            }
        });
    });
</script>
@endpush