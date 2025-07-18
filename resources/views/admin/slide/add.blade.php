@extends('layouts.admin')
@section('admin')

<div class="page-content">

    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('slide.index') }}">Slide</a></li>
            <li class="breadcrumb-item active" aria-current="page">Slide</li>
        </ol>
        <a href="{{ route('slide.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="slide" class="forms-sample" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline <span class="text-danger">*</span></label>
                            <input type="text" name="tagline" class="form-control" id="tagline" value="{{old('tagline')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{old('title')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Sub Title</label>
                            <input type="text" name="subtitle" class="form-control" id="subtitle" value="{{old('subtitle')}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" name="link" class="form-control" id="link" value="{{old('link')}}">
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
    $('#slide').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        // Clear old errors
        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('slide.store') }}",
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