<div class="row">
    <div class="col-12">
        <div class="section-title text-center mb-3 mt-5">
            <h2 class="section-heading-brushed brushed eyesome-font">Aprende ahora!</h2>
        </div>
    </div>
    <div class="col-md-5 d-none d-sm-block">
        <div class="img-container">
            <!-- fit image in col-4 -->
            <img src="{{ asset('frontend/assets/img/courses-img/yv-courses.png') }}" alt="foto-yessica" class="img-fluid">
        </div>
    </div>
    <div class="col-12 col-md-6 d-flex justify-content-center align-items-center flex-column font-lato">
        <div class="bg-primary-dark pill mt-4 mx-3 mx-md-0 text-center">
            CONÓCE LOS CURSOS MÁS VENDIDOS!
        </div>
        @if(count($bestsellerCourse))
        <!-- featured courses carousel -->
        <!-- <div class="slick-course-slider-items slick-slider mt-5"> -->
        <!-- Swiper Banner main -->
        <div class="swiper swiper-course-main">
            <div class="swiper-wrapper">
                @foreach ($bestsellerCourse as $course)
                @php
                    $userRelation = getUserRoleRelation($course->user);
                @endphp
                    <div class="swiper-slide">@include('frontend.partials.custom-slider-course')</div>
                @endforeach
            </div>
            <!-- Botones personalizados -->
            <div class="swiper-button-prev icon-prev-course-main">
                <img src="{{ asset('frontend/assets/img/icons-svg/arrow-prev.svg') }}" alt="Prev">
            </div>
            <div class="swiper-button-next icon-next-course-main">
                <img src="{{ asset('frontend/assets/img/icons-svg/arrow-next.svg') }}" alt="Next">
            </div>
        </div>
        @else
        {{ __("No Course Found") }}
        @endif
    </div>
</div>