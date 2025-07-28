@extends('layouts.admin')
@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
        <a href="{{ route('product.add') }}" class="btn btn-sm btn-primary">Add</a>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4>QR Code for Product: {{ $product->name }}</h4>
                    <div>{!! $qrCode !!}</div>
                    <p>Scan to view product details.</p>
                    <a href="{{ route('product.qr.view', $product->id) }}" class="btn btn-primary" target="_blank">Open Product</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection