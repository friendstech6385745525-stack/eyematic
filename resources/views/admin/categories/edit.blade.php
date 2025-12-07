@extends('layouts.admin')
@section('title','Edit Category')

@section('content')
<div class="container">
  <h3 class="mb-4">Edit Category</h3>

  <form method="POST" action="{{ route('admin.categories.update',$category) }}">
    @csrf @method('PUT')

    <div class="mb-3">
      <label for="name" class="form-label">Category Name</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
