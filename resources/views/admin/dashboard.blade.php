@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h3 class="fw-bold mb-4">Welcome, {{ auth()->user()->name }}</h3>
  </div>


  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-0 bg-primary text-white">
        <div class="card-body">
          <h5>Total Products</h5>
          <h2>{{ $totalProducts }}</h2>
        </div>
      </div>
    </div>

     <div class="col-md-3">
    <div class="card text-center shadow-sm border-0 bg-info text-white p-3">
      <h5>Total Orders</h5>
      <p class="fs-4 fw-bold">{{ \App\Models\Order::count() }}</p>
    </div>
  </div>

    <div class="col-md-3">
      <div class="card text-center shadow-sm border-0 bg-success text-white">
        <div class="card-body">
          <h5>Total Vendors</h5>
          <h2>{{ $totalVendors }}</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-0 bg-info text-white">
        <div class="card-body">
          <h5>Total Customers</h5>
          <h2>{{ $totalCustomers }}</h2>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center shadow-sm border-0 bg-warning text-white">
        <div class="card-body">
          <h5>Total Messages</h5>
          <h2>{{ $totalMessages }}</h2>
        </div>
      </div>
    </div>
  </div>

    <div class="col-md-6 mt-4">
    <div class="card shadow-sm p-3">
      <h5 class="mb-3">Recent Orders</h5>
      <ul class="list-group list-group-flush">
        @foreach(\App\Models\Order::latest()->take(5)->get() as $order)
          <li class="list-group-item">
            <strong>#{{ $order->id }}</strong> – RM{{ number_format($order->total,2) }}
            <span class="badge bg-info text-dark float-end">{{ ucfirst($order->status) }}</span>
          </li>
        @endforeach
      </ul>
    </div>
  </div>


    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header bg-light fw-bold">Recent Messages</div>
        <div class="card-body p-0">
          <table class="table table-striped mb-0">
            <thead>
              <tr><th>From</th><th>Subject</th><th>Date</th></tr>
            </thead>
            <tbody>
              @forelse($recentMessages as $m)
                <tr>
                  <td>{{ $m->user->name ?? 'Guest' }}</td>
                  <td>{{ $m->subject ?? '(No subject)' }}</td>
                  <td>{{ $m->created_at->format('Y-m-d') }}</td>
                </tr>
              @empty
                <tr><td colspan="3" class="text-center text-muted">No messages yet</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mt-4">
    <div class="card shadow-sm p-3">
      <h5 class="mb-3">Recent Messages</h5>
      <ul class="list-group list-group-flush">
        @foreach(\App\Models\Message::latest()->take(5)->get() as $msg)
          <li class="list-group-item">
            <strong>{{ $msg->name }}</strong>: {{ \Illuminate\Support\Str::limit($msg->message, 40) }}
          </li>
        @endforeach
      </ul>
    </div>
  </div>


</div>
@endsection





