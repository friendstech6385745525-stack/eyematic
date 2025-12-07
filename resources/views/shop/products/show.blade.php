@extends('layouts.app')
@section('title', $product->name)

@section('content')
<div class="container">
  <div class="row">
    {{-- 🖼️ Product Images Carousel --}}
    <div class="col-md-6">
      @if($product->images && count($product->images) > 0)
      <div id="carousel{{ $product->id }}" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          @foreach($product->images as $key => $img)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
              <img src="{{ asset('storage/' . $img) }}"
                   class="d-block w-100 rounded shadow-sm"
                   style="height: 400px; object-fit: cover;">
            </div>
          @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $product->id }}" data-bs-slide="next">
          <span class="carousel-control-next-icon"></span>
        </button>
      </div>
      @else
        <div class="alert alert-secondary">No product images uploaded.</div>
      @endif
    </div>

    {{-- 🛒 Product Info --}}
    <div class="col-md-6">
      <h2 class="fw-bold mb-3">{{ $product->name }}</h2>
      <p class="fs-5 text-muted mb-2">RM{{ number_format($product->price, 2) }}</p>

      {{-- Brand and Category --}}
      <p class="mb-1">
        <strong>Brand:</strong>
        <span class="text-secondary">
          {{ $product->brand->name ?? 'No Brand Assigned' }}
        </span>
      </p>

      <p class="mb-3">
        <strong>Category:</strong>
        <span class="text-secondary">
          {{ $product->category->name ?? 'No Category Assigned' }}
        </span>
      </p>

      {{-- Description --}}
      <div class="mb-4">
        <h5>Description</h5>
        <p>{{ $product->description ?? 'No description available.' }}</p>
      </div>

      {{-- Add to Cart Form --}}
    <form method="POST" action="{{ route('cart.add', $product) }}">
            @csrf
            <div class="input-group" style="max-width:200px;">
                <input type="number" name="qty" value="1" min="1" class="form-control">
                <button class="btn btn-success">Add to Cart</button>
            </div>
            </form>

            @if(auth()->check())
            <a href="{{ route('buy.now', $product) }}" class="btn btn-warning mt-3 w-100 fw-bold">
                Buy Now
            </a>
            @else
            <a href="{{ route('login') }}" class="btn btn-warning mt-3 w-100 fw-bold">
                Login to Buy Now
            </a>
            @endif

    </div>
  </div>

  {{-- 🔗 Related Info --}}
  <hr class="my-5">
  <h4>Related Products</h4>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    @foreach(\App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(3)->get() as $related)
      <div class="col">
        <div class="card h-100 shadow-sm">
          @if($related->images)
            <img src="{{ asset('storage/'.$related->images[0]) }}" class="card-img-top" style="height:200px;object-fit:cover;">
          @endif
          <div class="card-body">
            <h6 class="card-title">{{ $related->name }}</h6>
            <p class="text-muted mb-2">RM{{ number_format($related->price,2) }}</p>
            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary w-100">View</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>
@endsection
