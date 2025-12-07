@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2>Edit Shop Content</h2>

    <form method="POST" action="{{ route('admin.shop_content.update', $shop_content->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input name="title" class="form-control" value="{{ $shop_content->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required>{{ $shop_content->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if($shop_content->image)
                <img src="{{ asset('storage/' . $shop_content->image) }}" width="150">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-success">Update</button>
        <a href="{{ route('admin.shop_content.index') }}" class="btn btn-secondary">Cancel</a>

    </form>
</div>
@endsection
