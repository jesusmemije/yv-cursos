{{-- filepath: resources/views/instructor/cycles/courses-by-cycle.blade.php --}}
@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15">Cursos del Ciclo Escolar</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.cycles.index') }}">Ciclos Escolares</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">{{ $cycle->name }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
            <div>
                <h6>{{ $cycle->name }}</h6>
                <small class="text-muted">
                    {{ \Carbon\Carbon::parse($cycle->start_date)->translatedFormat('d M Y') }} 
                    - 
                    {{ \Carbon\Carbon::parse($cycle->end_date)->translatedFormat('d M Y') }}
                </small>
            </div>
            <a href="{{ route('instructor.cycles.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="instructor-my-courses-box bg-white">
                    @forelse($coursesWithFinalProject as $item)
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <img src="{{ getImageFile($item['course']->image_path) }}" 
                                             alt="{{ $item['course']->title }}"
                                             class="img-fluid rounded" style="height: 100px; object-fit: cover;">
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="card-title mb-2">{{ Str::limit($item['course']->title, 50) }}</h6>
                                        <p class="text-muted small mb-2">
                                            <strong>Instructor:</strong> {{ $item['course']->user->name }}
                                        </p>
                                        {{-- CORREGIDO: Mostrar solo alumnos que compraron ESTE curso --}}
                                        <p class="text-muted small mb-0">
                                            <strong>Alumnos inscritos:</strong> 
                                            <span class="badge bg-primary">{{ $item['student_count'] }}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        {{-- Indicador de Trabajo Final --}}
                                        @if($item['is_registered'])
                                            <span class="badge bg-success mb-2">
                                                <i class="fa fa-check-circle"></i> Trabajo Final Registrado
                                            </span>
                                        @elseif($item['has_final_project'])
                                            <span class="badge bg-warning mb-2">
                                                <i class="fa fa-exclamation-circle"></i> Pendiente Registrar
                                            </span>
                                        @else
                                            <span class="badge bg-secondary mb-2">
                                                <i class="fa fa-plus-circle"></i> No Existe
                                            </span>
                                        @endif

                                        {{-- Botones de Acción --}}
                                        <div class="btn-group btn-group-sm w-100">
                                            <a href="{{ route('instructor.cycles.studentsByCourse', [$cycle->uuid, $item['course']->id]) }}"
                                               class="btn btn-info" title="Ver Alumnos">
                                                <i class="fa fa-users"></i> Alumnos
                                            </a>
                                            <a href="{{ route('instructor.cycles.registerFinalProject', [$cycle->uuid, $item['course']->id]) }}"
                                               class="btn btn-primary" title="Trabajo Final">
                                                <i class="fa fa-file-alt"></i> Trabajo Final
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> No hay cursos para este ciclo escolar
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection