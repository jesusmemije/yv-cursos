@extends('frontend.layouts.app')

@push('style')
<link rel="stylesheet" href="{{asset('frontend/assets/fonts/eyesome/eyesome.css')}}">
<link rel="stylesheet" href="{{ asset('frontend/assets/css/new-design/calendar.css') }}">
@endpush

@section('meta')
    @php
        $metaData = getMeta('event');
    @endphp

    <meta name="description" content="{{ __($metaData['meta_description']) }}">
    <meta name="keywords" content="{{ __($metaData['meta_keyword']) }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Event">
    <meta property="og:title" content="{{ __($metaData['meta_title']) }}">
    <meta property="og:description" content="{{ __($metaData['meta_description']) }}">
    <meta property="og:image" content="{{ __($metaData['og_image']) }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ __(get_option('app_name')) }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Event">
    <meta name="twitter:title" content="{{ __($metaData['meta_title']) }}">
    <meta name="twitter:description" content="{{ __($metaData['meta_description']) }}">
    <meta name="twitter:image" content="{{ __($metaData['og_image']) }}">
@endsection

@section('content')
<div class="bg-page-light">
    <section class="event-page-area section-t-space">
        <div class="row mx-0">
            <div class="col-12 col-md-7 mt-50">
                <div class="section-title mt-5 mt-md-0">
                    <h2 class="section-heading-brushed brushed eyesome-font events-banner-title">Eventos</h2>
                </div>
                <p class="events-banner-text mt-3 mt-md-5 font-kollektif font-italic">Te invito a conocer los próximos cursos!</p>
                <div class="ms-md-5">
                    <div id="calendarContainer">
                        @include('frontend.partials.calendar-events')
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-none d-sm-block">
                <img src="{{ asset('frontend/assets/img/events-img/yv-eventos.png') }}" alt="foto-yessica" class="img-fluid">
            </div>
        </div>
        <div class="container">
            <div class="row mt-md-5 mt-3">
                <div class="col-12 col-md-6">
                    <span class="events-next-courses font-montserrat curve-next-courses pb-5">PRÓXIMOS CURSOS!</span>
                    <p class="events-notifications font-CerebriSans font-italic">
                        LOS RECÍBE NOTIFICACIÓN SOBRE LOS
                        CURSOS Y EVENTOS DE CADA MES!
                    </p>
                </div>
                <div class="col-12 col-md-6 mt-3 mt-md-0">
                    <div class="bg-form-aqua">
                        <form id="coursesForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="NOMBRE" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <input type="tel" class="form-control" name="phone" maxlength="10" minlength="10" pattern="[0-9]{10}" placeholder="TELÉFONO" inputmode="numeric" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="CORREO" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-end">
                                    <button class="theme-button1 mt-3" type="submit">Suscribirse</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row mt-5 font-CerebriSans">
                @foreach ($nextCourses as $index => $course)
                <div class="col-12 col-md-4 mb-5 mb-md-0">
                    <a href="{{ route('event-details', $course->slug) }}" class="text-inherit">
                        <img src="{{ asset('frontend/assets/img/events-img/slider-1.jpg') }}" class="img-fluid rounded" />
                        <div class="card-course mt-4 card-event-color-{{ $index % 5 }}" > 
                            <div class="card-course-body mb-1"><span class="sf-fw-200 text-uppercase">{{ $course->title }}</span> {{-- <span class="ms-3"><strong>4.5</strong></span> --}}</div>
                            <div class="card-course-body font-medium"><span class="text-uppercase">{{ $course->start->format('d F Y') }}</span>{{-- <span>$110.64 dlls</span> --}}</div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

<input type="hidden" class="routeSubscribeCourses" value="{{ route('subscribe.courses') }}">

@endsection

@push('script')
<script src="{{ asset('frontend/assets/js/custom/search-event-list.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom/calendar-events.js') }}"></script>
<script src="{{ asset('frontend/assets/js/custom/newsletter-suscription.js') }}"></script>
@endpush
