@extends('frontend.layouts.app')

@section('meta')
    <meta name="description" content="{{ __($event->meta_description) }}">
    <meta name="keywords" content="{{ __($event->meta_keywords) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Event">
    <meta property="og:title" content="{{ __($event->meta_title) }}">
    <meta property="og:description" content="{{ __($event->meta_description) }}">
    <meta property="og:image" content="{{ getImageFile($event->og_image) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Event">
    <meta name="twitter:title" content="{{ __($event->meta_title) }}">
    <meta name="twitter:description" content="{{ __($event->meta_description) }}">
    <meta name="twitter:image" content="{{ getImageFile($event->og_image) }}">
@endsection

@section('content')
<div class="custom-bg">
    <!-- Hero Section Start -->
    <section class="hero-section section-t-space">
        <div class="container">
            <div class="hero-content">
                <div class="hero-details">
                    <h1 class="mt-4">{{ $event->title }}</h1>
                    <div class="row">
                        <div class="col-md-8">
                            <p class="hero-date">{{ ucfirst($event->start->translatedFormat('l j \d\e F \d\e Y, g:i A')) }} - {{ $event->location }}</p>
                            @if($event->category)
                                <div class="hero-category">{{ $event->category->name }}</div>
                            @endif
                            <p>{!! $event->details !!}</p>
                        </div>
                        <div class="col-md-4">
                            <img src="{{ getImageFile($event->image) }}" class="img-fluid mt-30">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->
</div>
@endsection
