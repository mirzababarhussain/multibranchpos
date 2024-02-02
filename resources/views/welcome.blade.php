<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | Able Pro Dashboard Template</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
  <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
  <meta name="author" content="Phoenixcoded">

  <!-- [Favicon] icon -->
  <link rel="icon" href="{{ asset('assets/images/favicon.svg')}}" type="image/x-icon">
 <!-- [Font] Family -->
<link rel="stylesheet" href="{{ asset('assets/fonts/inter/inter.css')}}" id="main-font-link" />
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css')}}" />
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather.css')}}" />
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css')}}" />
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}" />
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css')}}" id="main-style-link" />
<link rel="stylesheet" href="{{ asset('assets/css/style-preset.css')}}" />

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v2">
      <div class="auth-sidecontent">
        <img src="{{ asset('assets/images/authentication/img-auth-sideimg.jpg')}}" alt="images"
          class="img-fluid img-auth-side">
      </div>
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
              <a href="#"><img src="{{ asset('assets/images/logo-dark.svg')}}" alt="img"></a>
              
            </div>
           
            <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group mb-3">
                <input placeholder="Login ID" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group mb-3">
                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
              </div>
              <div class="d-flex mt-1 justify-content-between align-items-center">
                <div class="form-check">
                  <input class="form-check-input input-primary" type="checkbox" id="customCheckc1" checked="">
                  <label class="form-check-label text-muted" for="customCheckc1">Remember me?</label>
                </div>
                <h6 class="text-secondary f-w-400 mb-0">Forgot Password?</h6>
              </div>
              <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="{{ asset('assets/js/plugins/popper.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/simplebar.min.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/js/fonts/custom-font.js')}}"></script>
  <script src="{{ asset('assets/js/pcoded.js')}}"></script>
  <script src="{{ asset('assets/js/plugins/feather.min.js')}}"></script>

  
  
  

</body>
<!-- [Body] end -->

</html>