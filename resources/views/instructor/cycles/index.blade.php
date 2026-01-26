{{-- filepath: resources/views/instructor/cycles/index.blade.php --}}
@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15">Mis Ciclos Escolares</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">Ciclos Escolares</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
            <h6>Ciclos Escolares Disponibles</h6>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="instructor-my-courses-box bg-white">
                    @forelse($cyclesWithStats as $item)
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-9">
                                        <h5 class="card-title mb-2 cursor-pointer" 
                                            onclick="window.location.href='{{ route('instructor.cycles.coursesByCycle', $item['cycle']->uuid) }}'">
                                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                            {{ $item['cycle']->name }}
                                        </h5>
                                        <p class="text-muted mb-2 small">
                                            <strong>Período:</strong>
                                            {{ \Carbon\Carbon::parse($item['cycle']->start_date)->translatedFormat('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item['cycle']->end_date)->translatedFormat('d M Y') }}
                                        </p>
                                        <p class="text-muted mb-0 small">
                                            <strong>Inscripciones:</strong>
                                            {{ \Carbon\Carbon::parse($item['cycle']->enrollment_start_at)->translatedFormat('d M Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item['cycle']->enrollment_end_at)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        {{-- Removido: contador de estudiantes por ciclo --}}
                                        <span class="badge bg-info me-2">
                                            <i class="fa fa-book"></i> {{ $item['related_courses'] }} curso(s)
                                        </span>
                                        <a href="{{ route('instructor.cycles.coursesByCycle', $item['cycle']->uuid) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="fa fa-arrow-right"></i> Ver Cursos
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> No tienes ciclos escolares asociados aún
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection