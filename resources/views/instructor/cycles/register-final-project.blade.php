{{-- filepath: resources/views/instructor/cycles/register-final-project.blade.php --}}
@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15">Trabajo Final</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.cycles.index') }}">Ciclos</a></li>
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}">{{ $cycle->name }}</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">Trabajo Final</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
            <h6>Registrar Trabajo Final</h6>
            <a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="bg-white p-4 rounded shadow-sm">
                    {{-- Estado del trabajo final --}}
                    @if($existingProject && $existingProject->isRegistered())
                        <div class="alert alert-success mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Trabajo Final Ya Registrado</strong>
                            <hr>
                            <p class="mb-1"><strong>Título:</strong> {{ $existingProject->title }}</p>
                            <p class="mb-1"><strong>Registrado el:</strong> {{ $existingProject->registered_at->format('d/m/Y H:i') }}</p>
                        </div>
                    @else
                        {{-- Advertencia importante --}}
                        <div class="alert alert-danger mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Atención:</strong> Una vez registrado el trabajo final, <strong>NO podrá ser editado ni eliminado</strong>. 
                            Asegúrate de que la información sea completamente correcta antes de guardar.
                        </div>
                    @endif

                    <form action="{{ route('instructor.cycles.storeFinalProject', [$cycle->uuid, $course->id]) }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold">Ciclo Escolar</label>
                                <div class="form-control-plaintext">
                                    <strong>{{ $cycle->name }}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label font-weight-bold">Curso / Diplomado</label>
                                <div class="form-control-plaintext">
                                    <strong>{{ $course->title }}</strong>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label font-weight-bold">
                                    Título del Trabajo Final <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       name="title" 
                                       id="title" 
                                       class="form-control @error('title') is-invalid @enderror"
                                       value="{{ old('title', @$existingProject->title) }}"
                                       placeholder="Ej: Proyecto Final de Cosmiatría Clínica"
                                       {{ $existingProject && $existingProject->isRegistered() ? 'disabled' : '' }}
                                       required>
                                @error('title')
                                    <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="description" class="form-label font-weight-bold">
                                    Descripción / Instrucciones <span class="text-danger">*</span>
                                </label>
                                <textarea name="description" 
                                          id="description" 
                                          class="form-control @error('description') is-invalid @enderror"
                                          rows="8"
                                          placeholder="Describe los requisitos, objetivos, criterios de evaluación y cualquier instrucción importante para el trabajo final"
                                          {{ $existingProject && $existingProject->isRegistered() ? 'disabled' : '' }}
                                          required>{{ old('description', @$existingProject->description) }}</textarea>
                                @error('description')
                                    <span class="text-danger small"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                @if($existingProject && $existingProject->isRegistered())
                                    {{-- Si ya está registrado, no mostramos nada aquí --}}
                                @else
                                    <hr class="my-4">
                                    {{-- Si NO está registrado, mostramos ambos botones --}}
                                    <a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}" class="theme-btn theme-button3 quiz-back-btn">
                                        <i class="fa fa-times me-2"></i> Cancelar
                                    </a>
                                    <button type="submit" class="theme-btn theme-button1">
                                        <i class="fa fa-save me-2"></i> Registrar Trabajo Final
                                    </button>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection