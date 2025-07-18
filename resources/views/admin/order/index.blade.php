@extends('layouts.admin')
@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
        <a href="{{ route('product.add') }}" class="btn btn-sm btn-primary">Add</a>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="ordertable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Order Id</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Subtotal</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    <th>Total Item</th>
                                    <th>Delivered On</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="updateStatusForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Update Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="order_id" name="order_id">
                        <div class="mb-3">
                            <label for="status" class="form-label">Select Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="ordered">Ordered</option>
                                <option value="delivered">Delivered</option>
                                <option value="canceled">Cancelled</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#ordertable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("order.index") }}',
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_id',
                    name: 'order_id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'subtotal',
                    name: 'subtotal'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'order_date',
                    name: 'order_date'
                },
                {
                    data: 'total_item',
                    name: 'total_item'
                },
                {
                    data: 'delivered_on',
                    name: 'delivered_on'
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

    // Open Modal and Set Data
    $(document).on('click', '.updateStatusBtn', function() {
        var orderId = $(this).data('id');
        var status = $(this).data('status');
        $('#order_id').val(orderId);
        $('#status').val(status);
        $('#statusModal').modal('show');
    });

    // Submit Status Update
    $('#updateStatusForm').submit(function(e) {
        e.preventDefault();

        var id = $('#order_id').val();
        var status = $('#status').val();
        var token = $('input[name="_token"]').val();

        $.ajax({
            url: '/order/update-status/' + id,
            type: 'POST',
            data: {
                _token: token,
                status: status
            },
            success: function(response) {
                $('#statusModal').modal('hide');
                $('#ordertable').DataTable().ajax.reload(null, false);
                toastr.success(response.message);
            },
            error: function() {
                toastr.error("Something went wrong");
            }
        });
    });
</script>
@endpush