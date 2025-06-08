@extends('frontend.layouts.app')
@section('meta')
    @php
        $metaData = getMeta('course');
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
        <!-- Courses Page Area Start -->
        <section class="courses-page-area section-t-space-100 pb-0">
            <div class="course-container">
                <div class="row shop-content mx-0">
                    <!-- Sidebar (Filtros) -->
                    @include('frontend.course.render-sidebar-courses-by-category')
                    <!-- Sidebar (Filtros) End-->
                    <div class="col-md-8 col-lg-9 col-xl-9 show-all-course-area-wrap">
                        <!-- Section Landing -->
                        @include('frontend.course.render-featured-courses-header')
                        <!-- Section Landing End -->
                        <!-- All courses -->
                        <div class="show-all-course-area">
                            <div id="loading" class="no-course-found text-center d-none">
                                <div id="inner-status"><img src="{{ asset('frontend/assets/img/loader.svg') }}" alt="img" /></div>
                            </div>
                            <div id="appendCourse">
                                @include('frontend.course.render-course-list')
                            </div>
                        </div>
                        <!-- All courses End -->
                    </div>
                    <!-- Show all course area End-->
                </div>
            </div>
        </section>
        <!-- Courses Page Area End -->
    </div>

    <!-- some important hidden id for filter.js -->
    <input type="hidden" class="route" value="{{ route('getFilterCourse') }}">
    <input type="hidden" class="fetch-data-route" value="{{ route('course.fetch-data') }}">
@endsection

@push('style')
<link rel="stylesheet" href="{{asset('frontend/assets/fonts/eyesome/eyesome.css')}}">
<link rel="stylesheet" href="{{ asset('frontend-theme-3/assets/css/swiper.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/new-design/course.css') }}">
@endpush

@push('script')
    <script>
        var paginateRoute = "{{ route('courses') }}"
    </script>
    <script src="{{ asset('frontend/assets/js/course/filter.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToCart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToWishlist.js') }}"></script>
    <script src="{{ asset('frontend-theme-3/assets/js/swiper.js') }}"></script>
    <script>
        var swiper_course_main = new Swiper('.swiper-course-main', {
            loop: true,
            navigation: {
                nextEl: '.icon-next-course-main',
                prevEl: '.icon-prev-course-main',
            },
            breakpoints: {
                768: {
                    slidesPerView: 1,
                },
                1024: {
                    slidesPerView: 3,
                    centeredSlides: true,
                },
            },
        });
    </script>
@endpush
