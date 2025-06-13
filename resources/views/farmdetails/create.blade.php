@extends('layouts.app')
@section('title', 'Create Farm')

@section('content')
<div class="profile-card">
  <h2>Create New Farm</h2>

  <form action="{{ route('farms.store') }}" method="POST">
    @csrf
    <div class="form-group mb-3">
      <label class="form-label text-white">Location</label>
      <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
      @error('location')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    @if(\Schema::hasColumn('farms','size'))
    <div class="form-group mb-3">
      <label class="form-label text-white">Size</label>
      <input type="text" name="size" class="form-control" value="{{ old('size') }}">
      @error('size')<div class="text-danger">{{ $message }}</div>@enderror
    </div>
    @endif
    <button type="submit" class="btn btn-update">Create Farm</button>
    <a href="{{ route('farms.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
