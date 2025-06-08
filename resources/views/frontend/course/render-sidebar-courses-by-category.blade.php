<div class="col-md-4 col-lg-3 col-xl-3 coursesLeftSidebar">
    <div class="courses-sidebar-area">
        <div class="accordion" id="accordionPanelsStayOpenExample">
            <!-- <div class="d-inline-flex align-items-center my-3">
                <div id="filter" class="actions-filter cursor sidebar-filter-btn color-gray d-flex align-items-center me-2">
                    <img src="{{ asset('frontend/assets/img/courses-img/filter-icon.png') }}" alt="short" class="me-2">
                    {{ __('Filter') }}
                </div>
            </div> -->
            <div class="accordion-item course-sidebar-accordion-item">
                <h2 class="accordion-header course-sidebar-title" id="panelsStayOpen-headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                        {{ __('Categories') }}
                    </button>
                </h2>
                <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                    <div class="accordion-body">
                        <div class="accordion inner-accordion" id="accordionExample2">
                            @foreach($categories as $key => $category)
                                <div class="accordion-item sidebar-inner-accordion-item">
                                    <h6 class="accordion-header sidebar-inner-title" id="innerheading{{ $key }}">
                                        <div class="d-flex align-items-center" style="background-color: var(--page-bg); justify-content: space-between;">
                                            <a href="{{ route('category-courses', $category->slug) }}" class="text-decoration-none text-dark" style="font-size: 14px; padding: 0.25rem 1.25rem 0.25rem 0;">
                                                {{ $category->name }}
                                            </a>
                                            <button class="accordion-button collapsed" style="width: auto;" type="button" data-bs-toggle="collapse" data-bs-target="#innercollapse{{ $key }}" aria-expanded="false" aria-controls="innercollapse{{ $key }}">
                                            </button>
                                        </div>
                                    </h6>


                                    <div id="innercollapse{{ $key }}" class="accordion-collapse collapse" aria-labelledby="innerheading{{ $key }}" data-bs-parent="#accordionExample2">
                                        <div class="accordion-body inner-accordion-body">

                                            @forelse($category->courses as $courseKey => $courseItem)
                                                <div class="sidebar-radio-item">
                                                    <div class="radio-right-text">
                                                        <a href="{{ route('course-details', @$courseItem->slug) }}">
                                                            - {{ $courseItem->title }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="row">
                                                    <small>No hay cursos en esta categoría</small>
                                                </div>
                                            @endforelse

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
