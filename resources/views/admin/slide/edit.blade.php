@extends('layouts.admin')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('slide.index') }}">Slider</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Slider</li>
        </ol>
        <a href="{{ route('slide.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <form id="slideForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="tagline" class="form-label">Tagline <span class="text-danger">*</span></label>
                            <input type="text" name="tagline" class="form-control" id="tagline" value="{{$data->tagline}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{$data->title}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Sub Title</label>
                            <input type="text" name="subtitle" class="form-control" id="subtitle" value="{{$data->subtitle}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Link</label>
                            <input type="text" name="link" class="form-control" id="link" value="{{$data->link}}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            <p class="text-danger" id="image-error">
                                @error('image') {{ $message }} @enderror
                            </p>

                            {{-- Existing Image (Edit Mode) --}}
                            @if (!empty($data->image))
                            <div class="mt-2 dataimage">
                                <img src="{{ asset('slider/' . $data->image) }}" width="80" alt="Current Image">
                            </div>
                            @endif

                            {{-- Preview Selected New Image --}}
                            <div class="mt-2" id="image-preview" style="display: none;">
                                <img id="preview-img" src="#" alt="Preview" style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                            </div>
                        </div>




                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>

                            <select name="status" id="status" class="js-example-basic-multiple form-select" data-width="100%">

                                <option value="Active" {{ $data->status === 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="Inactive" {{ $data->status === 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>

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
    $('#slideForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('slide.update', $data->id) }}",
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

                    if (key === 'image') {
                        $('#image-error').addClass('invalid-feedback').html(value[0]);
                    } else {
                        input.next('.error').addClass('invalid-feedback').html(value[0]);
                    }
                });
            }
        });
    });

    $('#image').on('change', function() {
        $('.dataimage').hide()
        const [file] = this.files;
        if (file) {
            $('#preview-img').attr('src', URL.createObjectURL(file));
            $('#image-preview').show();
        } else {
            $('#image-preview').hide();
            $('#preview-img').attr('src', '#');
        }
    });
</script>
@endpush