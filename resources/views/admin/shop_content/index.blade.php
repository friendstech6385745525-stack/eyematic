@extends('layouts.admin')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Shop Content</h2>
        <a href="{{ route('admin.shop_content.create') }}" class="btn btn-primary">+ Add Content</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th width="180">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contents as $content)
            <tr>
                <td>{{ $content->id }}</td>
                <td>{{ $content->title }}</td>
                <td>
                    @if($content->image)
                        <img src="{{ asset('storage/' . $content->image) }}"
                             width="80" height="60" style="object-fit:cover;">
                    @endif
                </td>
                <td>{{ Str::limit($content->description, 80) }}</td>
                <td>
                    <a href="{{ route('admin.shop_content.edit', $content->id) }}"
                       class="btn btn-warning btn-sm">Edit</a>

                    <form method="POST" action="{{ route('admin.shop_content.destroy', $content->id) }}"
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this content?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $contents->links() }}

</div>
@endsection
