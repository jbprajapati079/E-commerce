@extends('layouts.admin')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('size.index') }}">Size</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Size</li>
        </ol>
        <a href="{{ route('size.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="sizeForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $data->name }}">
                            <p class="error"></p>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $('#sizeForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('size.update', $data->id) }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                setTimeout(function() {
                    toastr.success(response.message);
                    window.location.href = response.redirect;
                }, 1500);
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(key, value) {
                    let input = $(`[name="${key}"]`);
                    input.addClass('is-invalid');

                        input.next('.error').addClass('invalid-feedback').html(value[0]);
                });
            }
        });
    });
</script>
@endpush