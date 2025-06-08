@extends('frontend.layouts.app')
@push('style')
<link rel="stylesheet" href="{{asset('frontend/assets/fonts/eyesome/eyesome.css')}}">
<link rel="stylesheet" href="{{ asset('frontend-theme-3/assets/css/swiper.min.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/new-design/calendar.css') }}">
@endpush
<?php use Carbon\Carbon; ?>
@section('meta')
    @php
        $metaData = getMeta('home');
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
    @if(isAddonInstalled('LMSZAIPRODUCT'))
    <link rel="stylesheet" href="{{ asset('addon/product/css/ecommerce-product.css') }}">
    @endif
@endsection
@section('content')
    <!-- Header Start -->
    <header class="hero-area gradient-hero-bg">
        <div class="section-t-space-100">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 offset-md-1">
                        <div class="hero-content">
                            <div class="text text-center text-md-start font-ttnorms mt-3 mt-md-0">
                                <h1 class="hero-heading text-uppercase mt-2"><span class="font-bold">Cursos, </span> Diplomados</h1>
                                <h1 class="hero-heading hero-heading-medium text-uppercase mt-2">Y <span class="font-bold">Capacitación, </span> de</h1>
                                <h1 class="hero-heading text-uppercase mt-2"><span class="font-bold">Cosmetología</span></h1>
                            </div>
                            <div class="card mt-4 rounded-4 card-next-event">
                                <div class="card-body px-md-5 px-3 font-montserrat">
                                    <div class="row">
                                        <div class="col-6">
                                            <span class="title-event-next">Próximo Live</span>
                                            <div class="mt-2 d-flex">
                                                <img src="{{ asset('frontend/assets/img/home/icon-home-video.svg') }}" width="42" height="42">
                                                @if ($nextEvent) <a href="{{ route('event-details', $nextEvent->slug) }}" class="text-inherit"> @endif
                                                    <div class="ms-2">
                                                        <div class="card-text font-semi-bold">{{ $nextEvent ? Str::limit($nextEvent->title, 30) : "No hay próximo Live" }}</div>
                                                        <div class="card-text">{{ $nextEvent ? Carbon::parse($nextEvent->start)->format('g:i A') . " Hora Mex" : "" }}</div>
                                                    </div>
                                                @if ($nextEvent) </a> @endif
                                            </div>
                                        </div>
                                        <div class="col-6 vertical-line">
                                            <span class="title-event-next ms-3">Próximo Curso</span>
                                            <div class="mt-2 d-flex ms-3">
                                                <img src="{{ asset('frontend/assets/img/home/icon-home-date.svg') }}" width="42" height="42" class="img-fluid">
                                                @if ($nextCourse) <a href="{{ route('event-details', $nextCourse->slug) }}" class="text-inherit"> @endif
                                                    <div class="ms-2">
                                                        <div class="card-text font-semi-bold">{{ $nextCourse ? $nextCourse->start->format('d F Y') : "No hay próximo curso" }}</div>
                                                    </div>
                                                @if ($nextEvent) </a> @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(!get_option('private_mode') || !auth()->guest())
                            <div class="mt-4 text-center text-md-start">
                                <a href="{{ route('courses') }}" class="theme-btn theme-button1 rounded-5 text-uppercase font-ttnorms">Explorar cursos</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if ($mainImages->isNotEmpty())
                    <div class="col-12 col-md-5 offset-md-1 mt-3 mt-md-0">
                        <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper swiper-hero-secundary">
                            <div class="swiper-wrapper">
                                @foreach ($mainImages as $image)
                                <div class="swiper-slide">
                                    <a href="{{ $image->redirect_url }}" target="_blank">
                                        <img src="{{ getImageFile($image->image_url) }}" />
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="bg-hero-gray">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-6" style="position: relative; padding: 20px 0">
                            <img src="{{ asset('frontend/assets/img/sticker-1.png') }}" alt="" width="100px" class="hero-sticker d-none d-md-block">
                            @if ($mainImages->isNotEmpty())
                            <div class="wrapper-swiper-hero-primary">
                                <div thumbsSlider="" class="swiper swiper-hero-primary">
                                    <div class="swiper-wrapper">
                                        @foreach ($mainImages as $image)
                                        <div class="swiper-slide">
                                            <img src="{{ getImageFile($image->image_url) }}" />
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="swiper-button-next" id="hero-button-next"></div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->
    
    <!-- <div class="svg-background"></div> -->
    
    @if($home->special_feature_area == 1)
    <!-- Special Feature Area Start -->
    <section class="special-feature-area p-0">
        <div class="container">
            <div class="row">
                <!-- Single Feature Item start-->
                <div class="col-md-4">
                    <div class="single-feature-item d-flex align-items-center">
                        <div class="flex-shrink-0 feature-img-wrap">
                            <img src="{{ getImageFile(get_option('home_special_feature_first_logo')) }}" alt="feature">
                        </div>
                        <div class="flex-grow-1 ms-3 feature-content">
                            <h6>{{ __(get_option('home_special_feature_first_title')) }}</h6>
                            <p>{{ __(get_option('home_special_feature_first_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Item End-->
                <!-- Single Feature Item start-->
                <div class="col-md-4">
                    <div class="single-feature-item d-flex align-items-center">
                        <div class="flex-shrink-0 feature-img-wrap">
                            <img src="{{ getImageFile(get_option('home_special_feature_second_logo')) }}" alt="feature">
                        </div>
                        <div class="flex-grow-1 ms-3 feature-content">
                            <h6>{{ __(get_option('home_special_feature_second_title')) }}</h6>
                            <p>{{ __(get_option('home_special_feature_second_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Item End-->
                <!-- Single Feature Item start-->
                <div class="col-md-4">
                    <div class="single-feature-item d-flex align-items-center">
                        <div class="flex-shrink-0 feature-img-wrap">
                            <img src="{{ getImageFile(get_option('home_special_feature_third_logo')) }}" alt="feature">
                        </div>
                        <div class="flex-grow-1 ms-3 feature-content">
                            <h6>{{ __(get_option('home_special_feature_third_title')) }}</h6>
                            <p>{{ __(get_option('home_special_feature_third_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Single Feature Item End-->

            </div>
        </div>
    </section>
    <!-- Special Feature Area End -->
    @endif

    @if(!get_option('private_mode') || !auth()->guest())
    @if($home->courses_area == 1)
    <!-- All Courses Area Start -->
    <section class="courses-area mt-0 section-t-space pb-0 custom-bg-courses">
        <div class="container bg-white pt-3 px-5">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="d-flex align-items-start">
                            <div class="section-heading-img"><img src="{{ asset('frontend/assets/img/sticker-2.png') }}" class="w-100px" alt="Course"></div>
                            <div class="font-lato">
                                <h3 class="section-heading font-semi-bold">{{ __(get_option('course_title')) }}</h3>
                                <p class="section-sub-heading">{{ __(get_option('course_subtitle')) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('courses') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All') }} <i data-feather="arrow-right"></i></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>

            <!-- One to one consultation Slider start -->
            <div class="row">
                <div class="col-12">
                    @if(count($featuredCourses))
                    <!-- Consultation instructor slider items wrap -->
                    <div class="course-slider-items owl-carousel owl-theme">
                        @foreach ($featuredCourses as $course)
                        @php
                            $userRelation = getUserRoleRelation($course->user);
                        @endphp
                        <div class="col-12 col-sm-4 col-lg-3 w-100">
                            @include('frontend.partials.course')
                        </div>
                        @endforeach
                    </div>
                    @else
                    {{ __("No Course Found") }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- All Courses Area END -->
    @endif 

    @if($home->category_courses_area == 1)
    <!-- Board Selection of Courses Area Start -->
    <section class="courses-area section-t-space section-b-85-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img"><img src="{{ getImageFile(get_option('category_course_logo')) }}" alt="Category Course"></div>
                            <div>
                                <h3 class="section-heading">{{ __(get_option('category_course_title')) }}</h3>
                                <p class="section-sub-heading">{{ __(get_option('category_course_subtitle')) }}</p>
                            </div>
                        </div>

                        <!-- Tab panel nav list -->
                        <div class="course-tab-nav-wrap d-flex justify-content-between">
                            <ul class="nav nav-tabs tab-nav-list border-0" id="myTab" role="tablist">
                                @foreach($featureCategories as $key => $category)
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link {{ $key == 0 ? 'active' : '' }}" id="{{ $category->slug }}-tab" data-bs-toggle="tab" href="#{{ $category->slug }}" role="tab"
                                           aria-controls="{{ $category->slug }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">{{ __($category->name) }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <!-- Tab panel nav list -->

                    </div>
                    <!-- section-left-align-->
                </div>
            </div>

            <!-- Tab Content-->
            <div class="tab-content" id="myTabContent">
                @foreach($featureCategories as $key => $category)
                    <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="{{ $category->slug }}" role="tabpanel" aria-labelledby="{{ $category->slug }}-tab">
                            <div class="course-slider-items owl-carousel owl-theme">
                                <!-- Course item start -->
                                @foreach($category->courses as $course)
                                @php
                                    $userRelation = getUserRoleRelation($course->user);
                                @endphp
                                <div class="col-12 col-sm-4 col-lg-3 w-100">
                                    @include('frontend.partials.course')
                                </div>
                                @endforeach
                                <!-- Course item end -->
                            </div>
                        </div>
                @endforeach
            </div>

        </div>
    </section>
    <!-- Board Selection of Courses Area End -->
    @endif

    @if(isAddonInstalled('LMSZAIPRODUCT'))
    @if($home->product_area == 1)
    <section class="bg-light courses-area courses-bundels-area section-b-85-space section-t-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img"><img class="w-60px" src="{{ getImageFile(get_option('product_section_logo')) }}" alt="Product"></div>
                            <div>
                                <h3 class="section-heading">{{ __(get_option('product_section_title')) }}  @if(env('LOGIN_HELP') == 'active') <span class="color-deep-orange font-18">(Addon)</span> @endif </h3>
                                <p class="section-sub-heading">{{ __(get_option('product_section_subtitle')) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('lms_product.frontend.list') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All') }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>
            <!-- Tab Content-->
            <div class="tab-content" id="myTabContent1">
                    <div class="tab-pane fade show active" id="React" role="tabpanel" aria-labelledby="React-tab">
                        <div class="course-slider-items owl-carousel owl-theme">
                            @foreach($products as $product)
                                @php
                                    $relation = getUserRoleRelation($product->user)
                                @endphp
                                <!-- product item start -->
                                <div class="col-12 col-sm-4 col-lg-3 w-100">
                                    @include('addon.product.partials.product-card')
                                </div>
                                <!-- product item end -->
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </section>
    @endif
    @endif

    @if($home->bundle_area == 1)
    @if(count($bundles) > 0)
    <!-- Latest Courses bundles Area Start -->
    <section class="courses-area courses-bundels-area section-t-space section-b-85-space bg-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img"><img src="{{ getImageFile(get_option('bundle_course_logo')) }}" alt="Course"></div>
                            <div>
                                <h3 class="section-heading">{{ __(get_option('bundle_course_title')) }}</h3>
                                <p class="section-sub-heading">{{ __(get_option('bundle_course_subtitle')) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('bundles') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All') }} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>
            <!-- Tab Content-->
            <div class="tab-content" id="myTabContent1">
                    <div class="tab-pane fade show active" id="React" role="tabpanel" aria-labelledby="React-tab">
                        <div class="course-slider-items owl-carousel owl-theme">
                            @foreach($bundles as $bundle)
                                @php
                                    $relation = getUserRoleRelation($bundle->user)
                                @endphp
                                <!-- Course item start -->
                                <div class="col-12 col-sm-4 col-lg-3 w-100">
                                    <div class="card course-item border-0 radius-3 bg-white">
                                        <div class="course-img-wrap overflow-hidden">
                                            <a href="{{ route('bundle-details', [$bundle->slug]) }}"><img src="{{ getImageFile($bundle->image) }}" alt="course"
                                                                                                                         class="img-fluid"></a>
                                            <div class="course-item-hover-btns position-absolute">
                                        <span class="course-item-btn addToWishlist" data-bundle_id="{{ $bundle->id }}" data-route="{{ route('student.addToWishlist') }}"
                                              title="Add to Wishlist">
                                                    <i data-feather="heart"></i>
                                                </span>
                                                <span class="course-item-btn addToCart" data-bundle_id="{{ $bundle->id }}" data-route="{{ route('student.addToCart') }}"
                                                      title="Add to Cart">
                                                    <i data-feather="shopping-bag"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <h5 class="card-title course-title"><a
                                                    href="{{ route('bundle-details', [$bundle->slug]) }}">{{ Str::limit($bundle->name, 40) }}</a></h5>
                                            <p class="card-text instructor-name-certificate font-medium font-12">
                                                <a href="{{ route('userProfile',$bundle->user->id) }}">{{ @$bundle->user->$relation->name }}</a>
                                                @if(@$bundle->user->$relation->level_id != NULL)
                                                    | {{ @$bundle->user->$relation->ranking_level->name }}
                                                @endif
                                            </p>
                                            <div class="course-item-bottom">
                                                <div class="instructor-bottom-item font-14 font-semi-bold mb-15">{{ __('Courses') }}: <span
                                                        class="color-hover">{{ @$bundle->bundleCourses->count() }}</span></div>
                                                <div class="instructor-bottom-item font-14 font-semi-bold">{{ __('Price') }}: <span class="color-hover">
                                                @if($currencyPlacement == 'after')
                                                            {{$bundle->price}} {{ $currencySymbol }}
                                                        @else
                                                            {{ $currencySymbol }} {{$bundle->price}}
                                                        @endif
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Course item end -->
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </section>
    <!-- Latest Courses bundles Area End -->
    @endif
    @endif
    @endif

    @if($home->top_category_area == 1)
    <!-- Our Top Categories Area Start -->
    <section class="top-categories-area gradient-bg p-0">
        <div class="section-overlay section-t-space section-b-space">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <div class="section-heading-img"><img src="{{ asset(get_option('top_category_logo')) }}" alt="Our categories"></div>
                            <h3 class="section-heading section-heading-light">{{ __(get_option('top_category_title')) }}</h3>
                            <p class="section-sub-heading section-sub-heading-light">{{ __(get_option('top_category_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <div class="row top-categories-content-wrap">
                    @foreach(@$firstFourCategories as $firstFourCategory)

                        <!-- Single Feature Item start-->
                        <div class="col-md-6 col-lg-6 col-xl-3">
                            <div class="single-feature-item top-cat-item align-items-center">
                                <div class="flex-shrink-0 feature-img-wrap">
                                    <img src="{{ getImageFile($firstFourCategory->image ?? 'frontend/assets/img/top-categories-icon/1.png') }}" alt="categories">
                                </div>
                                <div class="flex-grow-1 mt-3 feature-content">
                                    <h6>{{ Str::limit($firstFourCategory->name, 20) }}</h6>
                                    <p>{{ @$firstFourCategory->courses->count() }} {{ __('Courses') }}</p>
                                </div>
                            </div>
                        </div>
                        <!-- Single Feature Item End-->

                    @endforeach
                    @if(!get_option('private_mode') || !auth()->guest())
                    <!-- section button start-->
                    <div class="col-12 text-center section-btn">
                        <a href="{{ route('courses') }}" class="theme-btn theme-button1">{{ __('All Categories') }} <i data-feather="arrow-right"></i></a>
                    </div>
                    <!-- section button end-->
                    @endif

                </div>
            </div>
        </div>
    </section>
    <!-- Our Top Categories Area End -->
    @endif

    @if($home->upcoming_courses_area == 1)
    <!-- All Courses Area Start -->
    <section class="courses-area section-t-space section-b-85-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img"><img src="{{ getImageFile(get_option('upcoming_course_logo')) }}" alt="Course"></div>
                            <div>
                                <h3 class="section-heading">{{ __(get_option('upcoming_course_title')) }}</h3>
                                <p class="section-sub-heading">{{ __(get_option('upcoming_course_subtitle')) }}</p>
                            </div>
                        </div>
                        <a href="{{ route('courses') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All') }} <i data-feather="arrow-right"></i></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>

            <!-- One to one consultation Slider start -->
            <div class="row">
                <div class="col-12">
                    @if(count($upcomingCourses))
                    <!-- Consultation instructor slider items wrap -->
                    <div class="course-slider-items owl-carousel owl-theme">
                        @foreach ($upcomingCourses as $course)
                        @php
                            $userRelation = getUserRoleRelation($course->user);
                        @endphp
                        <div class="col-12 col-sm-4 col-lg-3 w-100">
                            @include('frontend.partials.course')
                        </div>
                        @endforeach
                    </div>
                    @else
                    {{ __("No Course Found") }}
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- All Courses Area END -->
    @endif


    @if(!get_option('private_mode') || !auth()->guest())
    @if($home->consultation_area == 1)
    @if(count($consultationInstructors) > 0)
    <!-- One to One Consultation Area Start -->
    <section class="courses-area courses-bundels-area one-to-one-consultation-area section-t-space section-b-85-space bg-page">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img">
                                <img src="{{ asset('uploads_demo/about_us_general/team-members-heading-img.png') }}" alt="Consultant">
                            </div>
                            <div>
                                <h3 class="section-heading">{{ __('One to one consultation') }}</h3>
                                <p class="section-sub-heading">{{ __('Consult with your favorite consultant!') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('consultationInstructorList') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All') }} <i data-feather="arrow-right"></i></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>

            <!-- One to one consultation Slider start -->
            <div class="row">
                <div class="col-12">
                    <!-- Consultation instructor slider items wrap -->
                    <div class="course-slider-items one-to-one-slider-items owl-carousel owl-theme">
                        @foreach($consultationInstructors as $instructorUser)
                            <!-- Course item start -->
                            <div class="col-12 col-sm-4 col-lg-3 w-100 mt-0 mb-25">
                                <x-frontend.instructor :user="$instructorUser" :type=INSTRUCTOR_CARD_TYPE_TWO />
                            </div>
                            <!-- Course item end -->
                        @endforeach
                    </div>
                    <!-- Consultation instructor slider items wrap -->
                </div>
            </div>
            <!-- One to one consultation Slider end -->

        </div>
    </section>
    <!-- One to One Consultation Area End -->
    @endif
    @endif
    @endif

    <!-- Subscription Start -->
    @if( @$home->subscription_show == 1 && get_option('subscription_mode'))
    @include('frontend.home.partial.subscription-home-list')
    @endif
    <!-- Subscription End -->

    @if($home->instructor_area == 1)
    <!-- Our Top Instructor Area Start -->
    <section class="top-instructor-area section-t-space bg-white">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- section-left-align-->
                    <div class="section-left-title-with-btn d-flex justify-content-between align-items-end">
                        <div class="section-title section-title-left d-flex align-items-start">
                            <div class="section-heading-img"><img src="{{ getImageFile(get_option('top_instructor_logo')) }}" alt="Our categories"></div>
                            <div>
                                <h3 class="section-heading">{{ __(get_option('top_instructor_title')) }}</h3>
                                <p class="section-sub-heading">{{ __(get_option('top_instructor_subtitle')) }}</p>
                            </div>
                        </div>

                        <a href="{{ route('instructor') }}" class="theme-btn theme-button2 theme-button3">{{ __('View All Instructor') }} <i data-feather="arrow-right"></i></a>
                    </div>
                    <!-- section-left-align-->
                </div>
            </div>
            <div class="row top-instructor-content-wrap">
                @foreach ($instructors->take(4) as $instructorUser)
                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 mt-0 mb-25">
                    <x-frontend.instructor :user="$instructorUser" :type=INSTRUCTOR_CARD_TYPE_ONE />
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Our Top Instructor Area End -->
    @endif

    @if($home->video_area == 1)
    <!-- Video Area Start -->
    <section class="video-area custom-bg-forma">
        <div class="container">
            <div class="row align-items-center welcome-hello">
                <div class="col-md-6 col-lg-7 col-xl-7">
                    <div class="video-area-left position-relative d-flex align-items-center justify-content-center">
                        <img src="{{ asset('frontend/assets/img/yv-hello.png') }}" alt="video" class="w-420px">
                        <button type="button" class="play-btn position-absolute" data-bs-toggle="modal" data-bs-target="#newVideoPlayerModal">
                            <img src="{{ asset('frontend/assets/img/icons-svg/play.svg') }}" alt="play">
                        </button>
                    </div>
                </div>
                <div class="col-md-6 col-lg-5 col-xl-5">
                    <div class="video-area-right position-relative text-md-start text-center">

                        <div class="section-title text-center">
                            <h2 class="section-heading-brushed brushed brushed-hello eyesome-font">Hola!</h2>
                        </div>

                        <div class="section-title font-lato">
                            <h3 class="section-heading-hello text-uppercase">{{ Str::limit(__(get_option('become_instructor_video_title')), 100) }}</h3>
                        </div>

                        <div class="font-lato">
                            <p>
                                Confió en que el contenido de esta plataforma sea
                                de tu interés y que resulte de utilidad para tus
                                estudios y publicaciones futuras.
                            </p>
                        </div>

                        <div class="mt-3 font-lato">
                            <p>Bienvenidas y Bienvenidos.</p>
                        </div>

                        <!-- section button start-->
                        <div class="col-12 section-btn">
                            <a href="https://cursos.yessicavilla.com/page/semblanza" class="theme-btn theme-button1 rounded-5 text-uppercase font-ttnorms">Conoce mi experiencia</a>
                        </div>
                        <!-- section button end-->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Video Area End -->
    @endif

    <!-- Saas Plan Start -->
    @if( @$home->saas_show == 1 && get_option('saas_mode'))
    @include('frontend.home.partial.saas-home-list')
    @endif
    <!-- Saas Plan End -->

    <!-- Next Events -->
    <section class="customers-says-area gradient-bg p-0">
        <div class="section-overlay py-md-5 py-0">
            <img src="{{ asset('frontend/assets/img/home/events-points.png') }}" class="corner-top-image w-6rem d-none d-md-block">
            <img src="{{ asset('frontend/assets/img/home/events-points.png') }}" class="corner-bottom-image w-6rem pb-2 d-none d-md-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-uppercase text-center font-OpenSansBold title-color-dark">Próximos eventos</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-8 offset-md-2">
                        <div id="calendarContainer">
                            @include('frontend.partials.calendar-events')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Next Events -->

    @if($home->customer_says_area == 1)
    <!-- Customers Says/ testimonial Area Start -->
    <section class="customers-says-area gradient-bg p-0">
        <div class="section-overlay section-t-space">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section-title section-title-center text-center">
                            <div class="section-heading-img"><img src="{{ asset('frontend/assets/img/sticker-3.png') }}" class="w-150px" alt="Our categories"></div>
                            <h3 class="section-heading text-uppercase curve-testimonial pb-4 w-30 font-lato font-semi-bold ">{{ __(get_option('customer_say_title')) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1">
                        <div class="swiper-wrapper-testimonial">
                            <!-- Swiper testimonial -->
                            <div class="swiper swiper-testimonial py-5">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_first_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-1.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_first_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_first_position')) }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_second_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-2.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_second_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_second_position')) }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_third_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-3.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_third_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_third_position')) }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_first_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-1.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_first_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_first_position')) }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_second_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-2.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_second_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_second_position')) }}</p>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                    <div class="swiper-slide">
                                        <!-- Single Testimonial Item start-->
                                        <div class="item">
                                            <div class="testimonial-item">
                                                <div class="testimonial-top-content d-flex align-items-center">
                                                    <div class="flex-shrink-0 quote-img-wrap">
                                                        <img src="{{ asset('frontend/assets/img/icons-svg/quote.svg') }}" alt="quote">
                                                    </div>
                                                </div>
                                                <div class="testimonial-bottom-content font-OpenSauceOne">
                                                    
                                                    <p class="font-17">{{ __(get_option('customer_say_third_comment_description') )}}</p>
                                                </div>
                                                <div class="testimonial-content d-flex">
                                                    <img src="{{ asset('frontend/assets/img/home/avatar-3.png') }}" class="me-3" width="42" height="42">
                                                    <div>
                                                        <h6 class="font-16 font-ttnorms font-bold">{{ __(get_option('customer_say_third_name')) }}</h6>
                                                        <p class="font-13 font-medium font-OpenSauceOne">{{ __(get_option('customer_say_third_position')) }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Single Testimonial Item End-->
                                    </div>
                                </div>
                                <br>
                                <!-- Paginación -->
                                <div class="swiper-pagination"></div>
                            </div>
                            <!-- Botones de navegación -->
                            <div class="swiper-button-prev"></div>
                            <div class="swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Customers Says/ testimonial Area End -->
    @endif

    <section class="gradient-bg">
        <div class="section-overlay section-t-space">
            <div class="container text-md-start text-center">
                <div class="row position-relative">
                    <div class="col-12 col-md-10 offset-md-1">
                        <h4 class="text-uppercase title-color-dark font-lato font-medium">Te invito a conocer mis redes sociales</h4>
                        <img src="{{ asset('frontend/assets/img/sticker-4.png') }}" class="position-absolute d-none d-md-block" style="right: 15%; top: -40px;"  width="280" alt="sticker">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <img src="{{ asset('frontend/assets/img/home/redes-yt.png') }}" class="img-fluid d-block d-md-none mt-4" alt="redes-yt">
                    </div>
                </div>
                <div class="row mt-4 mt-md-5">
                    <div class="col-12 col-md-9 offset-md-1">
                        <div class="d-flex">
                            <img src="{{ asset('frontend/assets/img/home/redes-yt.png') }}" class="img-fluid w-50 d-none d-md-block" alt="redes-yt">
                            <div class="mt-md-5">
                                <div class="font-40 title-suscribete font-lato font-bold">Descúbre</div>
                                <div class="font-36 eyesome-font my-canal">Mi Canal</div>
                                <div class="font-40 title-suscribete font-lato font-bold">De YOUTUBE!</div>
                                <div class="font-16 font-inter">Te invito a conocer el material educativo y contenido que tengo
                                para ti, enfocado en técnicas de estética y capacitación para spa.</div>
                                <button type="submit">
                                    <img src="{{ asset('frontend/assets/img/home/btnsuscribir.svg') }}" width="120" height="60">
                                  </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4 mt-md-5">
                    <div class="col-12">
                        <div class="d-flex justify-content-center separate-network-icons">
                            <img src="{{ asset('frontend/assets/img/home/youtube.svg') }}" width="62" height="62" alt="youtube">
                            <img src="{{ asset('frontend/assets/img/home/instagram.svg') }}" width="62" height="62" alt="instagram">
                            <img src="{{ asset('frontend/assets/img/home/tiktok.svg') }}" width="62" height="62" alt="tiktok">
                            <img src="{{ asset('frontend/assets/img/home/facebook.svg') }}" width="62" height="62" alt="facebook">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($home->achievement_area == 1)
    <!-- Achievement Area Start -->
    <section class="achievement-area">
        <div class="container">
            <div class="row achievement-content-area">
                <!-- Achievement Item start-->
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="achievement-item d-flex align-items-center">
                        <div class="flex-shrink-0 achievement-img-wrap">
                            <img src="{{ getImageFile(get_option('achievement_first_logo')) }}" alt="achievement">
                        </div>
                        <div class="flex-grow-1 ms-3 achievement-content">
                            <h6>{{ __(get_option('achievement_first_title')) }}</h6>
                            <p>{{ __(get_option('achievement_first_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Achievement Item End-->

                <!-- Achievement Item start-->
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="achievement-item d-flex align-items-center">
                        <div class="flex-shrink-0 achievement-img-wrap">
                            <img src="{{ getImageFile(get_option('achievement_second_logo')) }}" alt="achievement">
                        </div>
                        <div class="flex-grow-1 ms-3 achievement-content">
                            <h6>{{ __(get_option('achievement_second_title')) }}</h6>
                            <p>{{ __(get_option('achievement_second_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Achievement Item End-->

                <!-- Achievement Item start-->
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="achievement-item d-flex align-items-center">
                        <div class="flex-shrink-0 achievement-img-wrap">
                            <img src="{{ getImageFile(get_option('achievement_third_logo')) }}" alt="achievement">
                        </div>
                        <div class="flex-grow-1 ms-3 achievement-content">
                            <h6>{{ __(get_option('achievement_third_title')) }}</h6>
                            <p>{{ __(get_option('achievement_third_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Achievement Item End-->

                <!-- Achievement Item start-->
                <div class="col-md-6 col-lg-6 col-xl-3">
                    <div class="achievement-item d-flex align-items-center">
                        <div class="flex-shrink-0 achievement-img-wrap">
                            <img src="{{ getImageFile(get_option('achievement_four_logo')) }}" alt="achievement">
                        </div>
                        <div class="flex-grow-1 ms-3 achievement-content">
                            <h6>{{ __(get_option('achievement_four_title')) }}</h6>
                            <p>{{ __(get_option('achievement_four_subtitle')) }}</p>
                        </div>
                    </div>
                </div>
                <!-- Achievement Item End-->
            </div>
        </div>
    </section>
    <!-- Achievement Area End -->
    @endif

    @if($home->faq_area == 1)
    <!-- FAQ Area Start -->
    <section class="faq-area home-page-faq-area section-t-space">
        <div class="container">

            <!-- FAQ Shape Image Start-->
            <div class="faq-area-shape"></div>
            <!-- FAQ Shape Image End-->

            <div class="row align-items-center">
                <div class="col-md-6 col-lg-6 col-xl-5">

                    <div class="section-title">
                        <h3 class="section-heading">{{ __(get_option('faq_title')) }}</h3>
                        <p class="section-sub-heading">{{ __(get_option('faq_subtitle')) }}</p>
                    </div>

                    <div class="accordion" id="accordionExample">
                        @foreach($faqQuestions as $key => $faqQuestion)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_{{ $key }}">
                                    <button class="accordion-button font-medium font-18 {{ $key == 0 ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapse_{{ $key }}"
                                            aria-expanded="{{ $key == 0 ? 'true' : 'false' }}" aria-controls="collapse_{{ $key }}">
                                        {{ $key+1 }}. {{ __($faqQuestion->question) }}
                                    </button>
                                </h2>
                                <div id="collapse_{{ $key }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}" aria-labelledby="heading_{{ $key }}"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{ __($faqQuestion->answer) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-7">
                    <div class="faq-area-right position-relative">
                        <img src="{{ getImageFile(get_option('faq_image')) }}" alt="faq" class="img-fluid">
                        <div class="still-no-luck radius-3 bg-white position-absolute">
                            <h6>{{ __(get_option('faq_image_title')) }}</h6>
                            <p>{{ __('Then feel free to') }} <a href="{{ route('contact') }}"
                                                                    class="text-decoration-underline color-heading">{{ __('Contact With Us') }}</a>,
                                {{ __('We are 24/7 for you') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- FAQ Area End -->
    @endif

    
    @if($home->instructor_support_area == 1)
    <!-- Course Instructor and Support Area Start -->
    <section class="course-instructor-support-area bg-light section-t-space">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h3 class="section-heading">{{ __(@$aboutUsGeneral->instructor_support_title) }}</h3>
                        <p class="section-sub-heading">{{ __(@$aboutUsGeneral->instructor_support_subtitle) }}</p>
                    </div>
                </div>
            </div>
            <div class="row course-instructor-support-wrap">
                @foreach($instructorSupports as $instructorSupport)
                    <!-- Instructor Support Item start-->
                    <div class="col-md-4">
                        <div class="instructor-support-item bg-white radius-3 text-center">
                            <div class="instructor-support-img-wrap">
                                <img src="{{ getImageFile($instructorSupport->image_path) }}" alt="support">
                            </div>
                            <h6>{{ __($instructorSupport->title) }}</h6>
                            <p>{{ __($instructorSupport->subtitle) }} </p>
                            <a href="{{ $instructorSupport->button_link ?? '#' }}" class="theme-btn theme-button1 theme-button3">{{ __($instructorSupport->button_name) }} <i data-feather="arrow-right"></i></a>
                        </div>
                    </div>
                    <!-- Instructor Support Item End-->
                @endforeach
            </div>

            <!-- Client Logo Area start-->
            <div class="row client-logo-area">
                @foreach($clients as $client)
                    <div class="col">
                        <div class="client-logo-item text-center">
                            <img src="{{ getImageFile($client->image_path) }}" alt="{{ $client->name }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- Client Logo Area end-->
        </div>
    </section>
    <!-- Course Instructor and Support Area End -->
    @endif

    @include('frontend.home.partial.consultation-booking-schedule-modal')

    <!-- New Video Player Modal Start-->
    <div class="modal fade VideoTypeModal" id="newVideoPlayerModal" tabindex="-1" aria-labelledby="newVideoPlayerModal" aria-hidden="true">

        <div class="modal-header border-bottom-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span class="iconify" data-icon="akar-icons:cross"></span></button>
        </div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="video-player-area">
                        <!-- HTML 5 Video -->
                        <video id="player" playsinline controls data-poster="{{ getImageFile(get_option('become_instructor_video_preview_image')) }}" controlsList="nodownload">
                            <source src="{{ getVideoFile(get_option('become_instructor_video')) }}" type="video/mp4" >
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Video Player Modal End-->
@endsection

@push('style')
    <!-- Video Player css -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/vendor/video-player/plyr.css') }}">    
@endpush

@push('script')
    <!--Hero text effect-->
    <script src="{{ asset('frontend/assets/js/hero-text-effect.js') }}"></script>

    <script src="{{ asset('frontend/assets/js/course/addToCart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/course/addToWishlist.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom/booking.js') }}"></script>
    <script src="{{ asset('frontend-theme-3/assets/js/swiper.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom/calendar-events.js') }}"></script>

    <!-- Video Player js -->
    <script src="{{ asset('frontend/assets/vendor/video-player/plyr.js') }}"></script>
    <script>
        const zai_player = new Plyr('#player');
    </script>
    <!-- Video Player js -->

    <script>
        var swiper_testimonial = new Swiper('.swiper-testimonial', {
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true, // Hace que los bullets sean clicables
            },
            breakpoints: {
                // Cuando la pantalla es de 768px o menor (pantallas pequeñas)
                768: {
                    slidesPerView: 1,
                },
                // Cuando la pantalla es de 1024px o mayor (pantallas medianas y grandes)
                1024: {
                    slidesPerView: 3,
                    centeredSlides: true,
                    spaceBetween: 30,
                }
            }
        });

        var swiper_hero_primary = new Swiper(".swiper-hero-primary", {
            spaceBetween: 8,
            slidesPerView: 3,
            freeMode: true,
            loop: true,
            watchSlidesProgress: true,
            breakpoints: {
                // when window width is >= 320px
                570: {
                    spaceBetween: 25
                }
            }
        });
        
        var swiper_hero_secundary = new Swiper(".swiper-hero-secundary", {
            //swiper grande
            spaceBetween: 0,
            initialSlide: 3,
            loop: true,
            allowTouchMove: false
        });

        $('#hero-button-next').on('click', function() {
            swiper_hero_primary.slideNext();
            swiper_hero_secundary.slideNext();
        });
    </script>
@endpush
