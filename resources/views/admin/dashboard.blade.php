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
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="#">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total User</h6>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2"></h3>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <a href="#">
                                <div class="d-flex justify-content-between align-items-baseline">
                                    <h6 class="card-title mb-0">Total Category</h6>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6 col-md-12 col-xl-5">
                                        <h3 class="mb-2"></h3>
                                    </div>
                                </div>
                            </a>



                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">

                        <a href="#">
                        <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Product</h6>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2"></h3>
                                </div>
                            </div>
                            </a>


                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection