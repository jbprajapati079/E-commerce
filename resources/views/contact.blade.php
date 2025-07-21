@extends('layouts.app')
@section('content')
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
        <div class="mw-930">
            <h2 class="page-title">CONTACT US</h2>
        </div>
    </section>

    <hr class="mt-2 text-secondary " />
    <div class="mb-4 pb-4"></div>

    <section class="contact-us container">
        <div class="mw-930">

            <div id="form-success" class="alert alert-success d-none">Your message has been sent successfully.</div>
            <div class="contact-us__form">

                <form id="contact-us-form" name="contact-us-form" class="needs-validation" novalidate method="POST">
                    @csrf
                    <h3 class="mb-5">Get In Touch</h3>

                    <div class="form-floating my-4">
                        <input type="text" class="form-control" name="name" placeholder="Name *" required>
                        <label>Name *</label>
                        <span class="text-danger error-name"></span>
                    </div>

                    <div class="form-floating my-4">
                        <input type="text" class="form-control" name="phone" placeholder="Phone *" required>
                        <label>Phone *</label>
                        <span class="text-danger error-phone"></span>
                    </div>

                    <div class="form-floating my-4">
                        <input type="email" class="form-control" name="email" placeholder="Email address *" required>
                        <label>Email address *</label>
                        <span class="text-danger error-email"></span>
                    </div>

                    <div class="my-4">
                        <textarea class="form-control" name="message" placeholder="Your Message" rows="5" required></textarea>
                        <span class="text-danger error-comment"></span>
                    </div>

                    <div class="my-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
</main>
@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contact-us-form').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.text-danger').text('');
            $('#form-success').addClass('d-none');

            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route("contact.store") }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#contact-us-form')[0].reset();
                    $('#form-success').removeClass('d-none').text(response.success);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('.error-' + key).text(value[0]);
                        });
                    }
                }
            });
        });
    });
</script>
@endpush