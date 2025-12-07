@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Add Shop Content</h2>

    <form method="POST" action="{{ route('admin.shop_content.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('admin.shop_content.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
