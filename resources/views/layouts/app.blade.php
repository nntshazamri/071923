<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Profile - AuDiPec</title>

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
    /* Include your inline CSS here (copy it from the page you shared above) */
    {{ Illuminate\Support\Facades\File::get(public_path('assets/css/custom.css')) }}
  </style>
</head>
<body>
  <header class="custom-navbar py-3 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('assets/img/AuDiPec.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
        AuDiPec
      </a>
      <nav class="navbar">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="#logout">Log Out</a>
      </nav>
    </div>
  </header>

  <div class="d-flex">
    @yield('content')
  </div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
