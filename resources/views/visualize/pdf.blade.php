<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sensor Readings Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 4px; text-align: center; }
        th { background-color: #629c7c; color: #fff; }
    </style>
</head>
<body>
    <h2>Sensor Readings Report</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Farm</th>
                <th>Plot</th>
                <th>Soil Moisture</th>
                <th>Temperature</th>
                <th>Humidity</th>
                <th>Light</th>
            </tr>
        </thead>
        <tbody>
            @forelse($readings as $r)
                <tr>
                    <td>{{ $r->created_at }}</td>
                    <td>{{ $r->plot->farm->location ?? 'N/A' }}</td>
                    <td>{{ $r->plot->location ?? 'N/A' }}</td>
                    <td>{{ $r->soil_moisture }}</td>
                    <td>{{ $r->temperature }}</td>
                    <td>{{ $r->humidity }}</td>
                    <td>{{ $r->light }}</td>
                </tr>
            @empty
                <tr><td colspan="7">No data available</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
