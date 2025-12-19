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

@foreach($sections as $sec)
@if($sec->section_key === 'brands')

<section class="brand-section my-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-3">{{ $sec->title }}</h2>
        <p class="text-center text-muted mb-4">{{ $sec->description }}</p>
    </div>

    <div class="brand-slider">
        <div class="brand-track">
            {{-- First loop --}}
            @foreach($sec->images as $img)
                <div class="brand-item">
                    <img src="{{ asset('storage/'.$img) }}" alt="Brand">
                </div>
            @endforeach

            {{-- Duplicate for infinite scroll --}}
            @foreach($sec->images as $img)
                <div class="brand-item">
                    <img src="{{ asset('storage/'.$img) }}" alt="Brand">
                </div>
            @endforeach
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
@if($sec->section_key === 'offers')


<section class="promo-section"
    style="background-image:url('{{ $sec->background_image ? asset('storage/'.$sec->background_image) : '' }}')">

    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <span class="promo-badge">{{ $sec->subtitle }}</span>
                <h2 class="promo-title">{{ $sec->title }}</h2>
                <p class="promo-desc">{{ $sec->description }}</p>

                @if($sec->button_text)
                    <a href="{{ $sec->button_link }}" class="btn btn-warning btn-lg">
                        {{ $sec->button_text }}
                    </a>
                @endif
            </div>

            <div class="col-lg-6 text-center">
                @if(!empty($sec->images))
                    <img src="{{ asset('storage/'.$sec->images[0]) }}"
                         class="promo-img">
                @endif
            </div>

        </div>
    </div>
</section>

@endif
@endforeach


@foreach($sections as $sec)
@if($sec->section_key === 'services')

<section class="services-stack container my-5">

    <h2 class="fw-bold mb-5">{{ $sec->title }}</h2>

    @foreach($sec->images as $index => $img)
        <div class="service-card"
             style="z-index: {{ 100 - $index }}; background-image:url('{{ $sec->background_image ? asset('storage/'.$sec->background_image) : '' }}')">

            <div class="service-inner">
                <!-- Image -->
                <div class="service-img">
                    <img src="{{ asset('storage/'.$img) }}" alt="">
                </div>

                <!-- Content -->
                <div class="service-content">
                    <h4>{{ $sec->subtitle }}</h4>
                    <p>{{ $sec->description }}</p>
                </div>
            </div>

        </div>
    @endforeach

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

<hr class="my-5">

<footer class="site-footer" style="background-image:url('{{ $sec->background_image ? asset('storage/'.$sec->background_image) : '' }}')">
    <div class="container">
        <div class="row">

@foreach($sections as $sec)
@if($sec->section_key === 'footer')

            <div class="col-md-4">
                
                @if(!empty($sec->images))
                    <img src="{{ asset('storage/'.$sec->images[0]) }}"
                         class="footer-logo mb-3">
                @endif
                <p>{{ $sec->description }}</p>
            </div>

            <div class="col-md-4">
                <h5>Contact</h5>
                <p>{{ $sec->title }}</p>
                <p>{{ $sec->subtitle }}</p>
            </div>

            <div class="col-md-4">
                <h5>Follow Us</h5>
                {!! $sec->data !!}
            </div>

@endif
@endforeach

        </div>
    </div>
</footer>

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

.services-stack {
    position: relative;
}

.service-card {
    position: relative;
    margin-bottom: 0px;
    transition: transform .3s ease;
}

.service-card:hover {
    transform: translateY(-8px);
}

.service-inner {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 25px 50px rgba(0,0,0,.12);
    display: flex;
    gap: 30px;
    padding: 30px;
    align-items: center;
}

.service-img img {
    width: 220px;
    height: 180px;
    object-fit: cover;
    border-radius: 20px;
}

.service-content h4 {
    font-weight: 700;
    margin-bottom: 10px;
}

.service-content p {
    color: #666;
}

/* Mobile */
@media (max-width: 768px) {
    .service-inner {
        flex-direction: column;
        text-align: center;
    }

    .service-img img {
        width: 100%;
        height: 200px;
    }
}

.brand-section {
    overflow: hidden;
    background: #fff;
}

.brand-slider {
    width: 100%;
    overflow: hidden;
    position: relative;
}

.brand-track {
    display: flex;
    width: max-content;
    animation: brandScroll 25s linear infinite;
}

.brand-slider:hover .brand-track {
    animation-play-state: paused;
}

.brand-item {
    flex: 0 0 auto;
    padding: 20px 40px;
}

.brand-item img {
    height: 70px;
    width: auto;
    filter: grayscale(0%);
    opacity: .7;
    transition: all .3s ease;
}

.brand-item img:hover {
    filter: grayscale(0);
    opacity: 1;
    transform: scale(1.05);
}

@keyframes brandScroll {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.promo-section {
    padding: 80px 0;
    background-size: cover;
    background-position: center;
    position: relative;
    color: #fff;
}

.promo-section::before {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(0,0,0,.55);
}

.promo-section .container {
    position: relative;
    z-index: 2;
}

.promo-badge {
    background: #ffc107;
    color: #000;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
}

.promo-title {
    font-size: 42px;
    margin: 15px 0;
}

.promo-desc {
    font-size: 18px;
    margin-bottom: 25px;
}

.promo-img {
    max-width: 100%;
    border-radius: 20px;
    box-shadow: 0 25px 60px rgba(0,0,0,.4);
}

.site-footer {
    background: #121212;
    color: #121212;
    padding: 60px 0 30px;
}

.site-footer h5 {
    color: #121212;
    margin-bottom: 15px;
}

.footer-logo {
    max-height: 60px;
}

.footer-bottom {
    text-align: center;
    margin-top: 30px;
    padding-top: 15px;
    border-top: 1px solid #121212;
    font-size: 14px;
}

</style>

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
