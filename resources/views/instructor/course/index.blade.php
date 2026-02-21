@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15"> {{__(@$title)}} </h3>

        <!-- Breadcrumb Start-->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{route('instructor.dashboard')}}">{{__('Dashboard')}}</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">{{__(@$title)}}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-box bg-white">
            <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
                <h6>{{ __(@$title) }}</h6>
                <h6 class="font-16"><span class="font-medium">Total:</span> {{$number_of_course}}</h6>
                <!-- Botón para abrir el modal de importación -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importCoursesModal">
                    {{ __('Importar Cursos') }}
                </button>
                <!-- Botón para abrir el modal de importación de lecciones y conferencias -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importLessonsModal">
                    {{ __('Importar Lecciones') }}
                </button>
            </div>
            <div class="row">

                @forelse($courses as $course)
                    <!-- Course item start -->
                    <div class="col-12 col-sm-6 col-lg-12">
                        <div class="card course-item instructor-my-course-item bg-white">
                            <div class="course-img-wrap flex-shrink-0 overflow-hidden">
                                @if($course->private_mode)
                                <span class="course-tag badge unpublish-badge radius-3 font-14 font-medium position-absolute">{{ __('Private') }}</span>
                                @elseif($course->status == 1)
                                 <span class="course-tag badge publish-badge radius-3 font-14 font-medium position-absolute">{{ __('Published') }}</span>
                                @elseif($course->status == 2)
                                 <span class="course-tag badge publish-badge radius-3 font-14 font-medium position-absolute">{{ __('Waiting for Review') }}</span>
                                @elseif($course->status == 3)
                                <span class="course-tag badge unpublish-badge radius-3 font-14 font-medium position-absolute">{{ __('Hold') }}</span>
                                @elseif($course->status == 4)
                                <span class="course-tag badge unpublish-badge radius-3 font-14 font-medium position-absolute">{{ __('Draft') }}</span>
                                @elseif($course->status == 6)
                                <span class="course-tag badge unpublish-badge radius-3 font-14 font-medium position-absolute">{{ __('Upcoming Pending') }}</span>
                                @elseif($course->status == 7)
                                <span class="course-tag badge publish-badge radius-3 font-14 font-medium position-absolute">{{ __('Upcoming') }}</span>
                                @else
                                <span class="course-tag badge unpublish-badge radius-3 font-14 font-medium position-absolute">{{ __('Pending') }}</span>
                                @endif
                                @if($course->learner_accessibility == 'paid')
                                    <span class="course-tag badge radius-3 font-14 font-medium position-absolute bg-white color-hover">
                                        @if(get_currency_placement() == 'after')
                                            {{$course->price}} {{ get_currency_symbol() }}
                                        @else
                                            {{ get_currency_symbol() }} {{$course->price}}
                                        @endif
                                    </span>
                                @elseif($course->learner_accessibility == 'free')
                                    <span class="course-tag badge radius-3 font-14 font-medium position-absolute bg-white color-hover">
                                        {{ __("Free") }}
                                    </span>
                                @endif

                                <a href="#"><img src="{{getImageFile($course->image_path)}}" alt="course" class="img-fluid"></a>
                            </div>
                            <div class="card-body">

                                <div class="instructor-courses-info-duration-wrap">
                                    <ul class="d-flex align-items-center justify-content-between">
                                        <li class="font-medium font-12"><span class="iconify" data-icon="octicon:device-desktop-24"></span>{{ __('Video') }}<span class="instructor-courses-info-duration-wrap-text font-medium color-heading">({{ @$course->lectures->count() }})</span></li>
                                        <li class="font-medium font-12"><span class="iconify" data-icon="ant-design:clock-circle-outlined"></span>{{ __('Duración') }}<span class="instructor-courses-info-duration-wrap-text font-medium color-heading">({{ @$course->VideoDuration }})</span></li>
                                        <li class="font-medium font-12"><span class="iconify" data-icon="carbon:user-multiple"></span>{{ __('Inscritos') }}<span class="instructor-courses-info-duration-wrap-text font-medium color-heading">({{  courseStudents($course->id) }})</span></li>
                                    </ul>
                                </div>

                                <div class="instructor-my-course-item-left">
                                    <h5 class="card-title course-title"><a href="{{ route('course-details', $course->slug) }}">{{ Str::limit($course->title, 40) }}</a></h5>
                                    <div class="course-item-bottom">
                                        <div class="course-rating d-flex align-items-center">
                                            <span class="font-medium font-14">{{ number_format($course->average_rating, 1) }}</span>
                                            <ul class="rating-list d-flex align-items-center">
                                                @include('frontend.course.render-course-rating')
                                            </ul>
                                            <span class="rating-count font-14">({{ @$course->reviews->count() }})</span>
                                        </div>
                                        <div class="instructor-my-courses-btns d-inline-flex">
                                             @if (is_null($course->organization_id))
                                                <a href="{{route('instructor.course.edit', [$course->uuid])}}" class="para-color font-14 font-medium d-flex align-items-center"><span class="iconify" data-icon="bx:bx-edit"></span>{{ __('Edit') }}</a>

                                                @if($course->user_id == auth()->id())
                                                <button class="para-color font-14 font-medium d-flex align-items-center deleteItem" data-formid="delete_row_form_{{$course->uuid}}">
                                                    <span class="iconify" data-icon="ant-design:delete-outlined"></span>{{ __('Delete') }}
                                                </button>

                                                <form action="{{ route('instructor.course.delete', [$course->uuid]) }}" method="post" id="delete_row_form_{{ $course->uuid }}">
                                                    {{ method_field('DELETE') }}
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                </form>
                                                @endif
                                            @else
                                                <span class="para-color font-14 font-medium d-flex align-items-center">
                                                    @if (!is_null($course->organization))
                                                      <span>{{ __('Organization') }}</span>  : {{ $course->organization->first_name }} {{ $course->organization->last_name }}
                                                    @elseif(!is_null($course->instructor))
                                                      <span>{{ __('Instructor') }}</span>  : {{ $course->instructor->first_name }} {{ $course->instructor->last_name }}
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if (is_null($course->organization))
                                <div class="instructor-my-course-btns">
                                    <a href="{{ route('resource.index', [$course->uuid]) }}" class="theme-button theme-button1 instructor-course-btn">{{ __('Resources') }}</a>
                                    <a href="{{route('exam.index', [$course->uuid])}}" class="theme-button theme-button1 instructor-course-btn">{{ __('Quiz') }}</a>
                                    <a href="{{ route('assignment.index', [$course->uuid]) }}" class="theme-button theme-button1 instructor-course-btn">{{ __('Assignment') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Course item end -->
                @empty
                    <!-- If there is no data Show Empty Design Start -->
                    <div class="empty-data">
                        <img src="{{ asset('frontend/assets/img/empty-data-img.png') }}" alt="img" class="img-fluid">
                        <h5 class="my-3">{{ __('Empty Course') }}</h5>
                    </div>
                    <!-- If there is no data Show Empty Design End -->
                @endforelse

                <!-- Pagination Start -->
                @if(@$courses->hasPages())
                    {{ @$courses->links('frontend.paginate.paginate') }}
                @endif
                <!-- Pagination End -->

            </div>
        </div>
    </div>

    <!-- Modal para la importación de cursos -->
    <div class="modal fade" id="importCoursesModal" tabindex="-1" aria-labelledby="importCoursesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCoursesModalLabel">{{ __('Importar Cursos') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('instructor.course.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">{{ __('Selecciona el archivo CSV') }}</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Importar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para la importación de lecciones y conferencias -->
    <div class="modal fade" id="importLessonsModal" tabindex="-1" aria-labelledby="importLessonsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importLessonsModalLabel">{{ __('Importar Lecciones') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="importLessonsForm" action="{{ route('instructor.lesson.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="lessons_csv_file">{{ __('Selecciona el archivo CSV') }}</label>
                            <input type="file" class="form-control" id="lessons_csv_file" name="csv_file" required>
                        </div>
                        <div class="progress" style="display:none;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="button" class="btn btn-primary" onclick="startImport()">{{ __('Importar') }}</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function startImport() {
            // Mostrar la barra de progreso
            $('.progress').show();

            var form = $('#importLessonsForm')[0];
            var formData = new FormData(form);

            $.ajax({
                url: "{{ route('instructor.lesson.import') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log('Importación completa');
                    // Actualizar la barra de progreso o mostrar mensaje de éxito
                    $('.progress-bar').width('100%');
                    $('.progress-bar').html('100%');
                    $('.progress').hide();
                    toastr.success('Importación completa');
                },
                error: function(xhr, status, error) {
                    var errorMessage = xhr.status + ': ' + error;
                    console.log('Error - ' + errorMessage);
                    toastr.error('Ocurrió un error durante la importación');
                },
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total;
                            percentComplete = parseInt(percentComplete * 100);
                            $('.progress-bar').width(percentComplete + '%');
                            $('.progress-bar').html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
            });
        }
    </script>
@endsection

