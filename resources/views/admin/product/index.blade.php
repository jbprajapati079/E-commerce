@extends('layouts.admin')
@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
        <div>
            <a href="{{ route('product.add') }}" class="btn btn-sm btn-primary">Add</a>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="producttable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Category</th>
                                    <th>Brand</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Stoke</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QR Scanner Modal -->
<div class="modal fade" id="qrScanModal" tabindex="-1" aria-labelledby="qrScanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Scan Product QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div id="qr-reader" style="width: 500px; margin:auto;"></div>
                <div id="qr-result" class="mt-3 text-success fw-bold"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include html5-qrcode script -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('#producttable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('product.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'slug',
                    name: 'slug',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'category',
                    name: 'category.name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'brand',
                    name: 'brand.name',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'price',
                    name: 'price',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'stock_status',
                    name: 'stock_status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'featured',
                    name: 'featured',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });

    $(document).on('click', '#delete', function(e) {
        e.preventDefault();

        let id = $(this).data('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "/product/delete/" + id,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-HTTP-Method-Override': 'DELETE'
                    },
                    success: function(response) {
                        setTimeout(function() {
                            toastr.success(response.message);
                            window.location.href = response.redirect;
                        }, 1500);
                    },
                    error: function(xhr) {
                        Swal.fire("Error", "Could not delete product", "error");
                    }
                });
            }
        });
    });
</script>
@endpush