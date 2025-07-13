@extends('layouts.admin')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('coupon.index') }}">Coupon</a></li>
            <li class="breadcrumb-item active" aria-current="page">Coupon</li>
        </ol>
        <a href="{{ route('coupon.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="coupon" class="forms-sample">
                        <div class="mb-3">
                            <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" id="code" value="{{old('code')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                            <select name="type" id="type" class="form-select js-example-basic-multiple" data-width="100%">
                                <option value="">Select Type</option>
                                <option value="fixed">Fixed</option>
                                <option value="percent">Percent</option>
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="value" class="form-label">Value<span class="text-danger">*</span></label>
                            <input type="text" name="value" class="form-control" id="value" value="{{old('value')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="cart_value" class="form-label">Cart Value<span class="text-danger">*</span></label>
                            <input type="text" name="cart_value" class="form-control" id="cart_value" value="{{old('cart_value')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date<span class="text-danger">*</span></label>
                            <input type="datetime-local" name="expiry_date" class="form-control" id="expiry_date" value="{{old('expiry_date')}}">
                            <p class="error"></p>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#coupon').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Clear old errors
        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');
        $('input, select').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('coupon.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {

                    setTimeout(function() {
                        toastr.success(response.message);
                        window.location.href = response.redirect;
                    }, 1500);

                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(key, value) {
                    let input = $(`[name="${key}"]`);
                    input.addClass('is-invalid');

                    // Check if image
                    if (input.prop('tagName') === 'SELECT') {
                        input.closest('.mb-3').find('.error').addClass('invalid-feedback').html(value[0]);
                    } else {
                        input.next('.error').addClass('invalid-feedback').html(value[0]);
                    }
                });
            }
        });
    });
</script>

@endpush