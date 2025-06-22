
flatpickr('#startDate', { dateFormat: 'Y-m-d' });
flatpickr('#endDate', { dateFormat: 'Y-m-d' });

const labels = JSON.parse('{!! json_encode($labels) !!}');
const soil   = JSON.parse('{!! json_encode($soilData) !!}');
const temp   = JSON.parse('{!! json_encode($tempData) !!}');
const hum    = JSON.parse('{!! json_encode($humData) !!}');
const light  = JSON.parse('{!! json_encode($lightData) !!}');

function generateColors(count) {
  const palette = [
    '#4e79a7', '#f28e2b', '#e15759', '#76b7b2',
    '#59a14f', '#edc949', '#af7aa1', '#ff9da7',
    '#9c755f', '#bab0ab'
  ];
  return Array.from({ length: count }, (_, i) => palette[i % palette.length]);
}

function makeBarChart(id, label, data) {
  const colors = generateColors(data.length);
  new Chart(document.getElementById(id), {
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
        y: {
          beginAtZero: true
        }
      }
    }
  });
}
makeBarChart('soilChart', 'Soil Moisture (%)', soil);
makeBarChart('tempChart', 'Temperature (°C)', temp);
makeBarChart('humChart',  'Humidity (%)', hum);
makeBarChart('lightChart','Light (%)', light);
