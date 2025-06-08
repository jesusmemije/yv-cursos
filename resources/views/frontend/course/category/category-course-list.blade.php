@extends('frontend.layouts.app')

@section('meta')
    <meta name="description" content="{{ __($category->meta_description) }}">
    <meta name="keywords" content="{{ __($category->meta_keywords) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Learning">
    <meta property="og:title" content="{{ __($category->meta_title) }}">
    <meta property="og:description" content="{{ __($category->meta_description) }}">
    <meta property="og:image" content="{{ getImageFile($category->og_image) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Learning">
    <meta name="twitter:title" content="{{ __($category->meta_title) }}">
    <meta name="twitter:description" content="{{ __($category->meta_description) }}">
    <meta name="twitter:image" content="{{ getImageFile($category->og_image) }}">
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('frontend/assets/fonts/eyesome/eyesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-theme-3/assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/new-design/diploma.css') }}">
@endpush
@section('content')
    <!-- Courses Page Area Start -->
    <div class="bg-page custom-bg">
        <section class="courses-page-area section-t-space-100">
            <div class="row shop-content mx-0">
                <!-- Courses Sidebar start-->
                @include('frontend.course.render-sidebar-courses-by-category')
                <!-- Courses Sidebar End-->
                <!-- Show all course area start-->
                <div class="col-md-8 col-lg-9 col-xl-9 show-all-course-area-wrap">
                    <div class="show-all-course-area">
                        <!-- all courses grid Start-->
                        <div id="loading" class="no-course-found text-center d-none">
                            <div id="inner-status"><img src="{{ asset('frontend/assets/img/loader.svg') }}" alt="img" /></div>
                        </div>
                    </div>
                    <div class="font-24 font-medium mt-5 mb-3 mx-4 font-lato">{{$category->name}}</div>
                    <div id="appendCourse">
                        @include('frontend.course.render-course-list')
                    </div>
                    <!-- all courses grid End-->
                </div>
            </div>
            <!-- Show all course area End-->
        </section>
    </div>
    <!-- Courses Page Area End -->

    <!-- some important hidden id for filter.js -->
    <input type="hidden" class="category_id" value="{{ $category->id }}">
    <input type="hidden" class="route" value="{{ route('getFilterCourse') }}">
    <input type="hidden" class="fetch-data-route" value="{{ route('course.fetch-data') }}">
@endsection
@push('script')
    <script>
        var paginateRoute = "{{ route('courses') }}"
    </script>
    <script src="{{ asset('frontend/assets/js/course/filter.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToCart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToWishlist.js') }}"></script>
    <script src="{{ asset('frontend-theme-3/assets/js/swiper.js') }}"></script>

    <script>
        var swiper_diploma_main = new Swiper('.swiper-diploma-main', {
            loop: true,
            navigation: {
                nextEl: '.icon-next-diploma-main',
                prevEl: '.icon-prev-diploma-main',
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

        var swiper_secundary = new Swiper('.swiper-diploma-secundary', {
            loop: true,
        });

        $('#button-next').on('click', function() {
            swiper_secundary.slideNext();
        });

        $('#button-prev').on('click', function() {
            swiper_secundary.slidePrev();
        });

        var swiper_subscribe = new Swiper('.swiper-diploma-subscribe', {
            loop: true,
            navigation: {
                nextEl: '.icon-next-diploma-subscribe',
                prevEl: '.icon-prev-diploma-subscribe',
            },
        });
    </script>
@endpush
