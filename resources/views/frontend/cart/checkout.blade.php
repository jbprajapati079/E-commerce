@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="shop-checkout container">
        <h2 class="page-title">Shipping and Checkout</h2>
        <div class="checkout-steps">
            <a href="{{route('cart.index')}}" class="checkout-steps__item active">
                <span class="checkout-steps__item-number">01</span>
                <span class="checkout-steps__item-title">
                    <span>Shopping Bag</span>
                    <em>Manage Your Items List</em>
                </span>
            </a>
            <a href="javascript:void(0)" class="checkout-steps__item active">
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
        <form name="checkout-form" action="{{route('cart.order_place')}}" method="post">
            @csrf
            <div class="checkout-form">
                <div class="billing-info__wrapper">
                    <div class="row">
                        <div class="col-6">
                            <h4>SHIPPING DETAILS</h4>
                        </div>
                        <div class="col-6">
                        </div>
                    </div>


                    @if($address)
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="name" value="{{$address->name}}">
                                <label for="name">Full Name *</label>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="phone" value="{{$address->phone}}">
                                <label for="phone">Phone Number *</label>
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="zipcode" value="{{$address->zipcode}}">
                                <label for="zip">Pincode *</label>
                                @error('zipcode')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mt-3 mb-3">
                                <input type="text" class="form-control" name="country" value="{{$address->country}}">
                                <label for="country">Country *</label>
                                @error('country')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mt-3 mb-3">
                                <input type="text" class="form-control" name="state" value="{{$address->state}}">
                                <label for="state">State *</label>
                                @error('state')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="city" value="{{$address->city}}">
                                <label for="city">Town / City *</label>
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="address" value="{{$address->address}}">
                                <label for="address">House no, Building Name *</label>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="locality" value="{{$address->locality}}">
                                <label for="locality">Road Name, Area, Colony *</label>
                                @error('locality')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="landmark" value="{{$address->landmark}}">
                                <label for="landmark">Landmark *</label>
                                @error('landmark')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row mt-5">
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                                <label for="name">Full Name *</label>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="phone" value="{{old('phone')}}">
                                <label for="phone">Phone Number *</label>
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="zipcode" value="{{old('zipcode')}}">
                                <label for="zip">Pincode *</label>
                                @error('zipcode')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mt-3 mb-3">
                                <input type="text" class="form-control" name="country" value="{{old('country')}}">
                                <label for="country">Country *</label>
                                @error('country')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating mt-3 mb-3">
                                <input type="text" class="form-control" name="state" value="{{old('state')}}">
                                <label for="state">State *</label>
                                @error('state')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="city" value="{{old('city')}}">
                                <label for="city">Town / City *</label>
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="address" value="{{old('address')}}">
                                <label for="address">House no, Building Name *</label>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="locality" value="{{old('locality')}}">
                                <label for="locality">Road Name, Area, Colony *</label>
                                @error('locality')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating my-3">
                                <input type="text" class="form-control" name="landmark" value="{{old('landmark')}}">
                                <label for="landmark">Landmark *</label>
                                @error('landmark')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
                <div class="checkout__totals-wrapper">
                    <div class="sticky-content">
                        <div class="checkout__totals">
                            <h3>Your Order</h3>
                            <table class="checkout-cart-items">
                                <thead>
                                    <tr>
                                        <th>PRODUCT</th>
                                        <th align="right">SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(Cart::instance('cart') as $item)
                                    <tr>
                                        <td>
                                            {{$item->name}} x {{$item->qty}}
                                        </td>
                                        <td align="right">
                                            {{$item->subtotal()}}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <table class="checkout-totals">
                                <tbody>
                                    <tr>
                                        <th>SUBTOTAL</th>
                                        <td align="right">{{Cart::instance('cart')->subtotal()}}</td>
                                    </tr>

                                    <tr>
                                        <th>SHIPPING</th>
                                        <td align="right">Free shipping</td>
                                    </tr>
                                    @if(session('applied_coupon'))
                                    <tr>
                                        <th>Discount ({{ session('applied_coupon.discount_percent') }}%)</th>
                                        <td align="right">- ${{ number_format(session('applied_coupon.discount_amount'), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>TOTAL</th>
                                        <td align="right">${{ number_format(floatval(str_replace(',', '', Cart::instance('cart')->subtotal())) - session('applied_coupon.discount_amount'), 2) }}
                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <th>TOTAl</th>
                                        <td align="right">${{ Cart::instance('cart')->subtotal() }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="checkout__payment-methods">
                            <!-- <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode1" value="card">
                                <label class="form-check-label" for="mode1">
                                    Debit or Credit Card
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode2" value="paypal">
                                <label class="form-check-label" for="mode2">
                                    Paypal
                                </label>
                            </div> -->
                            <div class="form-check">
                                <input class="form-check-input form-check-input_fill" type="radio" name="mode" id="mode3" value="cod" checked>
                                <label class="form-check-label" for="mode3">
                                    Cash on delivery
                                </label>
                                @error('mode')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="policy-text">
                                Your personal data will be used to process your order, support your experience throughout this
                                website, and for other purposes described in our <a href="terms.html" target="_blank">privacy
                                    policy</a>.
                            </div>
                        </div>
                        <button class="btn btn-primary btn-checkout">PLACE ORDER</button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</main>
@endsection