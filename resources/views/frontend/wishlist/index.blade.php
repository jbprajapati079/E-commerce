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
        <div class="shopping-cart">

            @if($item->count()>0)

            <div class="cart-table__wrapper">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th></th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($item as $value)
                        <tr>
                            <td>
                                <div class="shopping-cart__product-item">
                                    <img loading="lazy" src="{{asset('product/image/'.$value->model->image)}}" width="120" height="120" alt="{{$value->name}}" />
                                </div>
                            </td>
                            <td>
                                <div class="shopping-cart__product-item__detail">
                                    <h4>{{$value->name}}</h4>
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
                                <div class="qty-control position-relative" data-row-id="{{ $value->rowId }}">
                                    <input type="number" name="quantity" value="{{$value->qty}}" min="1" class="qty-control__number text-center">


                                    <div class="qty-control__reduce">-</div>

                                    <div class="qty-control__increase" style="cursor: pointer;">+</div>


                                </div>
                            </td>
                            <td>
                                <span class="shopping-cart__subtotal" data-row-id="{{ $value->rowId }}">
                                    ${{ number_format($value->qty * $value->price, 2) }}
                                </span>
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
                <div class="cart-table-footer">
                    <form action="#" class="position-relative bg-body">
                        <input class="form-control" type="text" name="coupon_code" placeholder="Coupon Code">
                        <input class="btn-link fw-medium position-absolute top-0 end-0 h-100 px-4" type="submit" value="APPLY COUPON">
                    </form>
                    <button class="btn btn-light" id="clear-cart-btn">CLEAR WISHLIST</button>
                </div>
            </div>
            <div class="shopping-cart__totals-wrapper">
                <div class="sticky-content">
                    <div class="shopping-cart__totals">
                        <h3>Cart Totals</h3>
                        <table class="cart-totals">
                            <tbody>
                                <tr>
                                    <th>Subtotal</th>
                                    <td class="cart-subtotal-value">${{ Cart::instance('wishlist')->subTotal() }}</td>
                                </tr>
                                <tr>
                                    <th>Shipping</th>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td class="cart-total-value">${{ Cart::instance('wishlist')->total() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mobile_fixed-btn_wrapper">
                        <div class="button-wrapper container">
                            <a href="checkout.html" class="btn btn-primary btn-checkout">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
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
    $(document).ready(function() {
        function updateWishlistDisplay(response, control) {
            control.find('.qty-control__number').val(response.qty);
            $('.shopping-cart__subtotal[data-row-id="' + response.rowId + '"]').text(`$${response.itemSubtotal}`);
            $('.cart-subtotal-value').text(`$${response.cartSubtotal}`);
            $('.cart-total-value').text(`$${response.cartTotal}`);
        }

        $('.qty-control__increase').click(function() {
            let control = $(this).closest('.qty-control');
            let rowId = control.data('row-id');

            $.ajax({
                url: `/wishlist/qty-increase/${rowId}`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        updateWishlistDisplay(response, control);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.error || 'Error increasing quantity');
                }
            });
        });

        $('.qty-control__reduce').click(function() {
            let control = $(this).closest('.qty-control');
            let rowId = control.data('row-id');

            $.ajax({
                url: `/wishlist/qty-reduce/${rowId}`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        updateWishlistDisplay(response, control);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.error || 'Error decreasing quantity');
                }
            });
        });
    });

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