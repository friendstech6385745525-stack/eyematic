@extends('layouts.admin')
@section('title','Add Category')

@section('content')
<div class="container">
  <h3 class="mb-4">Add New Category</h3>

  <form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input type="text" name="name" id="name" class="form-control" required placeholder="Enter category name">
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Save Category</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
