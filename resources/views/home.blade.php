<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AuDiPec - Home</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

  <style>
    body {
      margin: 0;
      padding: 0;
    }

    /* Hero section with plain blue background */
    #hero {
      background-color: #406651;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      padding: 20px;
    }

    #hero h2 {
      font-size: 2.5rem;
      font-weight: bold;
    }

    #hero p {
      font-size: 1.25rem;
      margin: 20px 0;
    }

    .btn-login {
      padding: 10px 30px;
      font-size: 1rem;
      background-color: #629c7c;
      color: white;
      border: none;
      border-radius: 4px;
      text-decoration: none;
    }

    .btn-login:hover {
      background-color: #94bba5;
    }

    /* Navbar styling */
    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }

    .navbar a:hover {
      color: #94bba5;
      text-decoration: none;
    }

    .navbar-brand img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      color: white;
      font-weight: bold;
      font-size: 1.5rem;
      text-decoration: none;
    }
  </style>
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

  <!-- Hero Section -->
  <section id="hero">
    <div>
      <h2>Welcome to AuDiPec Monitor</h2>
      <p>Your Reliable, and Secure Soil Monitoring Solutions</p>
      <a href="{{ url('/login') }}" class="btn-login">Login</a>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
