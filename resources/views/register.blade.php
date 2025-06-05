<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - AuDiPec</title>

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

  <!-- Register Form -->
  <section id="hero">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <h2 class="mb-4">Register</h2>
        <form method="POST" action="{{ route('/register') }}">
    @csrf
    <div class="mb-3 text-start">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Enter your full name" required>
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="phoneNo" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="phoneNo" name="phoneNo" value="{{ old('phoneNo') }}" placeholder="Enter your phone number" required>
        @error('phoneNo') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Create a password" required>
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3 text-start">
        <label for="password-confirm" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm password" required>
        @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
    </div>
    <button type="submit" class="btn-login w-100">Register</button>
</form>
        <p class="mt-3">Already have an account? <a href="{{ route('login') }}" style="color: #94bba5;">Login</a></p>
      </div>
    </div>
  </div>
</section>
  </section>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
