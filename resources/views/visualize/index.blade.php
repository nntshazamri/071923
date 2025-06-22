@extends('layouts.app')

@section('title', 'Data Visualization')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Sensor Data Visualization</h2>

    {{-- Filters --}}
    <form method="GET" action="{{ route('visualize.index') }}" class="row g-3 align-items-center mb-5">
        {{-- Farm Dropdown --}}
        <div class="col-md-3">
            <select name="farm" id="farmSelect" class="form-select" onchange="this.form.submit()">
                <option value="">-- Select Farm --</option>
                @foreach($farms as $farm)
                    <option value="{{ $farm->farmID }}" {{ request('farm') == $farm->farmID ? 'selected' : '' }}>
                        {{ $farm->location }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Plot Dropdown --}}
        <div class="col-md-3">
            <select name="plot" class="form-select" onchange="this.form.submit()">
                <option value="">-- All Plots --</option>
                @foreach($plots as $plot)
                    <option value="{{ $plot->plotID }}" {{ request('plot') == $plot->plotID ? 'selected' : '' }}>
                        Plot #{{ $plot->plotID }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Start Date --}}
        <div class="col-md-3">
            <input type="text" name="start_date" id="startDate" class="form-control" placeholder="Start Date"
                   value="{{ request('start_date') }}">
        </div>

        {{-- End Date --}}
        <div class="col-md-3">
            <input type="text" name="end_date" id="endDate" class="form-control" placeholder="End Date"
                   value="{{ request('end_date') }}">
        </div>

        {{-- Action Buttons --}}
        <div class="col-md-12">
            <button class="btn btn-primary">Apply Filter</button>
            <a href="{{ route('visualize.exportCsv', request()->all()) }}" class="btn btn-outline-secondary">
                Download CSV
            </a>
            <a href="{{ route('visualize.exportPdf', request()->all()) }}" class="btn btn-outline-secondary">
                Download PDF
            </a>
        </div>
    </form>

   {{-- Charts Grid --}}
<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card p-3" style="height: 300px;">
      <h5>Soil Moisture</h5>
      <canvas id="soilChart"></canvas>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card p-3" style="height: 300px;">
      <h5>Temperature</h5>
      <canvas id="tempChart"></canvas>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card p-3" style="height: 300px;">
      <h5>Humidity</h5>
      <canvas id="humChart"></canvas>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card p-3" style="height: 300px;">
      <h5>Light</h5>
      <canvas id="lightChart"></canvas>
    </div>
  </div>
  <div class="col-md-6 mb-4">
    <div class="card p-3" style="height: 300px;">
      <h5>Average Sensor Readings</h5>
      <canvas id="pieChart"></canvas>
    </div>
  </div>
</div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
flatpickr('#startDate', { dateFormat: 'Y-m-d' });
flatpickr('#endDate',   { dateFormat: 'Y-m-d' });

const rawLabels = @json($labels);
const rawSoil   = @json($soilData);
const rawTemp   = @json($tempData);
const rawHum    = @json($humData);
const rawLight  = @json($lightData);

// Limit to last 20 values
const MAX = 20;
const labels = rawLabels.slice(-MAX);
const soil   = rawSoil.slice(-MAX);
const temp   = rawTemp.slice(-MAX);
const hum    = rawHum.slice(-MAX);
const light  = rawLight.slice(-MAX);

// 🎨 Generate vibrant color array
function generateColors(count) {
  const palette = [
    '#4e79a7', '#f28e2b', '#e15759', '#76b7b2',
    '#59a14f', '#edc949', '#af7aa1', '#ff9da7',
    '#9c755f', '#bab0ab'
  ];
  return Array.from({ length: count }, (_, i) => palette[i % palette.length]);
}

// 🛠 Destroy existing chart before creating a new one
function destroyIfExists(id) {
  const existingChart = Chart.getChart(id);
  if (existingChart) {
    existingChart.destroy();
  }
}

// 📊 Create bar chart with per-bar colors
function makeBarChart(id, label, data) {
  destroyIfExists(id);
  const ctx = document.getElementById(id).getContext('2d');
  const colors = generateColors(data.length);

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: label,
        data: data,
        backgroundColor: colors,
        borderColor: colors,
        borderWidth: 1,
        borderRadius: 5,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}

// 🔁 Create all charts
makeBarChart('soilChart',  'Soil Moisture (%)', soil);
makeBarChart('tempChart',  'Temperature (°C)',  temp);
makeBarChart('humChart',   'Humidity (%)',      hum);
makeBarChart('lightChart', 'Light (%)',         light);

// 🍰 Pie chart for averages
const avg = arr => arr.length ? (arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(1) : 0;
const pieData = {
  labels: ['Soil', 'Temp', 'Humidity', 'Light'],
  datasets: [{
    label: 'Average Values',
    data: [avg(rawSoil), avg(rawTemp), avg(rawHum), avg(rawLight)],
    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
  }]
};
new Chart(document.getElementById('pieChart').getContext('2d'), {
  type: 'pie',
  data: pieData,
  options: {
    responsive: true,
    maintainAspectRatio: false
  }
});
</script>
@endsection