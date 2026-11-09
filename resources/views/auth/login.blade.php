<!doctype html>
<html lang="en">
  <!-- [Head] start -->

  <head>
    <title>Login | Library Management System</title>
    <!-- [Meta] -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content=""
    />
    <meta
      name="keywords"
      content=""
    />
    <meta name="author" content="codedthemes" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('template-assets/images/favicon.svg') }}" type="image/x-icon" />
 <!-- [Google Font : Poppins] icon -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet" />

<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ asset('template-assets/fonts/tabler-icons.min.css') }}" />
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ asset('template-assets/fonts/feather.css') }}" />
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ asset('template-assets/fonts/fontawesome.css') }}" />
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ asset('template-assets/fonts/material.css') }}" />
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('template-assets/css/style.css') }}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('template-assets/css/style-preset.css') }}" />

  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
      <div class="loader-track">
        <div class="loader-fill"></div>
      </div>
    </div>

    <div class="auth-main v1 bg-grd-primary">
      <div class="auth-wrapper">
        <div class="auth-form">
          <div class="card my-5">
            <div class="card-body">
              <div class="text-center">
                  <div class="d-flex align-items-center">
                  <img src="{{ asset('template-assets/images/Library-logo.jpg') }}" alt="Library Management System" width="50" height="50" class="me-3" />
                      <h4 class="mb-0 fw-bold text-primary">Library Management</h4>
                  </div>
                  <br>
                  <h4 class="f-w-500 mb-1">Login with your email</h4>
                <p class="mb-4') }}">Don't have an Account? <a href="{{ route('register') }}" class="link-primary ms-1">
                        Create Account
                    </a></p>
              </div>
              @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                  <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
              @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
              @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Full Name"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required >

                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email Address"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required >
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password"
                            autocomplete="current-password"
                            required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- [ Main Content ] end -->
    <!-- Required Js -->
    <script src="{{ asset('template-assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('template-assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('template-assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template-assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('template-assets/js/script.js') }}"></script>
    <script src="{{ asset('template-assets/js/theme.js') }}"></script>
    <script src="{{ asset('template-assets/js/plugins/feather.min.js') }}"></script>


    <script>
      layout_change('light');
    </script>

    <script>
      layout_sidebar_change('light');
    </script>

    <script>
      change_box_container('false');
    </script>

    <script>
      layout_caption_change('true');
    </script>

    <script>
      layout_rtl_change('false');
    </script>

    <script>
      preset_change('preset-1');
    </script>

    <script>
      header_change('header-1');
    </script>


  </body>
  <!-- [Body] end -->
</html>
