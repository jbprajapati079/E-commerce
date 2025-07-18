@extends('layouts.app')

@section('content')
<main class="pt-90" style="padding-top: 0px;">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Orders</h2>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-2">
                <ul class="account-nav">
                    <li><a href="{{ route('user.dashboard') }}" class="menu-link">Dashboard</a></li>
                    <li><a href="{{ route('user.order.list') }}" class="menu-link">Orders</a></li>
                    <li>
                        <form method="POST" action="{{ url('/logout') }}" id="logout-form">
                            @csrf
                            <a href="{{ url('/logout') }}" class="menu-link"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Orders Table -->
            <div class="col-lg-10">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="ordertable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Subtotal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Total Items</th>
                                <th>Delivered On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    let table = $('#ordertable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("user.order.list") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'order_id', name: 'order_id' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'subtotal', name: 'subtotal' },
            { data: 'total', name: 'total' },
            { data: 'status', name: 'status' },
            { data: 'order_date', name: 'order_date' },
            { data: 'total_item', name: 'total_item' },
            { data: 'delivered_on', name: 'delivered_on' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $(document).on('click', '.cancel-order-btn', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to cancel this order?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $.post("{{ url('/user/order/cancel') }}/" + id, {
                    _token: '{{ csrf_token() }}'
                }, function (res) {
                    if (res.success) {
                        Swal.fire('Canceled!', res.message, 'success');
                        table.ajax.reload();
                    } else {
                        Swal.fire('Error!', 'Unable to cancel order.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
