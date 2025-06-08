@extends('frontend.layouts.app')
@push('script')
<script src="https://www.google.com/recaptcha/api.js?render={{ get_option('recaptcha_site_key', "") }}"></script>
@endpush
@push('style')
<link rel="stylesheet" href="{{asset('frontend/assets/fonts/eyesome/eyesome.css')}}">
@endpush
@section('meta')
    @php
        $metaData = getMeta('contact_us');
    @endphp

    <meta name="description" content="{{ $metaData['meta_description'] }}">
    <meta name="keywords" content="{{ $metaData['meta_keyword'] }}">

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="Learning">
    <meta property="og:title" content="{{ $metaData['meta_title'] }}">
    <meta property="og:description" content="{{ $metaData['meta_description'] }}">
    <meta property="og:image" content="{{ $metaData['og_image'] }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:site_name" content="{{ get_option('app_name') }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="Learning">
    <meta name="twitter:title" content="{{ $metaData['meta_title'] }}">
    <meta name="twitter:description" content="{{ $metaData['meta_description'] }}">
    <meta name="twitter:image" content="{{ $metaData['og_image'] }}">
@endsection
@section('content')
<div class="">
    <!-- Contact Page Area Start -->
    <section class="contact-page-area bg-page-custom section-t-space">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12 mt-50">
                    <div class="section-title text-center mt-0 mt-md-5">
                        <h2 class="section-heading-brushed brushed eyesome-font">Contáctame!</h2>
                    </div>
                    <p class="contact-banner-text mt-5">
                        Si te gustaría platicar conmigo para <span class="font-bold">CONFERENCIAS,
                        PUBLICIDAD o COLABORACIONES;</span> Con gusto
                        podemos platicar para trabajar junt@s!
                    </p>
                    <p class="contact-banner-text mt-5">
                        Si tienes una <span class="font-bold">duda</span>, un <span class="font-bold">evento</span> o una <span class="font-bold">consulta</span>, te
                        agradecería que me mandaras un mensaje en el
                        formulario.
                    </p>
                    <p class="contact-banner-text mt-5"><span class="font-bold">GRACIAS</span> por tu confianza! Nos vemos pronto!
                    </p>
                </div>
                <div class="col-12 col-md-5">
                    <div class="img-container">
                        <!-- fit image in col-4 -->
                        <img src="{{ asset('frontend/assets/img/courses-img/yessica-villa.png') }}" alt="foto-yessica" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section style="background-color: rgba(255, 253, 249, 1)">
        <div class="container font-kollektif">
            <div class="row">
                <!-- Contact page right side start-->
                <div class="col-md-6 custom-contact-bg py-3">
                    <form id="contact-form">
                        <div class="row">
                            <div class="col-md-12 mb-30">
                                <label for="inputName" class="contact-form-title">Nombre</label>
                                <input type="text" class="form-control contact-form-input" id="inputName">
                            </div>
                            <div class="col-md-6 mb-30">
                                <label for="inputEmail" class="contact-form-title">Email</label>
                                <input type="email" class="form-control contact-form-input" id="inputEmail">
                            </div>
                            <div class="col-md-6 mb-30">
                                <label for="inputPhone" class="contact-form-title">Teléfono</label>
                                <input type="tel" class="form-control contact-form-input" id="inputPhone">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-30">
                                <label for="exampleFormControlTextarea1" class="contact-form-title">Mensaje</label>
                                <textarea class="form-control message contact-form-input" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <button type="button" class="theme-btn bg-primary-dark font-15 fw-bold submitContactUs mt-3">Enviar</button>
                            </div>
                            <div class="col-3 offset-6">
                                <img src="{{ asset('frontend/assets/img/icons-svg/contact-laptop-teaching.png') }}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Contact page right side End-->

                <!-- Contact page left side start-->
                <div class="col-md-6">

                    <div class="mx-5">
                        <div class="text-center mb-4">
                            <span class="contact-title contact-title-main">CONTACTO</span>
                            <span class="contact-title contact-title-secundary curve-contact-direct pb-4 w-30 font-italic" style="width: 30%">DIRECTO</span>
                        </div>

                        <p class="mb-3">Consulta conmigo cualquier duda y con gusto responderé tus mensajes!</p>

                        <!-- Contact Info Item Start-->
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 contact-icon-img-wrap">
                                <img src="{{ asset('frontend/assets/img/icons-svg/contact-icon-4.svg') }}" width="42" height="42" alt="feature">
                            </div>
                            <div class="flex-grow-1 ms-4 contact-info-content">
                                <p>{{ __(get_option('contact_us_phone_one')) }}</p>
                                <p>{{ __(get_option('contact_us_phone_two')) }}</p>
                            </div>
                        </div>
                        <!-- Contact Info Item End-->

                        <!-- Contact Info Item Start-->
                        <div class="d-flex align-items-center mb-2">
                            <div class="flex-shrink-0 contact-icon-img-wrap">
                                <img src="{{ asset('frontend/assets/img/icons-svg/contact-icon-5.svg') }}" width="42" height="42" alt="feature">
                            </div>
                            <div class="flex-grow-1 ms-4 contact-info-content">
                                <p>{{ __(get_option('contact_us_email_one')) }}</p>
                                <p>{{ __(get_option('contact_us_email_two')) }}</p>
                            </div>
                        </div>
                        <!-- Contact Info Item End-->

                        <!-- Contact Info Item Start-->
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 contact-icon-img-wrap">
                                <img src="{{ asset('frontend/assets/img/icons-svg/contact-icon-6.svg') }}" width="42" height="42" alt="feature">
                            </div>
                            <div class="flex-grow-1 ms-4 contact-info-content">
                                <p>{{ __(get_option('contact_us_location')) }}</p>
                            </div>
                        </div>
                        <!-- Contact Info Item End-->

                        <!-- Google Map Part Start-->
                        <div class="map-container">
                            <iframe src="{{ get_option('contact_us_map_link') }}" allowfullscreen="" loading="lazy"></iframe>
                        </div>
                        <!-- Google Map Part End-->
                    </div>

                </div>
                <!-- Contact page left side End-->
            </div>
        </div>
    </section>
    <!-- Contact Page Area End -->
</div>
<input type="hidden" value="{{ route('contact.store') }}" class="contactStoreRoute">
@endsection

@push('script')
    <script src="{{ asset('frontend/assets/js/custom/contact-us-store.js') }}"></script>
@endpush
