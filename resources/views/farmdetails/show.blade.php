@extends('layouts.app')
@section('title', 'Farm Details')

@section('content')
<div class="profile-card">
  <h2>Farm #{{ $farm->farmID }} Details</h2>

  @if(session('success'))
    <div class="alert alert-success text-dark">{{ session('success') }}</div>
  @endif

  <p><strong>Location:</strong> {{ $farm->location }}</p>
  @if(isset($farm->size))
    <p><strong>Size:</strong> {{ $farm->size }}</p>
  @endif

  <hr class="border-light">

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Plots</h4>
    <a href="{{ route('plots.create', $farm->farmID) }}" class="btn btn-light">+ Add Plot</a>
  </div>
@if($farm->plots->isEmpty())
  <p>No plots found for this farm.</p>
@else
  <table class="table table-bordered text-white">
    <thead>
      <tr>
        <th>Plot ID</th>
        <th>Name</th>
        <th>Crop</th> {{-- ✅ New column header --}}
        <th>Latitude Range</th>
        <th>Longitude Range</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($farm->plots as $plot)
        <tr>
          <td>{{ $plot->plotID }}</td>
          <td>{{ $plot->name }}</td>
          <td>
            {{ $plot->crop ? ucfirst($plot->crop->name) : '-' }} {{-- ✅ Show crop name or dash if not set --}}
          </td>
          <td>{{ $plot->min_latitude }} – {{ $plot->max_latitude }}</td>
          <td>{{ $plot->min_longitude }} – {{ $plot->max_longitude }}</td>
          <td>
            <a href="{{ route('plots.edit', ['farm' => $farm->farmID, 'plot' => $plot->plotID]) }}"
               class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('plots.destroy', ['farm' => $farm->farmID, 'plot' => $plot->plotID]) }}"
                  method="POST" style="display:inline-block" onsubmit="return confirm('Delete this plot?');">
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
