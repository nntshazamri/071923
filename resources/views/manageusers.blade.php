<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Users - AuDiPec</title>

  {{-- Stylesheets --}}
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />

  <style>
    /* General */
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Sidebar */
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

    /* Main content */
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

    /* Navbar */
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

    /* Table */
    table {
      width: 100%;
      background-color: white;
      color: black;
      border-radius: 10px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      text-align: center;
    }

    th {
      background-color: #406651;
      color: white;
    }

    tr:nth-child(even) {
      background-color: #f2f2f2;
    }
  </style>
</head>

<body>

  {{-- Header --}}
  <header class="custom-navbar py-3 sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
      <a href="#" class="navbar-brand">
        <img src="{{ asset('assets/img/AuDiPec.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
        AuDiPec
      </a>

      <nav class="navbar">
        <a href="{{ url('/admindashboard') }}">Admin Dashboard</a>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">
          @csrf
        </form>
      </nav>
    </div>
  </header>

  {{-- Sidebar --}}
  <div class="sidebar">
    <div class="user-icon">
      <i class="bi bi-person-badge"></i>
    </div>
    <strong>ADMIN</strong>
    <a href="{{ url('/admindashboard') }}" class="nav-link">Dashboard</a>
    <a href="{{ url('/manageusers') }}" class="nav-link active">Manage Users</a>
    <a href="{{ url('/manageinquiries') }}" class="nav-link">Manage Inquiries</a>
  </div>

  {{-- Main Content --}}
  <div class="main-content">
    <div class="profile-card">
      <h1>Manage Users</h1>

      <table class="table">
        <thead>
          <tr>
            <th>User ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone No</th>
            <th>Role</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->userID }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->phoneNo }}</td>
              <td>{{ $user->role }}</td>
              <td>
                <button class="btn btn-sm btn-warning">Edit</button>
                <button class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>

  {{-- Scripts --}}
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
