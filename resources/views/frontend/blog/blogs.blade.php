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
<div class="bg-page">
    <!-- Course Single Details Area Start -->
    <section class="blog-page-area section-t-space pb-0">
        <div class="container">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="d-flex justify-content-center align-items-center">
                        <h1 class="font-semi-bold title-section-blog font-kollektif my-4 my-md-0 text-center">Quiero compartir contigo MI BLOG!</h1>
                        <img src="{{ asset('frontend/assets/img/sticker-6.png') }}" class="d-none d-md-block" height="150">
                    </div>
                    <div class="video-player-area">
                        <video id="player" class="rounded-4" playsinline controls controlsList="nodownload">
                            <source src="{{ asset('frontend/assets/videos/test.mp4') }}" type="video/mp4" >
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Course Single Details Area End -->
    <section class="bg-pink-sucribete pb-0">
        <div class="container">
            <div class="row font-kollektif">
                <div class="col-12 col-md-7 col-lg-8">
                    <div class="row">
                        @foreach ($blogs as $blog)
                        <div class="col-12 col-md-6 mb-4">
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
                                        <a href="{{ route('blog-details', $blog->slug) }}" class="btn btn-dark px-4 py-2">{{ __('Read More') }}</a>
                                        <!-- Fecha -->
                                        <small class="text-muted">{{ $blog->created_at->format(' M  j, Y')  }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-12 col-md-5 col-lg-4 mb-4">
                    <div class="card rounded-4 h-100 mx-4" style="background-color: #f6f4f3;">
                        <div class="card-body mx-3">
                            <a href="{{ route('blog-list') }}">
                                <div class="bg-primary-dark pill text-uppercase font-14 mt-3 py-2 d-flex justify-content-center align-items-center">
                                    Más artículos
                                </div>
                            </a>
                            <ul class="popular-posts mt-4">
                                @foreach($recentBlogs as $recentBlog)
                                    <li>
                                        <div class="sidebar-blog-item d-flex">
                                            <div class="flex-shrink-0">
                                                <div class="sidebar-blog-item-img-wrap overflow-hidden">
                                                    <a href="{{ route('blog-details', $recentBlog->slug) }}">
                                                        <img src="{{ getImageFile($recentBlog->image_path) }}" alt="img" class="card-img"></a>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 {{selectedLanguage()->rtl == 1 ? 'me-3' : 'ms-3' }}">
                                                <h6 class="sidebar-blog-item-title"><a href="{{ route('blog-details', $recentBlog->slug) }}">{{ __(@$recentBlog->title) }}</a></h6>
                                                <p class="blog-author-name-publish-date font-12 font-medium color-gray mb-0">{{ $recentBlog->created_at->format(' M  j, Y')  }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>                  
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 align-items-center">
                <div class="col-12 col-md-6 text-center">
                    <span class="bg-aqua px-4 py-3 font-bold font-kollektif" style="">SUSCRÍBETE LAS PRÓXIMAS PUBLICACIONES!</span>
                </div>
                <div class="col-12 col-md-3 font-CerebriSans text-center text-md-start mt-3 mt-md-0" style="letter-spacing: 1px">
                    <div>My Mailing List</div>
                    <form id="postsForm">
                        @csrf
                        <input type="email" name="email" placeholder="Email" class="input-newsletters mt-2 py-1" required>
                        <button class="theme-btn btn-white border-gray-suscribete text-uppercase mt-2">Suscribir</button>
                    </form>
                </div>
                <div class="col-12 col-md-3">
                    <img src="{{ asset('frontend/assets/img/sticker-5.png') }}" height="150">
                </div>
            </div>
        </div>
    </section>
</div>

<input type="hidden" class="searchBlogRoute" value="{{ route('search-blog.list') }}">
<input type="hidden" class="routeSubscribePosts" value="{{ route('subscribe.posts') }}">

@endsection

@push('script')
    <!-- Start:: Blog Search  -->
    <script src="{{ asset('frontend/assets/js/custom/search-blog-list.js') }}"></script>
    <!-- End:: Blog Search  -->
    <script src="{{ asset('frontend/assets/js/custom/newsletter-suscription.js') }}"></script>
@endpush
