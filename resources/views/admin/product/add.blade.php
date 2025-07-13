@extends('layouts.admin')
@section('admin')

<div class="page-content">
    <nav class="page-breadcrumb d-flex justify-content-between align-items-center">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Product</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Product</li>
        </ol>
        <a href="{{ route('product.index') }}" class="btn btn-sm btn-danger">Back</a>
    </nav>

    <div class="row">
        <div class="col-md grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="product" class="forms-sample" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                            <select name="category_id" id="category_id" class="form-select js-example-basic-multiple" data-width="100%">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand <span class="text-danger">*</span></label>
                            <select name="brand_id" id="brand_id" class="form-select js-example-basic-multiple" data-width="100%">
                                <option value="">Select Brand</option>
                                @foreach($brands as $brand)
                                <option value="{{$brand->id}}">{{$brand->name}}</option>
                                @endforeach
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" class="form-control" id="slug" value="{{ old('slug') }}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" name="short_description" id="short_description" rows="10">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="10">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="quantity" class="form-control" id="quantity" value="{{ old('quantity') }}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <input type="number" name="price" class="form-control" id="price" value="{{ old('price') }}" step="0.01">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <input type="number" name="sale_price" class="form-control" id="sale_price" value="{{ old('sale_price') }}" step="0.01">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="SKU" class="form-label">SKU</label>
                            <input type="text" name="SKU" class="form-control" id="SKU" value="{{ old('SKU') }}">
                            <p class="error"></p>
                        </div>

                        <div class="mb-3">
                            <label for="stock_status" class="form-label">Stock Status <span class="text-danger">*</span></label>
                            <select name="stock_status" id="stock_status" class="form-select js-example-basic-multiple" data-width="100%">
                                <option value="">Select Stoke</option>
                                <option value="in_stock">In Stock</option>
                                <option value="out_of_stock">Out Of Stock</option>
                            </select>
                            <p class="error"></p>
                        </div>

                        <div class="form-check form-check-inline mb-3">
                            <input type="checkbox" name="featured" class="form-check-input" id="Featured" value="1">
                            <label class="form-check-label" for="Featured">Featured</label>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image <span class="text-danger">*</span></label>
                            <input type="file" name="image" class="form-control" id="image" accept="image/*">
                            <p class="error" id="image-error"></p>
                            <div class="mt-2" id="image-preview" style="display: none;">
                                <img src="#" id="preview-img" style="max-width: 150px; height: auto; border: 1px solid #ddd; padding: 5px;" />
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gallery" class="form-label">Gallery Images</label>
                            <input type="file" name="gallery[]" class="form-control" id="gallery" accept="image/*" multiple>
                            <p class="error" id="gallery-error"></p>
                            <div class="mt-2" id="gallery-preview" style="display: none;"></div>
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
    // AJAX Form Submission
    $('#product').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.error').html('').removeClass('invalid-feedback');
        $('input, select').removeClass('is-invalid');

        $.ajax({
            url: "{{ route('product.store') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                $('button[type="submit"]').prop('disabled', false);
                let errors = xhr.responseJSON.errors;

                $.each(errors, function(key, value) {
                    let input = $(`[name="${key}"]`);
                    input.addClass('is-invalid');

                    if (key === 'image') {
                        $('#image-error').addClass('invalid-feedback').html(value[0]);
                    } else if (input.prop('tagName') === 'SELECT' || input.attr('type') === 'checkbox') {
                        input.closest('.mb-3').find('.error').addClass('invalid-feedback').html(value[0]);
                    } else {
                        input.next('.error').addClass('invalid-feedback').html(value[0]);
                    }
                });

                $('html, body').animate({
                    scrollTop: $('.is-invalid:first').offset().top - 100
                }, 500);
            }

        });
    });

    // Slug auto-generation
    $('#name').on('keyup', function() {
        var slug = $(this).val().toLowerCase().replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-').replace(/-+/g, '-');
        $('#slug').val(slug);
    });

    // Image Preview
    $('#image').on('change', function() {
        const [file] = this.files;
        if (file) {
            $('#preview-img').attr('src', URL.createObjectURL(file));
            $('#image-preview').show();
        }
    });

    // Gallery Images Preview
    $('#gallery').on('change', function() {
        $('#gallery-preview').empty().show();
        const files = this.files;

        Array.from(files).forEach(file => {
            const img = document.createElement("img");
            img.src = URL.createObjectURL(file);
            img.style.maxWidth = "150px";
            img.style.marginRight = "10px";
            img.style.border = "1px solid #ddd";
            img.style.padding = "5px";
            img.style.height = "auto";
            $('#gallery-preview').append(img);
        });
    });

    // TinyMCE (if used)
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#short_description'
        });
        tinymce.init({
            selector: '#description'
        });
    }
</script>
@endpush