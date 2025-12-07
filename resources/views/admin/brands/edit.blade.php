@extends('layouts.admin')
@section('title','Edit Brand')
@section('content')
<h3>Edit Brand</h3>
<form method="POST" action="{{ route('admin.brands.update',$brand) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Brand Name</label>
    <input type="text" name="name" class="form-control" value="{{ $brand->name }}" required>
  </div>
  <button class="btn btn-success">Update</button>
  <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
