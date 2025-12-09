@extends('layouts.admin')

@section('content')
<div class="container">

    <h2>Edit Section: {{ $section->section_key }}</h2>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.home.sections.update', $section->id) }}">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ $section->title }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Subtitle</label>
            <input type="text" name="subtitle" value="{{ $section->subtitle }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $section->description }}</textarea>
        </div>

    {{--    <div class="mb-3">
            <label>Image</label><br>
            @if($section->image)
                <img src="{{ asset('storage/'.$section->image) }}" width="150" class="mb-3">
            @endif
            <input type="file" name="image" class="form-control">
        </div> --}}

        @if($section->images)
        <div class="mb-3">
            <label>Current Images</label>
            <div style="display:flex;overflow-x:auto;gap:10px;padding:10px;border:1px solid #ddd;border-radius:5px;">
                @foreach($section->images as $img)
                    <img src="{{ asset('storage/'.$img) }}" height="120" style="border-radius:8px;">
                @endforeach
            </div>
        </div>
        @endif


        <div class="mb-3">
            <label>Position</label>
            <input type="number" name="position" value="{{ $section->position }}" class="form-control">
        </div>

        <button class="btn btn-primary">Update Section</button>
    </form>

</div>
@endsection
