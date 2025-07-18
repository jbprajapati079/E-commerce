@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">My Account</h2>
        <div class="row">
            <div class="col-lg-3">
                <ul class="account-nav">
                    <li><a href="{{route('user.dashboard')}}" class="menu-link menu-link_us-s">Dashboard</a></li>
                    <li><a href="{{route('user.order.list')}}" class="menu-link menu-link_us-s">Orders</a></li>
                    <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
                    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
                    <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="menu-link menu-link_us-s">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>

                </ul>
            </div>
            <div class="col-lg-9">
                <div class="page-content my-account__dashboard">
                    <p>Hello <strong>User</strong></p>
                    <p>From your account dashboard you can view your <a class="unerline-link" href="account_orders.html">recent
                            orders</a>, manage your <a class="unerline-link" href="account_edit_address.html">shipping
                            addresses</a>, and <a class="unerline-link" href="account_edit.html">edit your password and account
                            details.</a></p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection