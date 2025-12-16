@extends('layouts.app')
@section('title','Eyematic - Home')

@section('content')
<div class="text-center mb-4">
  <h1 class="fw-bold">Welcome to Eyematic</h1>
  <p class="text-muted">Your one-stop optical and eyewear shop</p>
</div>
@php
    $sections = \App\Models\HomepageSection::orderBy('position')->get();
@endphp

@foreach($sections as $sec)

    {{-- HEADER SECTION --}}
    @if($sec->section_key == 'header_banner')
<!-- Hero Section -->
<section class="hero-section py-5"  style="
        background-image: url('{{ asset('storage/'.$sec->background_image) }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        min-height: 85vh;
        position: relative;
    ">
        @if(!empty($sec->background_video))
        <video autoplay muted loop playsinline class="hero-bg-video">
            <source src="{{ asset('storage/'.$sec->background_video) }}" type="video/mp4">
        </video>
    @endif



    <div class="container">
        <div class="row align-items-center">
            <!-- Left Content -->
            <div class="col-lg-6 mb-4">
                <h1 class="hero-title">{{ $sec->title }}</h1>
                <h4 class="hero-subtitle text-primary">{{ $sec->subtitle }}</h4>
                <p class="hero-desc">{{ $sec->description }}
                </p>

                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg mt-3">Shop Now</a>
                <a href="{{ route('eye_test.form') }}" class="btn btn-outline-secondary btn-lg mt-3">Book Eye Test</a>
            </div>
<div class="col-lg-6">
   <div class="v-scroll-wrapper">
    <div class="v-scroll-track">
        @foreach($sec->images as $img)
            <div class="v-scroll-item">
                <img src="{{ asset('storage/'.$img) }}" alt="">
            </div>
        @endforeach

        {{-- Duplicate images to create infinite loop --}}
        @foreach($sec->images as $img)
            <div class="v-scroll-item">
                <img src="{{ asset('storage/'.$img) }}" alt="">
            </div>
        @endforeach
    </div>
</div>
</div>
    </div>
        </div>
        </section>
    @endif
@endforeach

<div class="container mb-5">
    <h2 class="mb-4">Products</h2>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach(\App\Models\Product::take(6)->get() as $product)
            <div class="col">
                <div class="card h-100 shadow-sm">

                    @if($product->images)
                        <img src="{{ asset('storage/'.$product->images[0]) }}"
                             class="card-img-top"
                             style="height:200px; object-fit:cover;">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="text-muted">RM{{ number_format($product->price,2) }}</p>
                        <a href="{{ route('products.show',$product->slug) }}"
                           class="btn btn-outline-primary w-100">
                           View Details
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@foreach($sections as $sec)
    @if($sec->section_key == 'services')
        @foreach($sec->images as $img)
            <div class="stack-card" style="z-index: {{ 100 - $loop->index }};">
                <div class="stack-image">
                    <img src="{{ asset('storage/'.$img) }}">
                </div>

                <div class="stack-content">
                    <h2>{{ $sec->title }}</h2>
                    <p>{{ $sec->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
        @endif
@endforeach

@foreach($sections as $sec)
@if($sec->section_key === 'about')

<section class="about-eyematic py-5">
    <div class="container">
        <div class="row align-items-center">

            {{-- LEFT : IMAGE / VIDEO --}}
            <div class="col-lg-6 mb-4">
                <div class="about-media">
                    @if($sec->background_video)
                        <video autoplay muted loop playsinline>
                            <source src="{{ asset('storage/'.$sec->background_video) }}" type="video/mp4">
                        </video>
                    @elseif($sec->background_image)
                        <img src="{{ asset('storage/'.$sec->background_image) }}" alt="About Eyematic">
                        @elseif ($sec->images)
                        <img src="{{ asset('storage/'.$sec->images[0]) }}" alt="About Eyematic">
                    @endif
                </div>
            </div>

            {{-- RIGHT : CONTENT --}}
            <div class="col-lg-6">
                <span class="about-badge">About Us</span>
                <h2 class="about-title">{{ $sec->title }}</h2>
                <h5 class="about-subtitle">{{ $sec->subtitle }}</h5>
                <p class="about-desc"></p>

                {{-- FEATURES --}}
                <div class="about-features">
                    <div class="feature-item">
                        <i class="bi bi-eye"></i>
                        <span>Advanced Eye Testing</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-truck"></i>
                        <span>Home Eye Test Service</span>
                    </div>
                    <div class="feature-item">
                        <i class="bi bi-shield-check"></i>
                        <span>100% Genuine Lenses</span>
                    </div>
                </div>

                {{-- STATS --}}
                <div class="about-stats">
                    <div>
                        <h3>{{ $sec->description }}+</h3>
                        <p>Years Experience</p>
                    </div>
                    <div>
                        <h3>5K+</h3>
                        <p>Happy Customers</p>
                    </div>
                    <div>
                        <h3>100%</h3>
                        <p>Eye Care Trust</p>
                    </div>
                </div>

                <a href="{{ route('eye_test.form') }}" class="btn btn-primary mt-3">
                    Book Eye Test
                </a>
            </div>

        </div>
    </div>
</section>

@endif
@endforeach

{{-- LATEST UPDATES USING shop_content
@include('partials.latest-updates') --}}


<div class="container my-5 latest-updates">
    <h3 class="mb-4">Latest Updates</h3>

    <div class="row">
        @foreach($contents as $content)
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                @if($content->image)
                    <img src="{{ asset('storage/' . $content->image) }}" class="card-img-top">
                @endif
                <div class="card-body">
                    <h5>{{ $content->title }}</h5>
                    <p>{{ Str::limit($content->description, 120) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<hr class="my-5">

<h3>Contact Us</h3>
<form method="POST" action="{{ route('message.store') }}">
  @csrf
  <div class="mb-3">
    <label>Subject</label>
    <input type="text" name="subject" class="form-control">
  </div>
  <div class="mb-3">
    <label>Message</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
  </div>
  <button class="btn btn-success">Send Message</button>
</form>
@endsection



<style>
   .card img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.latest-updates {
    clear: both;
    margin-top: 40px;
}
.card-img-top {
    width: 100%;
    height: 250px;
    object-fit: cover;
}

.image-slider-container {
    overflow-x: auto;
    white-space: nowrap;
    padding: 10px 0;
}

.image-slider {
    display: inline-flex;
    gap: 15px;
}

.slider-item img {
    width: 300px;
    height: 180px;
    object-fit: cover;
    border-radius: 10px;
    transition: 0.3s;
}

.slider-item img:hover {
    transform: scale(1.05);
}

.hero-section {
background-color: transparent !important;
}

.hero-title {
    font-size: 42px;
    font-weight: 800;
}

.hero-subtitle {
    font-size: 22px;
    margin-top: 10px;
}

.hero-desc {
    font-size: 16px;
    line-height: 1.6;
    margin-top: 15px;
}

/* Slider Wrapper */
.hero-slider-wrapper {
    overflow-x: auto;
    white-space: nowrap;
    padding-bottom: 10px;
    scroll-behavior: smooth;
}

.hero-slider {
    display: inline-flex;
    gap: 15px;
}

.hero-slide-item img {
    width: 350px;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.15);
    transition: .3s;
}

.hero-slide-item img:hover {
    transform: scale(1.05);
}

/* Background video */
.hero-bg-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 1;
}

/* Dark overlay */
.hero-overlay {
    position: absolute;
    inset: 0;
    background: rgba(204, 20, 20, 0.7);
    z-index: 1;


}

/* Make sure existing content stays on top */
.hero-section .container {
    position: relative;
    z-index: 2;
}


/* Wrapper */
.v-scroll-wrapper {
    position: relative;
    height: 420px;           /* control visible height */
    overflow: hidden;
    border-radius: 14px;
}


/* Track */
.v-scroll-track {
    display: flex;
    flex-direction: column;
    gap: 18px;
    animation: scroll-up 25s linear infinite;
    }


.v-scroll-wrapper:hover .v-scroll-track {
    animation-play-state: paused; /* pause on hover */
}

/* Each Image Item
.v-scroll-item {
    flex-shrink: 0;
    width: 30%;
    height: 200px;  adjust image height
}
*/
.v-scroll-item {
    margin-bottom: 16px;
}


.v-scroll-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0px 4px 12px rgba(0,0,0,0.18);
}

/* Vertical Upward Animation */
@keyframes scroll-up {
    0%   { transform: translateY(0); }
    100% { transform: translateY(-50%); } /* Move up half track */
}

.about-eyematic {
    background: #f9fafb;
}

.about-media {
    position: relative;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.about-media img,
.about-media video {
    width: 100%;
    height: 420px;
    object-fit: cover;
}

.about-badge {
    display: inline-block;
    background: #e7f1ff;
    color: #0d6efd;
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}

.about-title {
    font-size: 2.4rem;
    font-weight: 800;
}

.about-subtitle {
    color: #0d6efd;
    margin-bottom: 12px;
}

.about-desc {
    color: #555;
    line-height: 1.7;
}

.about-features {
    display: grid;
    grid-template-columns: repeat(2,1fr);
    gap: 12px;
    margin: 20px 0;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.feature-item i {
    font-size: 1.4rem;
    color: #0d6efd;
}

.about-stats {
    display: flex;
    gap: 30px;
    margin: 25px 0;
}

.about-stats h3 {
    font-size: 1.8rem;
    color: #0d6efd;
    font-weight: 800;
}

.about-stats p {
    margin: 0;
    font-size: 0.9rem;
    color: #666;
}

/* ===== SERVICES AUTO SCROLL ===== */

.services-scroll-section {
    position: relative;
    height: 160vh;              /* important for scroll space */
    background: #f6f7f9;
    padding-top: 100px;
}

.services-wrapper {
    position: sticky;
    top: 120px;
    display: flex;
    flex-direction: column;
    gap: 40px;
    max-width: 900px;
    margin: auto;
}

.service-card {
    background: #ffffff;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    transform: translateY(0);
}

/* stacked look */
.service-card:not(:first-child) {
    margin-top: -80px;
}

.stack-scroll-section {
    height: 220vh; /* scroll space */
    background: #f6f7f9;
    padding-top: 120px;
}

.stack-wrapper {
    position: sticky;
    flex-shrink: 0;
    object-fit: cover;
    top: 120px;
    max-width: 1100px;
    margin: auto;
}

.stack-card {
    display: flex;
    gap: 300px;
    background: white;
    border-radius: 28px;
    padding: 40px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.1);
    margin-bottom: 10px;   /* overlap */
    position: relative;
    flex-direction: column;
    overflow: auto;
}

.stack-card:last-child {
    margin-bottom: 0;
}

.stack-image img {
    width: 260px;
    height: 180px;
    object-fit: cover;
    border-radius: 18px;
}

.stack-content h2 {
    font-size: 28px;
    margin-bottom: 12px;
}

</style>

{{--<script>
window.addEventListener('scroll', () => {
    const section = document.querySelector('.services-scroll-section');
    const wrapper = document.querySelector('.services-wrapper');

    if (!section || !wrapper) return;

    const rect = section.getBoundingClientRect();
    const windowHeight = window.innerHeight;

    if (rect.top <= windowHeight && rect.bottom >= 0) {
        const progress = (windowHeight - rect.top) / (windowHeight + rect.height);
        const move = Math.min(0, -progress * 200);

        wrapper.style.transform = `translateY(${move}px)`;
    }
});
</script>
--}}

<script>
window.addEventListener('scroll', () => {
    document.querySelectorAll('.stack-card').forEach((card, i) => {
        const rect = card.getBoundingClientRect();
        const offset = Math.max(0, 150 - rect.top);

        card.style.transform = `translateY(${offset * 0.3}px)`;
        card.style.zIndex = 100 - i;
    });
});
</script>
