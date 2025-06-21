@extends('layouts.app')
@section('title', 'Farm Details')

@section('content')
<div class="profile-card">
  <h2>Your Farms</h2>

  @if(session('success'))
    <div class="alert alert-success text-dark">{{ session('success') }}</div>
  @endif

  <a href="{{ route('farms.create') }}" class="btn btn-light mb-3">+ Add New Farm</a>
  <a href="{{ route('crops.index') }}" class="btn btn-light mb-3">Manage Crops</a>

  @if($farms->isEmpty())
    <p>No farms found. <a href="{{ route('farms.create') }}">Create one</a>.</p>
  @else
    <table class="table table-bordered text-white">
      <thead>
        <tr>
          <th>Farm ID</th>
          <th>Location</th>
          @if(\Schema::hasColumn('farms','size'))
            <th>Size</th>
          @endif
          <th>Plots Count</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($farms as $farm)
          <tr>
            <td>{{ $farm->farmID }}</td>
            <td>{{ $farm->location }}</td>
            @if(isset($farm->size))
              <td>{{ $farm->size }}</td>
            @endif
            <td>{{ $farm->plots->count() }}</td>
            <td>
              <a href="{{ route('farms.show', $farm->farmID) }}" class="btn btn-sm btn-info">View</a>
              <a href="{{ route('farms.edit', $farm->farmID) }}" class="btn btn-sm btn-warning">Edit</a>
              <form action="{{ route('farms.destroy', $farm->farmID) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete this farm?');">
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
</div>
@endsection
