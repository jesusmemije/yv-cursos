@php $card_count = 0 @endphp
@forelse($courses as $course)
    @if ($card_count % 4 == 0)
        <div class="row courses-grids mb-md-4 mb-3" id="appendCourseList">
    @endif
        <!-- Course item start -->
        @php $userRelation = getUserRoleRelation($course->user) @endphp
        <div class="col-md-3 col-12">@include('frontend.partials.course')</div>
        @php $card_count++ @endphp
    @if ($card_count % 4 == 0)
        </div>
    @endif
    <!-- Course item end -->
@empty
    <div class="row courses-grids mb-md-4 mb-3">
        <div class="no-course-found text-center">
            <img src="{{ asset('frontend/assets/img/empty-data-img.png') }}" alt="img" class="img-fluid">
            <h5 class="mt-3">{{ __('Courses Not Found') }}</h5>
        </div>
    </div>
@endforelse

<!-- Course item end -->
<!-- Pagination End -->

<!-- Pagination Start -->
<div class="col-12">
    @if ($courses->hasPages())
        <!-- Load More Button-->
        <div class="d-block">
            <button id="loadMoreBtn" type="button" class="theme-btn theme-button2 load-more-btn">{{ __('Load More') }}<span class="iconify" data-icon="icon-park-outline:loading-one"></span></button>
        </div>
    @endif
</div>
