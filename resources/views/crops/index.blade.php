@extends('layouts.app')
@section('title', 'Manage Crops')

@section('content')
<div class="profile-card">
  <h2>Manage Crops</h2>

  @if(session('success'))
    <div class="alert alert-success text-dark">{{ session('success') }}</div>
  @endif

  <a href="{{ route('crops.create') }}" class="btn btn-light mb-3">+ Add New Crop</a>

  @if($crops->isEmpty())
    <p>No crops found.</p>
  @else
    <table class="table table-bordered text-white">
      <thead>
        <tr>
          <th>Name</th>
          <th>Moisture (min–max)</th>
          <th>Temp (min–max)</th>
          <th>Humidity (min–max)</th>
          <th>Light (min–max)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($crops as $crop)
          <tr>
            <td>{{ $crop->name }}</td>
            <td>{{ $crop->optimal_moisture_min }} – {{ $crop->optimal_moisture_max }}</td>
            <td>{{ $crop->optimal_temperature_min }} – {{ $crop->optimal_temperature_max }}</td>
            <td>{{ $crop->optimal_humidity_min }} – {{ $crop->optimal_humidity_max }}</td>
            <td>{{ $crop->optimal_light_min }} – {{ $crop->optimal_light_max }}</td>
            <td>
              <a href="{{ route('crops.edit', $crop->id) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('crops.destroy', $crop->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Delete this crop?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  <div class="mt-3">
    <a href="{{ route('farms.index') }}" class="btn btn-secondary">Back to Manage Farms</a>
  </div>
</div>
@endsection
