@extends('layouts.admin')

@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
        </ol>
        <a href="{{ route('product.index') }}" class="btn btn-sm btn-primary">Back</a>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card shadow rounded">
                <div class="card-body">
                    <h4 class="card-title mb-4">Product Details</h4>
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <img src="{{ asset('product/image/' . $product->image) }}" class="img-fluid rounded shadow-sm border" alt="Product Image">
                        </div>
                        <div class="col-md-8">
                            <table class="table table-borderless">
                                <tr>
                                    <th>Name</th>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td>{{ $product->slug }}</td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                                <tr>
                                    <th>Brand</th>
                                    <td>{{ $product->brand->name }}</td>
                                </tr>
                                <tr>
                                    <th>Quantity</th>
                                    <td>{{ $product->quantity }}</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>₹{{ number_format($product->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($product->status === 'Active')
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Featured</th>
                                    <td>
                                        @if ($product->featured)
                                        <span class="badge bg-info">Yes</span>
                                        @else
                                        <span class="badge bg-secondary">No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection