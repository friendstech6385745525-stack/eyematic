@extends('layouts.app')
@section('title','Vendor Dashboard')

@section('content')
<div class="container">
  <h2 class="mb-4">Vendor Dashboard</h2>

  <div class="row text-center mb-4">
    <div class="col-md-4">
      <div class="card bg-primary text-white shadow-sm">
        <div class="card-body">
          <h5>My Products</h5>
          <h2>{{ \App\Models\Product::where('user_id',auth()->id())->count() }}</h2>
        </div>
      </div>
    </div>
  </div>

  <div class="text-end mb-3">
    <a href="{{ route('vendor.products.create') }}" class="btn btn-success">+ Add Product</a>
  </div>

  <div class="card shadow-sm">
    <div class="card-header fw-bold">Recent Products</div>
    <div class="card-body p-0">
      <table class="table table-striped mb-0">
        <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Stock</th></tr></thead>
        <tbody>
          @foreach(\App\Models\Product::where('user_id',auth()->id())->latest()->take(5)->get() as $p)
            <tr>
              <td>{{ $p->id }}</td>
              <td>{{ $p->name }}</td>
              <td>RM{{ number_format($p->price,2) }}</td>
              <td>{{ $p->stock }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
