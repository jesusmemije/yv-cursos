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
            <div>
                <h6 class="mb-1">Ciclos Escolares Disponibles</h6>
                <small class="text-muted">Resumen de ciclos activos para tus diplomados</small>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="instructor-my-courses-box bg-white">
                    @forelse($cyclesWithStats as $item)
                        <div class="card mb-3 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-3">
                                    <div class="flex-grow-1">
                                        <h5 class="card-title mb-2 cursor-pointer"
                                            onclick="window.location.href='{{ route('instructor.cycles.coursesByCycle', $item['cycle']->uuid) }}'">
                                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                            {{ $item['cycle']->name }}
                                        </h5>
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="small text-muted">
                                                <strong>Período:</strong>
                                                {{ \Carbon\Carbon::parse($item['cycle']->start_date)->translatedFormat('d M Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($item['cycle']->end_date)->translatedFormat('d M Y') }}
                                            </div>
                                            <div class="small text-muted">
                                                <strong>Inscripciones:</strong>
                                                {{ \Carbon\Carbon::parse($item['cycle']->enrollment_start_at)->translatedFormat('d M Y') }}
                                                -
                                                {{ \Carbon\Carbon::parse($item['cycle']->enrollment_end_at)->translatedFormat('d M Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <div class="d-flex flex-wrap justify-content-end gap-2 mb-2">
                                            <span class="badge bg-light text-primary border">
                                                <i class="fa fa-users me-1"></i> {{ $item['total_students'] }} alumno(s)
                                            </span>
                                            <span class="badge bg-light text-info border">
                                                <i class="fa fa-book me-1"></i> {{ $item['related_courses'] }} diplomado(s)
                                            </span>
                                        </div>
                                        <a href="{{ route('instructor.cycles.coursesByCycle', $item['cycle']->uuid) }}"
                                           class="btn btn-sm btn-primary">
                                            <i class="fa fa-arrow-right"></i> Ver Diplomados
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> No tienes ciclos escolares asociados aún.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
