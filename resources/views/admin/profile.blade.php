@extends('layouts.admin')
@section('admin')
<div class="page-content">


    <div class="row profile-body">
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-6 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">
                        <div class="card-header">
                            <div class="d-flex justify-content-center">
                                <div class="d-flex justify-content-center">
                                    <img class="img rounded-circle" src="{{ asset('admin/profile/' . $data->image) }}" alt="" width="80" height="80">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="admiprofile" class="forms-sample" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" id="name" value="{{$data->name}}">
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" class="form-control" id="email" value="{{$data->email}}">
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="mobile" class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile" class="form-control" id="mobile" value="{{$data->mobile}}">
                                    <p class="error"></p>
                                </div>

                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                                    <p class="text-danger" id="image-error">
                                        @error('image') {{ $message }} @enderror
                                    </p>

                                    <!-- {{-- Existing Image (Edit Mode) --}}
                                    @if (!empty($data->image))
                                    <div class="mt-2 dataimage">
                                        <img src="{{ asset('admin/profile/' . $data->image) }}" width="80" alt="Current Image">
                                    </div>
                                    @endif -->

                                    {{-- Preview Selected New Image --}}
                                    <div class="mt-2" id="image-preview" style="display: none;">
                                        <img id="preview-img" src="#" alt="Preview" style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
    </div>

</div>

@endsection

@push('scripts')
<script>
    $('#admiprofile').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $('.error').html('').removeClass('invalid-feedback');
        $('input').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('admin.profile.update', $data->id) }}",
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