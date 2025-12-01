<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>{{ config('app.name') }} | Login</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('admintheme/images/favicon.svg') }}" type="image/x-icon">
    <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('admintheme/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('admintheme/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('admintheme/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('admintheme/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('admintheme/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('admintheme/css/style-preset.css') }}">

    <style>
        .auth-main .auth-wrapper.v3 .auth-form {
            /* background: url({{ isset($setting_app['logo']) ? Storage::disk('public')->url($setting_app['logo']) : '' }}); */
            background: none;
            background-repeat: no-repeat;
            background-size: auto 75%;
            background-position: -10rem center;
            /* background-position: left center; */
        }
    </style>
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Main Content ] start -->
    <div class="auth-main">
        <div class="auth-wrapper v3">
            <div class="auth-form">
                <div class="auth-header">
                    {{-- <a href="#"><img
                            src="{{ isset($setting_app['logo']) ? Storage::disk('public')->url($setting_app['logo']) : '' }}"
                            alt="img" style="height: 3rem;"></a> --}}
                    {{-- <a href="#"><img src="{{ asset('admintheme/images/logo-dark.svg') }}" alt="img"></a> --}}
                </div>
                <form action="{{ route('admin.auth.login.do') }}" method="POST" class="card my-5 shadow">
                    @csrf
                    <div class="card-body">
                        <div class="d-flex justify-content-center w-100">
                            <a href="#"><img
                                    src="{{ isset($setting_app['logo']) ? Storage::disk('public')->url($setting_app['logo']) : '' }}"
                                    alt="img" style="height: 3rem;"></a>
                        </div>

                        <div class="d-flex justify-content-start align-items-end mb-4">
                            <h3 class="mb-0"><b>Login</b></h3>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Gagal!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Berhasil!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Perhatian!</strong> Mohon periksa kesalahan berikut:
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="d-flex mt-1 justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input input-primary" type="checkbox" id="customCheckc1"
                                    checked="">
                                <label class="form-check-label text-muted" for="customCheckc1">Keep me sign in</label>
                            </div>
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </div>
                </form>
                <div class="auth-footer row">
                </div>
            </div>
        </div>
    </div>
    <!-- [ Main Content ] end -->

    <!-- [Page Specific JS] start -->
    {{-- <script src="{{ asset('admintheme/js/plugins/apexcharts.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('admintheme/js/pages/dashboard-default.js') }}"></script> --}}
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('admintheme/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('admintheme/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('admintheme/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admintheme/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('admintheme/js/fonts/custom-ant-icon.js') }}"></script>
    <script src="{{ asset('admintheme/js/pcoded.js') }}"></script>
    <script src="{{ asset('admintheme/js/plugins/feather.min.js') }}"></script>
    <!-- Buy Now Link  -->
    {{-- <script defer src="https://fomo.codedthemes.com/pixel/Oo2pYDncP8R8qhhETpWKGA04b8jPhUjF"></script> --}}


    <script>
        // layout_change('light');
    </script>

    <script>
        // change_box_container('false');
    </script>

    <script>
        // layout_rtl_change('false');
    </script>

    <script>
        // preset_change('preset-1');
    </script>

    <script>
        // font_change('Public-Sans');
    </script>

    @yield('footer')

</body>
<!-- [Body] end -->

</html>
