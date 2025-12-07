@extends('layouts.admin')
@section('title','Add Product')

@section('content')
<div class="container">
  <h3 class="mb-4">Add Product</h3>

  <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
      <label>Product Name</label>
      <input type="text" name="name" class="form-control" required>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Brand</label>
        <select name="brand_id" class="form-select">
          <option value="">-- Select Brand --</option>
          @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label>Category</label>
        <select name="category_id" class="form-select">
          <option value="">-- Select Category --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="3"></textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Price</label>
        <input type="number" name="price" step="0.01" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label>Product Images (multiple)</label>
      <input type="file" name="images[]" multiple class="form-control">
    </div>

    <button class="btn btn-success">Save Product</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
