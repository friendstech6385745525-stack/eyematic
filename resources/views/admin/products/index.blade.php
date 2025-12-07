@extends('layouts.admin')
@section('title', 'Products')

@section('content')
<div class="container">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="fw-bold">Products</h3>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
      + Add Product
    </a>
  </div>

  @if($products->count())
  <div class="card shadow-sm">
    <div class="card-body p-0">
      <table class="table table-striped table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr>
            <th scope="col" width="80">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Brand</th>
            <th scope="col">Category</th>
            <th scope="col">Vendor</th>
            <th scope="col" class="text-end">Price (RM)</th>
            <th scope="col" class="text-center">Stock</th>
            <th scope="col" width="180">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($products as $product)
          <tr>
            {{-- Product image --}}
            <td>
              @if($product->images && count($product->images) > 0)
                <img src="{{ asset('storage/'.$product->images[0]) }}"
                     width="60" height="60"
                     class="rounded border" style="object-fit: cover;">
              @else
                <span class="text-muted small">No Image</span>
              @endif
            </td>

            {{-- Product name --}}
            <td>
              <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="fw-semibold text-decoration-none">
                {{ $product->name }}
              </a>
            </td>

            {{-- Brand --}}
            <td>{{ $product->brand->name ?? '—' }}</td>

            {{-- Category --}}
            <td>{{ $product->category->name ?? '—' }}</td>

            {{-- Vendor --}}
            <td>{{ $product->user->name ?? 'Admin' }}</td>

            {{-- Price --}}
            <td class="text-end">RM{{ number_format($product->price,2) }}</td>

            {{-- Stock --}}
            <td class="text-center">{{ $product->stock }}</td>

            {{-- Action --}}
            <td>
              <a href="{{ route('admin.products.edit',$product) }}" class="btn btn-sm btn-warning">
                Edit
              </a>
              <form action="{{ route('admin.products.destroy',$product) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">
                  Delete
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="mt-3">
    {{ $products->links() }}
  </div>

  @else
  <div class="alert alert-info">No products found. <a href="{{ route('admin.products.create') }}">Add one now</a>.</div>
  @endif
</div>
@endsection
