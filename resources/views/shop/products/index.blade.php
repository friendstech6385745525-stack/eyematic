@extends('layouts.app')
@section('title','Products')

@section('content')
<div class="container">

  <h2 class="fw-bold mb-4">
    @isset($brand)
      Products by Brand: <span class="text-primary">{{ $brand->name }}</span>
    @elseif(isset($category))
      Products in Category: <span class="text-primary">{{ $category->name }}</span>
    @else
      All Products
    @endisset
  </h2>

  <div class="row row-cols-1 row-cols-md-3 g-4">
    @forelse($products as $product)
      <div class="col">
        <div class="card h-100 shadow-sm">
          @if($product->images)
            <img src="{{ asset('storage/'.$product->images[0]) }}" class="card-img-top" style="height:200px;object-fit:cover;">
          @endif
          <div class="card-body">
            <h6 class="fw-bold">{{ $product->name }}</h6>
            <p class="text-muted mb-1">RM{{ number_format($product->price,2) }}</p>
            <small class="d-block mb-2">
              <span class="text-secondary">{{ $product->brand->name ?? 'No Brand' }}</span> |
              <span class="text-secondary">{{ $product->category->name ?? 'No Category' }}</span>
            </small>
            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary w-100">View Details</a>
          </div>
        </div>
      </div>
    @empty
      <p>No products found.</p>
    @endforelse
  </div>

  <div class="mt-4">
    {{ $products->links() }}
  </div>
</div>
@endsection
