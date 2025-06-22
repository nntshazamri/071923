<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'AuDiPec')</title>

  <!-- Stylesheets -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <!-- Inline Styles -->
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
      width: 250px;
      background-color: #629c7c;
      min-height: 100vh;
      padding: 20px 0;
      position: fixed;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .sidebar .user-icon {
      width: 120px;
      height: 120px;
      background-color: white;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 4rem;
      color: #406651;
      margin-bottom: 10px;
    }

    .sidebar .nav-link {
      width: 100%;
      padding: 15px;
      text-align: center;
      background-color: #629c7c;
      margin: 10px 0;
      color: white;
      text-decoration: none;
      font-weight: bold;
      border-radius: 10px;
    }

    .sidebar .nav-link.active,
    .sidebar .nav-link:hover {
      background-color: #406651;
      color: white;
    }

    .main-content {
      margin-left: 250px;
      background-color: #406651;
      min-height: 100vh;
      padding: 40px;
    }

    .profile-card {
      background-color: #629c7c;
      border-radius: 30px;
      padding: 40px;
      color: white;
    }

    .profile-card h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .navbar a {
      color: white;
      margin-left: 20px;
      text-decoration: none;
    }

    .navbar a:hover {
      color: #629c7c;
    }

    .navbar-brand {
      color: white;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <header class="custom-navbar py-3 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="{{ url('/') }}" class="navbar-brand">
        <img src="{{ asset('assets/img/AuDiPec.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
        AuDiPec
      </a>

      <nav class="navbar">
        <a href="{{ route('userprofile') }}">User Dashboard</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </nav>
    </div>
  </header>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="user-icon"><i class="bi bi-person"></i></div>
    <strong>{{ Auth::user()->name }}</strong>

    <a href="{{ route('userprofile') }}" class="nav-link {{ request()->is('userprofile') ? 'active' : '' }}">
      User Profile
    </a>

    <a href="{{ route('datamonitoring') }}" class="nav-link {{ request()->is('datamonitoring') ? 'active' : '' }}">
      Crop Data
    </a>

    <a href="{{ route('farms.index') }}" class="nav-link {{ request()->is('farmdetails*') ? 'active' : '' }}">
      Manage Farms
    </a>

   <a href="{{ route('visualize.index') }}" class="nav-link {{ request()->is('visualize') ? 'active' : '' }}">
    Report Visualization
  </a>
  </div>


  <!-- Main Content -->
  <div class="main-content">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  @yield('scripts')  <!-- This allows Blade views to inject page-specific scripts -->
</body>
</html>
