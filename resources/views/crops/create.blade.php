@extends('layouts.app')
@section('title', 'Add Crop')

@section('content')

<div class="profile-card"> <h2>Add New Crop</h2> <form action="{{ route('crops.store') }}" method="POST"> @csrf
    <div class="form-group mb-3">
  <label class="form-label text-white">Crop Name</label>
  <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
  @error('name')<div class="text-danger">{{ $message }}</div>@enderror
</div>

@foreach(['moisture','temperature','humidity','light'] as $field)
  <div class="form-group mb-3">
    <label class="form-label text-white">Optimal {{ ucfirst($field) }} Min</label>
    <input type="number" step="any" name="optimal_{{ $field }}_min" class="form-control" value="{{ old("optimal_{$field}_min") }}">
    @error("optimal_{$field}_min")<div class="text-danger">{{ $message }}</div>@enderror
  </div>

  <div class="form-group mb-3">
    <label class="form-label text-white">Optimal {{ ucfirst($field) }} Max</label>
    <input type="number" step="any" name="optimal_{{ $field }}_max" class="form-control" value="{{ old("optimal_{$field}_max") }}">
    @error("optimal_{$field}_max")<div class="text-danger">{{ $message }}</div>@enderror
  </div>
@endforeach

<button type="submit" class="btn btn-success">Save Crop</button>
<a href="{{ route('crops.index') }}" class="btn btn-secondary">Cancel</a>
</form> </div> @endsection