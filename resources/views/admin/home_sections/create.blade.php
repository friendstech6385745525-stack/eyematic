@extends('layouts.admin')

@section('content')
<div class="container">

    <h2>Add Home Page Section</h2>

    <form action="{{ route('admin.home.sections.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- SECTION KEY DROPDOWN -->
        <div class="mb-3">
            <label>Section Type</label>
            <select name="section_key" class="form-control" required>
                <option value="">Select Section</option>
                <option value="header_banner">Header Banner</option>
                <option value="about">About Section</option>
                <option value="latest_updates">Latest Updates</option>
                <option value="services">Services</option>
                <option value="offers">Offers / Promo</option>
                <option value="testimonial">Testimonial</option>
                <option value="footer">Footer Content</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Subtitle</label>
            <input type="text" name="subtitle" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <!-- MULTI IMAGE UPLOAD -->
        <div class="mb-3">
            <label>Upload Images (Multiple)</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        <!-- POSITION -->
        <div class="mb-3">
            <label>Display Position</label>
            <input type="number" name="position" value="1" class="form-control" required>
        </div>

        <button class="btn btn-primary">Save Section</button>

    </form>

</div>
@endsection
