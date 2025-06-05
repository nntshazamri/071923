<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - AuDiPec</title>

  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
</head>
<body>


  <!-- Navbar -->
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
      </nav>
    </div>
  </header>

  <!-- Login Form -->
  <section id="hero">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-5">
          <h2 class="mb-4">Login</h2>
          
          <form method="POST" action="{{ route('login') }}">
          @csrf
           <div class="mb-3 text-start">
             <label for="email" class="form-label">Email address</label>
             <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
          </div>
          <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
          </div>
        <button type="submit" class="btn-login w-100">Login</button>
        </form>

          <p class="mt-3">Don't have an account? <a href="{{ url('/register') }}" style="color: #94bba5;">Register</a></p>
        </div>
      </div>
    </div>
  </section>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
