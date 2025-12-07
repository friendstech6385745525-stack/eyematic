@extends('layouts.admin')
@section('title','Edit Product')

@section('content')
<div class="container">
  <h3 class="mb-4">Edit Product</h3>

  <form method="POST" action="{{ route('admin.products.update',$product) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div class="mb-3">
      <label>Product Name</label>
      <input type="text" name="name" value="{{ $product->name }}" class="form-control" required>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Brand</label>
        <select name="brand_id" class="form-select">
          <option value="">-- Select Brand --</option>
          @foreach($brands as $brand)
            <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : '' }}>
              {{ $brand->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label>Category</label>
        <select name="category_id" class="form-select">
          <option value="">-- Select Category --</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ $cat->id == $product->category_id ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="mb-3">
      <label>Description</label>
      <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Price</label>
        <input type="number" name="price" step="0.01" value="{{ $product->price }}" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label>Stock</label>
        <input type="number" name="stock" value="{{ $product->stock }}" class="form-control" required>
      </div>
    </div>

    <div class="mb-3">
      <label>Upload More Images</label>
      <input type="file" name="images[]" multiple class="form-control">
      <div class="mt-3 d-flex flex-wrap gap-2">
        @if($product->images)
          @foreach($product->images as $img)
            <img src="{{ asset('storage/'.$img) }}" width="100" height="100" class="rounded border">
          @endforeach
        @endif
      </div>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
  </form>
</div>
@endsection
