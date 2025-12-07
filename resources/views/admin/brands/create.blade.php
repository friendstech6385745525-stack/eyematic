@extends('layouts.admin')
@section('title','Add Brand')
@section('content')
<h3>Add Brand</h3>
<form method="POST" action="{{ route('admin.brands.store') }}">
  @csrf
  <div class="mb-3">
    <label>Brand Name</label>
    <input type="text" name="name" class="form-control" required>
  </div>
  <button class="btn btn-success">Save</button>
  <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
