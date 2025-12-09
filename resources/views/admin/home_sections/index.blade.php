@extends('layouts.admin')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Home Page Sections</h2>
        <a href="{{ route('admin.home.sections.create') }}" class="btn btn-primary">+ Add New Section</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Section Key</th>
            <th>Title</th>
            <th>Position</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($sections as $section)
        <tr>
            <td>{{ $section->section_key }}</td>
            <td>{{ $section->title ?? '-' }}</td>
            <td>{{ $section->position }}</td>
            <td>
                <a href="{{ route('admin.home.sections.edit', $section->id) }}" class="btn btn-sm btn-warning">Edit</a>

                <form action="{{ route('admin.home.sections.delete', $section->id) }}" method="POST" style="display:inline-block">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Delete this section?')" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

</div>
@endsection
