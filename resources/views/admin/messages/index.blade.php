@extends('layouts.admin')
@section('title','Customer Messages')

@section('content')
<div class="container">
  <h2 class="mb-4">Customer Messages</h2>
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr><th>ID</th><th>Subject</th><th>User</th><th>Status</th><th>Received</th><th>Action</th></tr>
    </thead>
    <tbody>
      @foreach($messages as $m)
        <tr>
          <td>{{ $m->id }}</td>
          <td>{{ $m->subject ?? '(No subject)' }}</td>
          <td>{{ $m->user->name ?? 'Guest' }}</td>
          <td>
            <span class="badge
              @if($m->status=='new') bg-primary
              @elseif($m->status=='replied') bg-success
              @elseif($m->status=='closed') bg-secondary
              @else bg-warning @endif">
              {{ ucfirst($m->status) }}
            </span>
          </td>
          <td>{{ $m->created_at->diffForHumans() }}</td>
          <td>
            <a href="{{ route('admin.messages.show',$m) }}" class="btn btn-sm btn-info">View</a>
            <form action="{{ route('admin.messages.destroy',$m) }}" method="POST" class="d-inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this message?')">Del</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  {{ $messages->links() }}
</div>
@endsection
