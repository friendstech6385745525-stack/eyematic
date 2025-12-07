@extends('layouts.app')
@section('title','Eyematic - Home')

@section('content')
<div class="text-center mb-4">
  <h1 class="fw-bold">Welcome to Eyematic</h1>
  <p class="text-muted">Your one-stop optical and eyewear shop</p>
</div>

<div class="container mb-5">
    <h2 class="mb-4">Products</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach(\App\Models\Product::take(6)->get() as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">

                    @if($product->images)
                        <img src="{{ asset('storage/'.$product->images[0]) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted">RM{{ number_format($product->price,2) }}</p>
                        <a href="{{ route('products.show',$product->slug) }}"
                           class="btn btn-outline-primary w-100">
                           View Details
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>
</div>


<div class="container my-5 latest-updates">
    <h3 class="mb-4">Latest Updates</h3>

    <div class="row">
        @foreach($contents as $content)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                @if($content->image)
                    <img src="{{ asset('storage/' . $content->image) }}" class="card-img-top">
                @endif
                <div class="card-body">
                    <h5>{{ $content->title }}</h5>
                    <p>{{ Str::limit($content->description, 120) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<hr class="my-5">

<h3>Contact Us</h3>
<form method="POST" action="{{ route('message.store') }}">
  @csrf
  <div class="mb-3">
    <label>Subject</label>
    <input type="text" name="subject" class="form-control">
  </div>
  <div class="mb-3">
    <label>Message</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
  </div>
  <button class="btn btn-success">Send Message</button>
</form>
@endsection

<style>
    .card img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.latest-updates {
    clear: both;
    margin-top: 40px;
}
.card-img-top {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

</style>
