<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <title>Login</title>
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
        <div class="mb-4 pb-4"></div>
        <section class="login-register container">
            <ul class="nav nav-tabs mb-5" id="login_register" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link nav-link_underscore active" id="login-tab" data-bs-toggle="tab" href="#tab-item-login" role="tab" aria-controls="tab-item-login" aria-selected="true">Login</a>
                </li>
            </ul>
            <div class="tab-content pt-2" id="login_register_tab_content">
                <div class="tab-pane fade show active" id="tab-item-login" role="tabpanel" aria-labelledby="login-tab">
                    <div class="login-form">
                        <form id="login-form" method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="">
                            @csrf
                            <div class="form-floating mb-3">
                                <input id="email" class="form-control form-control_gray" name="email" required autocomplete="email" autofocus>
                                <label for="email">Email address *</label>
                                <span class="text-danger small error-text" id="email-error"></span>
                            </div>

                            <!-- <div class="form-floating mb-3">
                                <input id="password" type="password" class="form-control form-control_gray" name="password" required autocomplete="current-password">
                                <label for="password">Password *</label>
                                <span class="text-danger small error-text" id="password-error"></span>
                            </div> -->

                            <div class="form-floating mb-3 position-relative">
                                <input id="password" type="password" class="form-control form-control_gray" name="password">
                                <label for="password">Password *</label>
                                <span class="text-danger small error-text" id="password-error"></span>
                                <button type="button" class="btn btn-sm btn-secondary position-absolute top-50 end-0 translate-middle-y me-0 toggle-password" data-target="#password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>

                            <button class="btn btn-primary w-100 text-uppercase" type="submit">Log In</button>

                            <div class="customer-option mt-4 text-center">
                                <span class="text-secondary">No account yet?</span>
                                <a href="register.html" class="btn-text js-show-register">Create Account</a> |
                                <a href="my-account.html" class="btn-text js-show-register">My Account</a>
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
    });
</script>