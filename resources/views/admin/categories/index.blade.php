@extends('layouts.admin')
@section('title','Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3>Categories</h3>
  <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
</div>

@if($categories->count())
<table class="table table-striped table-hover align-middle">
  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Slug</th>
      <th width="180">Action</th>
    </tr>
  </thead>
  <tbody>
  @foreach($categories as $category)
    <tr>
      <td>{{ $category->id }}</td>
      <td>{{ $category->name }}</td>
      <td>{{ $category->slug }}</td>
      <td>
        <a href="{{ route('admin.categories.edit',$category) }}" class="btn btn-sm btn-warning">Edit</a>
        <form action="{{ route('admin.categories.destroy',$category) }}" method="POST" class="d-inline">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="mt-3">
  {{ $categories->links() }}
</div>

@else
<div class="alert alert-info">No categories found.</div>
@endif
@endsection
