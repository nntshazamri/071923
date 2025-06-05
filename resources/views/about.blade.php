<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AuDiPec - About</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>

  <!-- Header/Navbar -->
  <header class="custom-navbar py-3 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('assets/img/AuDiPec.png') }}" alt="Logo">
        AuDiPec
      </a>
      <nav class="navbar">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ url('/login') }}">Login</a>
        <a href="{{ url('/register') }}">Register</a>
      </nav>
    </div>
  </header>

  <!-- About Section -->
  <section id="hero">
    <div>
      <h2>About AuDiPec</h2>
      <p>AuDiPec is a smart agriculture solution built to help farmers monitor soil conditions in real time.</p>
      <p>We focus on reliability, ease of use, and secure data tracking to enhance modern farming practices.</p>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
