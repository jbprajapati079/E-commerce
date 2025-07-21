@extends('layouts.admin')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('brand.index') }}">Brand</a></li>
            <li class="breadcrumb-item active" aria-current="page">Brand Category</li>
        </ol>
        <a href="{{ route('brand.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="brand" class="forms-sample" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{old('name')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" value="{{old('slug')}}" readonly>
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            <p class="error" id="image-error"></p>

                            <!-- Image Preview -->
                            <div class="mt-2" id="image-preview" style="display: none;">
                                <img src="#" alt="Preview" id="preview-img" style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                            </div>
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
    $('#brand').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Clear old errors
        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('brand.store') }}",
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
                    if (key === 'image') {
                        $('#image-error').addClass('invalid-feedback').html(value[0]);
                    } else {
                        input.next('.error').addClass('invalid-feedback').html(value[0]);
                    }
                });
            }
        });
    });

    // Slug auto-generation
    $('#name').on('keyup', function() {
        var title = $(this).val();
        var slug = title.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-');
        $('#slug').val(slug);
    });

    // Image preview
    $('#image').on('change', function() {
        const [file] = this.files;
        if (file) {
            $('#preview-img').attr('src', URL.createObjectURL(file));
            $('#image-preview').show();
        }
    });
</script>

@endpush