@extends('layouts.app')
@section('title', 'Edit Farm')

@section('content')
<div class="profile-card">
  <h2>Edit Farm #{{ $farm->farmID }}</h2>

  <form action="{{ route('farms.update', $farm->farmID) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
      <label class="form-label text-white">Location</label>
      <input type="text" name="location" class="form-control" value="{{ old('location', $farm->location) }}" required>
      @error('location')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    @if(\Schema::hasColumn('farms','size'))
    <div class="form-group mb-3">
      <label class="form-label text-white">Size</label>
      <input type="text" name="size" class="form-control" value="{{ old('size', $farm->size) }}">
      @error('size')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    @endif
    <button type="submit" class="btn btn-update">Update Farm</button>
    <a href="{{ route('farms.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
