<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Surfside Media</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="surfside media" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Allura&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/plugins/swiper.min.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/custom.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>


<body class="gradient-bg">
    <main class="pt-90">
        <section class="login-register container">
            <ul class="nav nav-tabs" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="register-tab" data-bs-toggle="tab" href="#tab-item-register" role="tab" aria-controls="tab-item-register" aria-selected="true">Register</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-register" role="tabpanel" aria-labelledby="register-tab">
                    <div class="register-form">
                        <form id="register-form" method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                            @csrf

                            <div class="form-floating mb-3">
                                <input id="name" class="form-control form-control_gray" name="name">
                                <label for="name">Name</label>
                                <span class="text-danger small error-text" id="name-error"></span>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="email" type="email" class="form-control form-control_gray" name="email">
                                <label for="email">Email address *</label>
                                <span class="text-danger small error-text" id="email-error"></span>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="mobile" type="text" class="form-control form-control_gray" name="mobile">
                                <label for="mobile">Mobile *</label>
                                <span class="text-danger small error-text" id="mobile-error"></span>
                            </div>

                            <!-- <div class="form-floating mb-3">
                                <input id="password" type="password" class="form-control form-control_gray" name="password">
                                <label for="password">Password *</label>
                                <span class="text-danger small error-text" id="password-error"></span>
                            </div>

                            <div class="form-floating mb-3">
                                <input id="password_confirmation" type="password" class="form-control form-control_gray" name="password_confirmation">
                                <label for="password_confirmation">Confirm Password *</label>
                                <span class="text-danger small error-text" id="password_confirmation-error"></span>
                            </div> -->

                            <div class="form-floating mb-3 position-relative">
                                <input id="password" type="password" class="form-control form-control_gray" name="password">
                                <label for="password">Password *</label>
                                <span class="text-danger small error-text" id="password-error"></span>
                                <button type="button" class="btn btn-sm btn-secondary position-absolute top-50 end-0 translate-middle-y me-0 toggle-password" data-target="#password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                            <div class="form-floating mb-3 position-relative">
                                <input id="password_confirmation" type="password" class="form-control form-control_gray" name="password_confirmation">
                                <label for="password_confirmation">Confirm Password *</label>
                                <span class="text-danger small error-text" id="password_confirmation-error"></span>
                                <button type="button" class="btn btn-sm btn-secondary position-absolute top-50 end-0 translate-middle-y me-0 toggle-password" data-target="#password_confirmation">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                            <div class="mb-3">
                                <button type="button" id="generate-password" class="btn btn-warning w-100">Generate Strong Password</button>
                            </div>


                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Register</button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">Have an account?</span>
                                <a href="{{ route('login') }}" class="btn-text js-show-register">Login to your Account</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </section>
    </main>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click', function() {
            const input = $($(this).data('target'));
            const icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });

        // Generate random strong password
        $('#generate-password').on('click', function() {
            function generatePassword(length = 12) {
                const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
                let password = "";
                for (let i = 0; i < length; i++) {
                    const randomIndex = Math.floor(Math.random() * charset.length);
                    password += charset[randomIndex];
                }
                return password;
            }

            const newPassword = generatePassword();
            $('#password').val(newPassword);
            $('#password_confirmation').val(newPassword);
            alert('Password generated and filled in both fields.');
        });
    });
</script>