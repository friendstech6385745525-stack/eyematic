@extends('layouts.admin')
@section('title','Brands')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Brands</h3>
  <a href="{{ route('admin.brands.create') }}" class="btn btn-success me-2">+ Add Brand</a>
  <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Add Product</a>
</div>

@if($brands->count())
<table class="table table-striped">
  <thead><tr><th>ID</th><th>Name</th><th>Slug</th><th>Action</th></tr></thead>
  <tbody>
  @foreach($brands as $brand)
    <tr>
      <td>{{ $brand->id }}</td>
      <td>{{ $brand->name }}</td>
      <td>{{ $brand->slug }}</td>
      <td>
        <a href="{{ route('admin.brands.edit',$brand) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.brands.destroy',$brand) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this brand?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>
{{ $brands->links() }}
@else
<p>No brands yet.</p>
@endif
@endsection
