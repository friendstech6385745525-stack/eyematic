@extends('layouts.admin')
@section('title','View Message')

@section('content')
<div class="container">
  <h2 class="mb-3">Message #{{ $message->id }}</h2>

  <div class="card mb-4">
    <div class="card-body">
      <h5>Subject: {{ $message->subject ?? '(No subject)' }}</h5>
      <p><strong>From:</strong> {{ $message->user->name ?? 'Guest' }} ({{ $message->user->email ?? 'N/A' }})</p>
      <p><strong>Received:</strong> {{ $message->created_at->format('Y-m-d H:i') }}</p>
      <hr>
      <p>{{ $message->message }}</p>
    </div>
  </div>

  <form method="POST" action="{{ route('admin.messages.update',$message) }}" class="mb-3">
    @csrf @method('PUT')
    <label>Status</label>
    <select name="status" class="form-select" style="max-width:200px; display:inline-block;">
      <option value="new"      {{ $message->status=='new'?'selected':'' }}>New</option>
      <option value="read"     {{ $message->status=='read'?'selected':'' }}>Read</option>
      <option value="replied"  {{ $message->status=='replied'?'selected':'' }}>Replied</option>
      <option value="closed"   {{ $message->status=='closed'?'selected':'' }}>Closed</option>
    </select>
    <button class="btn btn-success ms-2">Update</button>
  </form>

  <a href="{{ route('admin.messages.index') }}" class="btn btn-secondary">Back to list</a>
</div>
@endsection
