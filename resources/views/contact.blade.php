<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AuDiPec - Contact</title>

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

  <!-- Contact Section -->
  <section id="hero">
    <div class="container">
      <h2>Contact Us</h2>
      <p>Have questions or need support? Reach out to us below.</p>
      <div class="row justify-content-center mt-4">
        <div class="col-md-8">
          <form action="#" method="post" class="bg-white p-4 rounded shadow-sm text-start text-dark">
            <div class="mb-3">
              <label for="name" class="form-label">Your Name</label>
              <input type="text" class="form-control" id="name" placeholder="John Doe" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Your Email</label>
              <input type="email" class="form-control" id="email" placeholder="johndoe@example.com" required>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control" id="message" rows="5" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-login">Send Message</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
