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
        {{-- Replace / Add Scroll Images --}}
            <div class="mb-3">
                <label class="form-label">Change Scroll Images</label>
                <input type="file" name="images[]" multiple class="form-control">
                <small class="text-muted">Multiple images (scroll view)</small>
            </div>

            {{-- Background Image --}}
            <div class="mb-3">
                <label class="form-label">Background Image</label>
                <input type="file" name="background_image" class="form-control">

                @if($section->background_image)
                    <img src="{{ asset('storage/'.$section->background_image) }}"
                        class="mt-2 rounded"
                        style="max-height:120px;">
                @endif
            </div>

            {{-- Background Video --}}
            <div class="mb-3">
                <label class="form-label">Background Video (MP4)</label>
                <input type="file" name="background_video" class="form-control">

                @if($section->background_video)
                    <video class="mt-2 rounded" width="200" muted autoplay loop>
                        <source src="{{ asset('storage/'.$section->background_video) }}" type="video/mp4">
                    </video>
                @endif
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
