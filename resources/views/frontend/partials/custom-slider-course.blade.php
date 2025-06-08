<div class="card custom-course-item mx-2 {{ $course->status != STATUS_UPCOMING_APPROVED ? '' : 'course-item-upcoming' }} border-0 bg-white">
    <div class="course-img-wrap overflow-hidden">
        <img src="{{ getImageFile($course->image_path) }}" alt="course" class="img-fluid">
        <div class="course-item-hover-btns position-absolute">
            <span class="course-item-btn addToWishlist" data-course_id="{{ $course->id }}" data-route="{{ route('student.addToWishlist') }}" title="Add to Wishlist">
                <i data-feather="heart"></i>
            </span>
            @if ($course->status != STATUS_UPCOMING_APPROVED)
                <span class="course-item-btn addToCart" data-course_id="{{ $course->id }}" data-route="{{ route('student.addToCart') }}" title="Add to Cart">
                    <i data-feather="shopping-bag"></i>
                </span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <h5 class="card-title custom-course-title font-semi-bold mb-0">CURSO</h5>
        <h5 class="card-title custom-course-title">{{ Str::limit($course->title, 30) }}</h5>

        <div class="course-item-bottom">
            <div class="instructor-bottom-item">
                {{ Str::limit($course->description, 72) }}
            </div>
            <div class="hero-btns text-center">
                <a href="{{ route('course-details', $course->slug) }}"
                    class="theme-button-darker theme-btn circle-icon">
                    {{ __('Ver más') }} <i data-feather="chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
