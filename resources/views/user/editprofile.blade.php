<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile - AuDiPec</title>
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
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

    .edit-card {
      background-color: #629c7c;
      border-radius: 30px;
      padding: 40px;
      color: white;
      max-width: 700px;
      margin: auto;
    }

    .edit-card h2 {
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
      background-color: #2e4c3b;
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

    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 10px;
    }

    .alert-success {
      background-color: #3c7a5d;
      color: white;
    }

    .alert-danger {
      background-color: #b94a48;
      color: white;
    }

    .section-divider {
      border-top: 2px dashed white;
      margin: 40px 0;
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
    <div class="user-icon">
      <i class="bi bi-person"></i>
    </div>
    <strong>USER</strong>
    <a href="{{ route('userprofile') }}" class="nav-link {{ request()->is('userprofile') ? 'active' : '' }}">User Profile</a>
    <a href="{{ url('/datamonitoring') }}" class="nav-link {{ request()->is('datamonitoring') ? 'active' : '' }}">Crop Data</a>
    <a href="{{ url('/farmdetails') }}" class="nav-link {{ request()->is('farmdetails') ? 'active' : '' }}">Farm Details</a>
    <a href="#" class="nav-link">Report Visualization</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="edit-card">
      <h2>Edit Profile</h2>

      <form method="POST" action="{{ route('profile.update') }}">
  @csrf
  @method('PUT')

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if($errors->any())
    <div class="alert alert-danger">
      <ul class="mb-0">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="form-group mb-3">
    <label for="name">NAME</label>
    <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
  </div>

  <div class="form-group mb-3">
    <label for="email">EMAIL</label>
    <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
  </div>

  <div class="form-group mb-3">
    <label for="phoneNo">PHONE NO</label>
    <input type="text" name="phoneNo" class="form-control" value="{{ Auth::user()->phoneNo }}">
  </div>

  <div class="form-group mb-3">
    <label for="password">NEW PASSWORD</label>
    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
  </div>

  <div class="form-group mb-4">
    <label for="password_confirmation">CONFIRM PASSWORD</label>
    <input type="password" name="password_confirmation" class="form-control">
  </div>

  <div class="text-end">
    <button type="submit" class="btn btn-update">Save Changes</button>
  </div>
</form>
    </div>
  </div>
</body>
</html>
