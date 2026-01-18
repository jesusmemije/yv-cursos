@extends('layouts.admin')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>Grupos</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.group.index') }}">Listado de grupos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Asignar Cursos</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between align-items-center">
                            <div>
                                <h2>Asignar Diplomados al Grupo</h2>
                                <p class="text-muted mt-2">
                                    <strong>Grupo:</strong> {{ $group->name }}<br>
                                    <strong>Ciclo:</strong> 
                                    {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d \d\e F \d\e Y') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d \d\e F \d\e Y') }}<br>
                                    <strong>Inscripciones:</strong> 
                                    {{ \Carbon\Carbon::parse($group->enrollment_start_at)->translatedFormat('d \d\e F \d\e Y') }} 
                                    - 
                                    {{ \Carbon\Carbon::parse($group->enrollment_end_at)->translatedFormat('d \d\e F \d\e Y') }}
                                </p>
                            </div>
                            <a href="{{ route('admin.group.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>

                        <!-- Información -->
                        <div class="alert alert-info mb-4" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Selecciona los diplomados que estarán disponibles para este grupo. Los estudiantes que compren alguno de estos diplomados y seleccionen este grupo serán inscritos automáticamente.
                        </div>

                        <!-- Diplomados Disponibles -->
                        <div class="instructor-panel-bundles-courses-page create-bundles-courses-page bg-white">
                            <label class="label-text-title color-heading font-medium font-16 mb-4">
                                Diplomados Disponibles
                            </label>

                            <div class="row create-bundles-courses-item-wrap" id="coursesContainer">
                                @forelse($courses as $course)
                                    <!-- Course item start -->
                                    <div class="col-12 col-sm-6 col-lg-4 mb-4">
                                        <div class="card course-item instructor-my-course-item create-bundles-course-item bg-white h-100 shadow-sm {{ in_array($course->id, $alreadyAddedCourseIds) ? 'selected' : '' }}" data-course-id="{{ $course->id }}">
                                            <!-- Imagen del Curso -->
                                            <div class="course-img-wrap flex-shrink-0 overflow-hidden position-relative" style="height: 180px;">
                                                <span class="course-tag badge radius-3 font-14 font-medium position-absolute bg-white color-hover" style="top: 10px; right: 10px; z-index: 10;">
                                                    @if(get_currency_placement() == 'after')
                                                        {{ $course->price }} {{ get_currency_symbol() }}
                                                    @else
                                                        {{ get_currency_symbol() }} {{ $course->price }}
                                                    @endif
                                                </span>
                                                <a href="#">
                                                    <img src="{{ getImageFile($course->image_path) }}" alt="{{ $course->title }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                                </a>
                                            </div>

                                            <!-- Información del Curso -->
                                            <div class="card-body d-flex flex-column">
                                                <!-- Estadísticas -->
                                                <div class="instructor-courses-info-duration-wrap mb-3">
                                                    <ul class="d-flex align-items-center justify-content-between list-unstyled">
                                                        <li class="font-medium font-12">
                                                            <span class="iconify" data-icon="octicon:device-desktop-24"></span>
                                                            <span>{{ @$course->lectures->count() }} videos</span>
                                                        </li>
                                                        <li class="font-medium font-12">
                                                            <span class="iconify" data-icon="ant-design:clock-circle-outlined"></span>
                                                            <span>{{ @$course->VideoDuration }}</span>
                                                        </li>
                                                        <li class="font-medium font-12">
                                                            <span class="iconify" data-icon="carbon:user-multiple"></span>
                                                            <span>{{ @$course->orderItems->count() }} inscritos</span>
                                                        </li>
                                                    </ul>
                                                </div>

                                                <!-- Título y Rating -->
                                                <div class="flex-grow-1">
                                                    <h5 class="card-title course-title font-weight-bold mb-2">
                                                        <a href="{{ route('course-details', $course->slug) }}" target="_blank" class="text-dark">
                                                            {{ Str::limit($course->title, 50) }}
                                                        </a>
                                                    </h5>
                                                    
                                                    <div class="course-item-bottom mb-3">
                                                        <div class="course-rating d-flex align-items-center">
                                                            <span class="font-medium font-14 text-warning">{{ number_format($course->average_rating, 1) }}</span>
                                                            <ul class="rating-list d-flex align-items-center ms-2">
                                                                @include('frontend.course.render-course-rating')
                                                            </ul>
                                                            <span class="rating-count font-12 ms-2">({{ @$course->reviews->count() }})</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Instructor -->
                                                <div class="instructor-info border-top pt-2 mb-3">
                                                    <small class="text-muted">
                                                        <strong>Instructor:</strong> {{ @$course->user->name ?? 'N/A' }}
                                                    </small>
                                                </div>

                                                <!-- Checkbox -->
                                                <div class="form-check mt-auto pt-2 border-top">
                                                    <input 
                                                        class="form-check-input course-checkbox" 
                                                        type="checkbox" 
                                                        id="course_{{ $course->id }}" 
                                                        data-course_id="{{ $course->id }}"
                                                        @if(in_array($course->id, $alreadyAddedCourseIds)) checked @endif
                                                        style="width: 20px; height: 20px; cursor: pointer;">
                                                    <label class="form-check-label ms-2 cursor-pointer" for="course_{{ $course->id }}" style="cursor: pointer;">
                                                        Incluir en el grupo
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Course item end -->
                                @empty
                                    <div class="col-12">
                                        <!-- Empty State -->
                                        <div class="empty-data text-center py-5">
                                            <img src="{{ asset('frontend/assets/img/empty-data-img.png') }}" alt="Sin diplomados" class="img-fluid mb-3" style="max-width: 200px;">
                                            <h5 class="my-3 text-muted">No hay diplomados disponibles</h5>
                                            <p class="text-muted">Por favor, crea diplomados antes de asignarlos a un grupo.</p>
                                        </div>
                                    </div>
                                @endforelse

                                <!-- Pagination -->
                                @if(@$courses->hasPages())
                                    <div class="col-12 mt-4">
                                        {{ @$courses->links('pagination::bootstrap-4') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row mt-5 pt-4 border-top">
                            <div class="col-md-12 text-end">
                                <button class="btn btn-primary btn-lg" id="submitBtn" type="button" onclick="submitForm()">
                                    <i class="fa fa-check"></i> Finalizar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <input type="hidden" class="addGroupCourseRoute" value="{{ route('admin.group.addCourse') }}">
    <input type="hidden" class="removeGroupCourseRoute" value="{{ route('admin.group.removeCourse') }}">
    <input type="hidden" class="group_id" value="{{ $group->id }}">

@endsection

@push('style')
    <style>
        .course-item {
            transition: all 0.3s ease;
            border: 2px solid #e0e0e0;
        }
        
        .course-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1) !important;
        }

        /* Clase para items seleccionados */
        .course-item.selected {
            border: 2px solid #28a745 !important;
            background-color: #f8fff9;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        .form-check-input:checked::after {
            content: '';
        }

        .course-checkbox {
            cursor: pointer;
        }

        .label-inline {
            cursor: pointer;
        }

        .empty-data {
            padding: 40px 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
    </style>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            const addRoute = $('.addGroupCourseRoute').val();
            const removeRoute = $('.removeGroupCourseRoute').val();
            const groupId = $('.group_id').val();

            // Manejar selección/deselección de cursos
            $(document).on('change', '.course-checkbox', function() {
                const courseId = $(this).data('course_id');
                const isChecked = $(this).is(':checked');
                const $card = $(this).closest('.card');

                if (isChecked) {
                    addCourseToGroup(courseId, $card);
                } else {
                    removeCourseFromGroup(courseId, $card);
                }
            });

            function addCourseToGroup(courseId, $card) {
                $.ajax({
                    url: addRoute,
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'group_id': groupId,
                        'course_id': courseId
                    },
                    success: function(response) {
                        $card.addClass('selected');
                        toastr.success('Diplomado añadido al grupo');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        toastr.error('Error al añadir el diplomado');
                        $(`.course-checkbox[data-course_id="${courseId}"]`).prop('checked', false);
                    }
                });
            }

            function removeCourseFromGroup(courseId, $card) {
                $.ajax({
                    url: removeRoute,
                    type: 'DELETE',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        'group_id': groupId,
                        'course_id': courseId
                    },
                    success: function(response) {
                        $card.removeClass('selected');
                        toastr.success('Diplomado removido del grupo');
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        toastr.error('Error al remover el diplomado');
                        $(`.course-checkbox[data-course_id="${courseId}"]`).prop('checked', true);
                    }
                });
            }

        });

        function submitForm() {
            const selectedCount = $('.course-checkbox:checked').length;

            if (selectedCount === 0) {
                toastr.warning('Por favor, selecciona al menos un diplomado');
                return;
            }
            
            Swal.fire({
                title: '¿Confirmar?',
                text: `Se guardarán ${selectedCount} diplomado(s) para este grupo`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                window.location.href = "{{ route('admin.group.index') }}";
            });
        }
    </script>
@endpush