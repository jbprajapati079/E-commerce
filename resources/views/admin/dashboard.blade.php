@extends('layouts.admin')
@section('admin')
<div class="page-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Welcome to Dashboard</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('category.index')}}">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Category</h6>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{$categorytotal}}</h3>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('brand.index')}}">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Brand</h6>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{$brandtotal}}</h3>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{route('product.index')}}">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Product</h6>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2">{{$producttotal}}</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{route('order.index')}}">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Order Summary</h6>
                                </div>
                                <div class="mt-3">
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-warning">Total Orders:</span>
                                        <strong class="text-warning">{{ $totalordertotal }}</strong>
                                    </div>
                                    <hr>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span>Orders:</span>
                                        <strong>{{ $ordertotal }}</strong>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-success">Delivered Orders:</span>
                                        <strong class="text-success">{{ $deliveredtotal }}</strong>
                                    </div>
                                    <div class="mb-2 d-flex justify-content-between">
                                        <span class="text-danger">Canceled Orders:</span>
                                        <strong class="text-danger">{{ $canceledtotal }}</strong>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Monthly Orders & Revenue Summary</h6>
                    <canvas id="combinedChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const orderedPrices = @json($orderedPrices);
    const orderedCounts = @json($orderedCounts);

    const deliveredPrices = @json($deliveredPrices);
    const deliveredCounts = @json($deliveredCounts);

    const canceledPrices = @json($canceledPrices);
    const canceledCounts = @json($canceledCounts);

    const ctx = document.getElementById('combinedChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                    label: 'Orders',
                    data: orderedPrices,
                    backgroundColor: 'rgba(75, 55, 191, 0.6)',
                    borderColor: 'rgba(55, 55, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Delivered Orders',
                    data: deliveredPrices,
                    backgroundColor: 'rgb(5, 163, 74)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Canceled Orders',
                    data: canceledPrices,
                    backgroundColor: 'rgb(255, 51, 102)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            return context[0].label;
                        },
                        label: function(context) {
                            const index = context.dataIndex;
                            const label = context.dataset.label;

                            if (label === 'Orders') {
                                return `Orders: ₹${orderedPrices[index].toLocaleString()} (${orderedCounts[index]} orders)`;
                            }

                            if (label === 'Delivered Orders') {
                                return `Delivered: ₹${deliveredPrices[index].toLocaleString()} (${deliveredCounts[index]} orders)`;
                            }

                            if (label === 'Canceled Orders') {
                                return `Canceled: ₹${canceledPrices[index].toLocaleString()} (${canceledCounts[index]} orders)`;
                            }

                            return '';
                        }
                    }
                },
                legend: {
                    position: 'top'
                },
                title: {
                    display: true,
                    text: 'Delivered & Canceled Orders (Price + Count)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Total Price (₹)'
                    }
                }
            }
        }
    });
</script>
@endpush