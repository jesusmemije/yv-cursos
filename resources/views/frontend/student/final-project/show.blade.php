{{-- filepath: resources/views/frontend/student/final-project/show.blade.php --}}
@extends('frontend.layouts.app')

@section('content')
    <div class="bg-page">
        <header class="page-banner-header blank-page-banner-header gradient-bg position-relative">
            <div class="section-overlay">
                <div class="blank-page-banner-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-banner-content text-center">
                                    <h3 class="page-banner-heading color-heading pb-15">{{ __('Trabajo Final') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <section class="course-single-details-area before-login-purchase-course-details">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
    
                        @if($submission && $submission->status == 'submitted')
                            <div class="alert alert-info" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Nota:</strong> Tu trabajo final ya fue enviado por correo electrónico a tu instructor <strong>{{ $finalProject->instructor->name }}</strong> y no puede ser editado ni reenviado.
                                <br>
                                El seguimiento y la retroalimentación se realizarán por medio de correo electrónico.
                            </div>

                        @else
                            <div class="alert alert-success" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <strong>¡Excelente!</strong> Has completado el 100% del curso. Ahora puedes enviar tu trabajo final.
                            </div>
                        @endif

                        {{-- Información del trabajo final --}}
                        <div class="course-details-content bg-white p-4 radius-8 mb-4">
                            <h4 class="mb-3">{{ $finalProject->title }}</h4>
                            <div class="alert alert-light border mb-3">
                                <p>{{ nl2br($finalProject->description) }}</p>
                            </div>
                        </div>

                        {{-- Mostrar advertencia y resumen si ya enviado --}}
                        @if($submission && $submission->status == 'submitted')
                            <div class="course-details-content bg-white p-4 radius-8 mb-4">
                                <h5>Resumen del envío</h5>
                                <p class="mt-3"><strong>Título:</strong> {{ $submission->title }}</p>
                                <p class="mt-2"><strong>Descripción:</strong> {{ Str::limit($submission->description, 300) }}</p>
                                @if($submission->file_path)
                                    <a href="{{ route('student.final-project.download', $submission->id) }}" class="btn btn-sm btn-primary mt-2">
                                        <i class="fa fa-download me-1"></i> Descargar archivo
                                    </a>
                                @endif
                            </div>
                        @else
                            {{-- Formulario activo: mantén solo mínimo lógico, confirm dialog JS --}}
                            <div class="course-details-content bg-white p-4 radius-8">
                                <h5 class="mb-4">Enviar Tu Trabajo Final</h5>

                                <div class="alert alert-info" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Nota:</strong> Tu trabajo será enviado directamente al instructor <strong>{{ $finalProject->instructor->name }}</strong> por correo electrónico con todos los detalles.
                                </div>

                                <form id="finalProjectForm" action="{{ route('student.final-project.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="final_project_id" value="{{ $finalProject->id }}">
                                    <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="title" class="form-label font-weight-bold">
                                                Título de Tu Trabajo <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="title" 
                                                   id="title" 
                                                   class="form-control @error('title') is-invalid @enderror"
                                                   value="{{ old('title', @$submission->title) }}"
                                                   placeholder="Título descriptivo de tu trabajo"
                                                   required>
                                            @error('title')
                                                <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="description" class="form-label font-weight-bold">
                                                Descripción / Resumen <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="description" 
                                                      id="description" 
                                                      class="form-control @error('description') is-invalid @enderror"
                                                      rows="6"
                                                      placeholder="Describe brevemente tu trabajo, enfocándote en los puntos clave y resultados"
                                                      required>{{ old('description', @$submission->description) }}</textarea>
                                            @error('description')
                                                <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="file" class="form-label font-weight-bold">
                                                Archivo del Trabajo <span class="text-danger">*</span>
                                            </label>
                                            <input type="file" 
                                                   name="file" 
                                                   id="file" 
                                                   class="form-control @error('file') is-invalid @enderror"
                                                   accept=".pdf,.doc,.docx"
                                                   required>
                                            <small class="form-text text-muted">
                                                Formatos aceptados: PDF, Word (.docx, .doc) | Tamaño máximo: 10MB
                                            </small>
                                            @error('file')
                                                <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button id="submitFinalProjectBtn" type="submit" class="btn btn-lg btn-danger">
                                                <i class="fa fa-paper-plane me-2"></i> Enviar Trabajo Final
                                            </button>
                                            <a href="javascript:history.back()" class="btn btn-lg btn-outline-secondary ms-2">
                                                Cancelar
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-4">
                        <div class="course-details-sidebar">
                            {{-- Información del Curso --}}
                            <div class="course-details-box bg-white p-4 radius-8 mb-4">
                                <h6 class="mb-3">Información del Curso</h6>
                                <ul class="course-info-list">
                                    <li>
                                        <strong>Diplomado:</strong> 
                                        <span>{{ Str::limit($enrollment->course->title, 30) }}</span>
                                    </li>
                                    <li>
                                        <strong>Instructor:</strong> 
                                        <span>{{ $enrollment->course->user->name }}</span>
                                    </li>
                                    <li class="mt-3">
                                        <strong>Progreso:</strong>
                                        <div class="progress mt-2" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%;">
                                                {{ number_format($progress, 1) }}%
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            {{-- Estado del Envío --}}
                            @if($submission)
                                <div class="course-details-box bg-white p-4 radius-8">
                                    <h6 class="mb-3">Tu Envío</h6>
                                    <ul class="course-info-list">
                                        <li>
                                            <strong>Estado:</strong>
                                            <span class="badge 
                                                @if($submission->status == 'submitted') bg-success 
                                                @elseif($submission->status == 'reviewed') bg-info 
                                                @else bg-warning 
                                                @endif">
                                                {{ ucfirst(__($submission->status_name)) }}
                                            </span>
                                        </li>
                                        <li>
                                            <strong>Fecha de Envío:</strong> 
                                            <span>{{ $submission->submitted_at ? $submission->submitted_at->format('d/m/Y H:i') : 'Pendiente' }}</span>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('finalProjectForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Confirmar envío',
                    text: 'Una vez enviado, tu trabajo final NO podrá editarse ni reenviarse. ¿Deseas continuar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.value) {
                        form.submit();
                    }
                });
            });
        }
    });
</script>
@endpush