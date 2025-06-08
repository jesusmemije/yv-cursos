@extends('frontend.layouts.app')
@section('meta')
    @php
        $metaData = getMeta('blog');
    @endphp

    <meta name="description" content="{{ __($metaData['meta_description']) }}">
    <meta name="keywords" content="{{ __($metaData['meta_keyword']) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Learning">
    <meta property="og:title" content="{{ __($metaData['meta_title']) }}">
    <meta property="og:description" content="{{ __($metaData['meta_description']) }}">
    <meta property="og:image" content="{{ __($metaData['og_image']) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Learning">
    <meta name="twitter:title" content="{{ __($metaData['meta_title']) }}">
    <meta name="twitter:description" content="{{ __($metaData['meta_description']) }}">
    <meta name="twitter:image" content="{{ __($metaData['og_image']) }}">
@endsection
@section('content')
    <div class="bg-page custom-bg">
        <section class="section-t-space pb-0">
            <div class="container">
                <div class="row font-kollektif mt-4">
                    @foreach ($blogs as $blog)
                        <div class="col-md-4 mb-4">
                            <div class="card rounded-4 h-100 mx-4">
                                <div class="custom-img-container">
                                    <img src="{{ getImageFile($blog->image_path) }}" class="img-fluid">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase">{{ $blog->title }}</h5>
                                    <p class="card-text">{{ strip_tags(Str::limit($blog->details, 200)) }}</p>
                                </div>
                                <div class="card-footer">
                                    <!-- Contenedor del pie de tarjeta (leer más y fecha) -->
                                    <div class="d-flex justify-content-between align-items-center mt-4">
                                        <!-- Botón Leer más -->
                                        <a href="{{ route('blog-details', $blog->slug) }}"class="btn btn-dark px-4 py-2">{{ __('Read More') }}</a>
                                        <!-- Fecha -->
                                        <small class="text-muted">{{ $blog->created_at->format(' M  j, Y') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Paginación -->
                <div class="pb-4">
                    {{ $blogs->links() }}
                </div>
            </div>
        </section>
    </div>
@endsection
