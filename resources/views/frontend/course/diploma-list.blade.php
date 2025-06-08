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
                    <h2 class="section-heading-brushed brushed eyesome-font diploma-banner-title">Diplomados</h2>
                    <div class="row mt-50">
                        <div class="col-12 col-md-2 d-flex flex-column justify-content-end px-0">
                            <img src="{{ asset('frontend/assets/img/sticker-1.png') }}" class="img-fluid d-none d-md-block" alt="sticker">
                        </div>
                        <div class="col-12 col-md-9">
                            <!-- Swiper Banner main -->
                            <div class="swiper swiper-diploma-main font-lato">
                                <div class="swiper-wrapper">
                                    @foreach ($bestsellerCourses as $course)
                                        <div class="swiper-slide">
                                            <div class="card custom-diploma-item border-0 bg-white mx-3 my-1">
                                                <div class="course-img-wrap overflow-hidden">
                                                    <img src="{{ getImageFile($course->image_path) }}" alt="course" class="img-fluid">
                                                </div>
                                                <div class="card-body">
                                                    <h5 class="card-title custom-course-title mb-0 font-semi-bold">DIPLOMADO</h5>
                                                    <div class="font-14 text-center mb-3">{{ Str::limit($course->title, 38) }}</div>
                                                    <div class="course-item-bottom">
                                                        <div class="instructor-bottom-item font-12">
                                                            {{ Str::limit($course->subtitle, 72) }}
                                                        </div>
                                                        <div class="hero-btns text-center">
                                                            <a href="{{ route('course-details', $course->slug) }}" class="theme-button-darker theme-btn circle-icon">
                                                                {{ __('Ver más') }} <i data-feather="chevron-right"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Botones personalizados -->
                                <div class="swiper-button-prev icon-prev-diploma-main">
                                    <img src="{{ asset('frontend/assets/img/icons-svg/arrow-prev.svg') }}" alt="Prev">
                                </div>
                                <div class="swiper-button-next icon-next-diploma-main">
                                    <img src="{{ asset('frontend/assets/img/icons-svg/arrow-next.svg') }}" alt="Next">
                                </div>
                            </div>
                            <!-- End Swiper Banner main -->
                        </div>
                    </div>
                    <div class="row mt-5 mx-3 font-lato">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-9">
                                    <div class="font-24 font-medium">CURSOS DISPONIBLES</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-end d-flex justify-content-end">
                                        <div class="icon-arrow-swiper-diploma-secundary d-flex justify-content-center align-items-center me-2" id="button-next">
                                            <i class="fa fa-chevron-left"></i>
                                        </div>
                                        <div class="icon-arrow-swiper-diploma-secundary d-flex justify-content-center align-items-center" id="button-prev">
                                            <i class="fa fa-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Swiper Próximos diplomados -->
                            <div class="swiper swiper-diploma-secundary">
                                <div class="swiper-wrapper">
                                    @foreach ($availableCourses as $course)
                                    <div class="swiper-slide">
                                        <div class="card card-diplomado">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="{{ asset('frontend/assets/img/slider-card.jpg') }}" class="img-fluid rounded" alt="slider">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title mt-3 text-uppercase">{{ $course->category->name }}</h5>
                                                        <p class="card-text font-14 text-uppercase">{{ $course->title }}</p>
                                                        <a href="{{ route('course-details', $course->slug) }}" class="theme-button4 theme-btn mt-4">INFORMACIÓN</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <!-- End Swiper Próximos diplomados -->
                        </div>
                        <div class="col-md-4">
                            <!-- Swiper Suscríbete -->
                            <div class="swiper swiper-diploma-subscribe mt-3 mt-md-0">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <!-- Item 1 -->
                                        <img src="{{ asset('frontend/assets/img/suscribete.jpg') }}" class="img-fluid rounded" />
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Item 2 -->
                                        <img src="{{ asset('frontend/assets/img/suscribete.jpg') }}" class="img-fluid rounded" />
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Item 3 -->
                                        <img src="{{ asset('frontend/assets/img/suscribete.jpg') }}" class="img-fluid rounded" />
                                    </div>
                                </div>
                                <!-- Botones personalizados -->
                                <div class="custom-navigation-subscribe">
                                    <div class="icon-prev-diploma-subscribe"><i class="fa fa-chevron-left"></i></div>
                                    <div class="icon-next-diploma-subscribe"><i class="fa fa-chevron-right"></i></div>
                                </div>
                            </div>
                            <!-- End Swiper Suscríbete -->
                        </div>
                    </div>
                    <div class="show-all-course-area">
                        <!-- all courses grid Start-->
                        <div id="loading" class="no-course-found text-center d-none">
                            <div id="inner-status"><img src="{{ asset('frontend/assets/img/loader.svg') }}" alt="img" /></div>
                        </div>
                    </div>
                    <div class="font-24 font-medium mt-5 mb-3 mx-4 font-lato">CURSOS COMPLEMENTARIOS</div>
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
