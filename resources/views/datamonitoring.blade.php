
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Data Monitoring - AuDiPec</title>
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
  <style>
    body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
    .sidebar { width: 250px; background-color: #629c7c; min-height: 100vh; padding: 20px 0; position: fixed; display: flex; flex-direction: column; align-items: center; }
    .sidebar .user-icon { width: 120px; height: 120px; background-color: white; border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 4rem; color: #406651; margin-bottom: 10px; }
    .sidebar .nav-link { width: 100%; padding: 15px; text-align: center; background-color: #629c7c; margin: 10px 0; color: white; text-decoration: none; font-weight: bold; border-radius: 10px; }
    .sidebar .nav-link.active, .sidebar .nav-link:hover { background-color: #406651; color: white; }
    .main-content { margin-left: 250px; background-color: #406651; min-height: 100vh; padding: 40px; }
    .profile-card { background-color: #629c7c; border-radius: 30px; padding: 40px; color: white; }
    .profile-card h2 { text-align: center; font-weight: bold; margin-bottom: 30px; }
    .navbar a { color: white; margin-left: 20px; text-decoration: none; }
    .navbar a:hover { color: #629c7c; }
    .navbar-brand { color: white; font-weight: bold; }
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
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </nav>
    </div>
  </header>

  <div class="sidebar">
    <div class="user-icon"><i class="bi bi-person"></i></div>
    <strong>{{ Auth::user()->name }}</strong>
    <a href="{{ route('userprofile') }}" class="nav-link {{ request()->is('userprofile') ? 'active' : '' }}">User Profile</a>
    <a href="{{ route('datamonitoring') }}" class="nav-link {{ request()->is('datamonitoring') ? 'active' : '' }}">Crop Data</a>
    <a href="{{ url('/farmdetails') }}" class="nav-link {{ request()->is('farmdetails*') ? 'active' : '' }}">Manage Farms</a>
    <a href="#" class="nav-link">Report Visualization</a>
  </div>

  <div class="main-content">
    <div class="profile-card">
      <h2>Sensor Data Monitoring</h2>

      {{-- Warning if fewer than 2 plots --}}
      @if ($totalPlots < 2)
        <div class="alert alert-warning text-dark">
          You have only {{ $totalPlots }} plot(s). Need at least 2 plots to compare data.
        </div>
      @endif

      {{-- Filter Form --}}
      <form method="GET" action="{{ route('datamonitoring') }}" class="mb-4">
        <div class="row g-2 align-items-center">
          <div class="col-auto">
            <label for="farmSelect" class="col-form-label text-white">Select Farm:</label>
          </div>
          <div class="col-auto">
            <select id="farmSelect" name="farm" class="form-select">
              <option value="">All Farms</option>
              @foreach($farms as $farm)
                <option value="{{ $farm->farmID }}" {{ request('farm') == $farm->farmID ? 'selected' : '' }}>
                  Farm #{{ $farm->farmID }} ({{ $farm->location ?? 'No location' }})
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-auto">
            <label for="plotSelect" class="col-form-label text-white">Select Plot:</label>
          </div>
          <div class="col-auto">
            <select id="plotSelect" name="plot" class="form-select">
              <option value="">All Plots</option>
              @if(request('farm'))
                @php
                  $selectedFarmPlots = $farmPlots[request('farm')] ?? collect();
                @endphp
                @foreach($selectedFarmPlots as $plot)
                  <option value="{{ $plot->plotID }}" {{ request('plot') == $plot->plotID ? 'selected' : '' }}>
                    Plot #{{ $plot->plotID }} @if($plot->crop)({{ ucfirst($plot->crop->name) }})@endif
                  </option>
                @endforeach
              @else
                @foreach($farmPlots as $farmId => $plots)
                  @foreach($plots as $plot)
                    <option value="{{ $plot->plotID }}" {{ request('plot') == $plot->plotID ? 'selected' : '' }}>
                      Farm #{{ $farmId }} - Plot #{{ $plot->plotID }} @if($plot->crop)({{ ucfirst($plot->crop->name) }})@endif
                    </option>
                  @endforeach
                @endforeach
              @endif
            </select>
          </div>
          <div class="col-auto">
            <button type="submit" class="btn btn-light">Filter</button>
          </div>
        </div>
      </form>

      {{-- Monitoring Table --}}
      <table class="table table-striped table-bordered text-white">
        <thead>
  <tr>
    <th>No.</th>
    <th>Plot ID</th>
    <th>Batch #</th>
    <th>Crop</th>
    <th>Moisture (avg %)</th>
    <th>Temperature (avg °C)</th>
    <th>Humidity (avg %)</th>
    <th>Light (avg)</th>
    <th>Last Timestamp</th>
    <th>Alert</th>
  </tr>
</thead>
<tbody>
  @forelse($monitorData as $index => $item)
    <tr>
      <td>{{ $index + 1 }}</td>
      <td>{{ $item['plot']->plotID }}</td>
      <td>{{ $item['batchIndex'] }}</td>
      <td>{{ $item['plot']->crop ? ucfirst($item['plot']->crop->name) : '-' }}</td>
      <td>@if(is_null($item['avgSoil'])) - @else {{ number_format($item['avgSoil'],1) }}% @endif</td>
      <td>@if(is_null($item['avgTemp'])) - @else {{ number_format($item['avgTemp'],1) }} @endif</td>
      <td>@if(is_null($item['avgHum'])) - @else {{ number_format($item['avgHum'],1) }}% @endif</td>
      <td>@if(is_null($item['avgLight'])) - @else {{ number_format($item['avgLight'],1) }} @endif</td>
      <td>{{ optional(\Carbon\Carbon::parse($item['lastTimestamp']))->format('Y-m-d H:i:s') ?? '-' }}</td>
      <td>
        @if(empty($item['alerts']))
          <span class="badge bg-success">Normal</span>
        @else
          @foreach($item['alerts'] as $alertType)
            @php
              if (\Illuminate\Support\Str::startsWith($alertType, 'Low')) {
                  $color = 'bg-warning text-dark';
              } elseif (\Illuminate\Support\Str::startsWith($alertType, 'High')) {
                  $color = 'bg-danger';
              } else {
                  $color = 'bg-info';
              }
            @endphp
            <span class="badge {{ $color }}">{{ $alertType }}</span>
          @endforeach
        @endif
      </td>
    </tr>
  @empty
    <tr>
      <td colspan="10" class="text-center">No plots/data to display.</td>
    </tr>
  @endforelse
</tbody>
      </table>
    </div>
  </div>

  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
