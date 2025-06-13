@extends('layouts.app')
@section('title', 'Edit Plot')

@section('content')
<div class="profile-card">
  <h2>Edit Plot #{{ $plot->plotID }} of Farm #{{ $farm->farmID }}</h2>

  <form action="{{ route('plots.update', ['farm' => $farm->farmID, 'plot' => $plot->plotID]) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
      <label class="form-label text-white">Name (optional)</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $plot->name) }}">
      @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label text-white">Min Latitude</label>
      <input type="text" name="min_latitude" class="form-control" value="{{ old('min_latitude', $plot->min_latitude) }}" required>
      @error('min_latitude')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label text-white">Max Latitude</label>
      <input type="text" name="max_latitude" class="form-control" value="{{ old('max_latitude', $plot->max_latitude) }}" required>
      @error('max_latitude')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label text-white">Min Longitude</label>
      <input type="text" name="min_longitude" class="form-control" value="{{ old('min_longitude', $plot->min_longitude) }}" required>
      @error('min_longitude')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-group mb-3">
      <label class="form-label text-white">Max Longitude</label>
      <input type="text" name="max_longitude" class="form-control" value="{{ old('max_longitude', $plot->max_longitude) }}" required>
      @error('max_longitude')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    <button type="submit" class="btn btn-update">Update Plot</button>
    <a href="{{ route('farms.show', $farm->farmID) }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
