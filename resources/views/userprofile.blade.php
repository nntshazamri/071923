<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>User Profile - AuDiPec</title>

  <!-- Bootstrap CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

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

    .form-group label {
      font-weight: bold;
      background-color: rgb(68, 114, 88);
      padding: 10px;
      border-radius: 5px;
      width: 150px;
      display: inline-block;
    }

    .form-control {
      display: inline-block;
      width: calc(100% - 160px);
      background-color: rgb(79, 130, 101);
      color: white;
      border: none;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .btn-update {
      background-color: #406651;
      color: white;
      border-radius: 30px;
      padding: 10px 30px;
      float: right;
      font-weight: bold;
      border: none;
    }

    .btn-update:hover {
      background-color: #629c7c;
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
      <a href="#" class="navbar-brand">
        <img src="{{ asset('assets/img/AuDiPec.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
        AuDiPec
      </a>
    <nav class="navbar">
    <a href="{{ url('/userprofile') }}">User Dashboard</a>

    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        Log Out
    </a>

    <form id="logout-form" action="/logout" method="POST" style="display: none;">
        @csrf
    </form>
    </nav>

    </div>
  </header>

  <!-- Sidebar -->
<div class="sidebar">
    <div class="user-icon"><i class="bi bi-person"></i></div>
    <strong>{{ Auth::user()->name }}</strong>
    <a href="{{ route('userprofile') }}" class="nav-link {{ request()->is('userprofile') ? 'active' : '' }}">User Profile</a>
    <a href="{{ route('datamonitoring') }}" class="nav-link {{ request()->is('datamonitoring') ? 'active' : '' }}">Crop Data</a>
    <a href="{{ url('/farmdetails') }}" class="nav-link {{ request()->is('farmdetails') ? 'active' : '' }}">Manage Farms</a>
    <a href="{{ route('visualize.index') }}" class="nav-link {{ request()->is('visualize') ? 'active' : '' }}">
    Report Visualization
    </a>
  </div>

<!-- Main Content -->
<div class="main-content">
  <div class="profile-card">
    <h1>Welcome, {{ $user->name }}</h1>
    <h2>USER PROFILE</h2>

    <div class="form-group mb-3">
      <label for="name">NAME</label>
      <input type="text" class="form-control" id="name" value="{{ $user->name }}" readonly>
    </div>
    <div class="form-group mb-3">
      <label for="email">EMAIL</label>
      <input type="email" class="form-control" id="email" value="{{ $user->email }}" readonly>
    </div>
    <div class="form-group mb-3">
      <label for="phone">PHONE NO</label>
      <input type="text" class="form-control" id="phone" value="{{ $user->phoneNo }}" readonly>
    </div>

    <div class="text-end">
      <a href="{{ route('profile.edit') }}" class="btn btn-update">Edit Profile</a>
    </div>
  </div>
</div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
