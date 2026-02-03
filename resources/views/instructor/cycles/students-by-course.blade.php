{{-- filepath: resources/views/instructor/cycles/students-by-course.blade.php --}}
@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15">Alumnos Inscritos</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.cycles.index') }}">Ciclos</a></li>
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}">{{ $cycle->name }}</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">Alumnos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
            <div>
                <h6 class="mb-1">{{ Str::limit($course->title, 50) }}</h6>
                <small class="text-muted">Ciclo: {{ $cycle->name }}</small>
            </div>
            <a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-lg-8">
                <div class="bg-white p-3 rounded shadow-sm">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <div class="fw-semibold">
                            <i class="fa fa-users text-primary me-1"></i>
                            {{ $studentsData->count() }} alumno(s) inscritos en este diplomado
                        </div>
                        <div class="text-muted small">
                            <i class="fa fa-calendar-alt me-1"></i>
                            {{ \Carbon\Carbon::parse($cycle->start_date)->translatedFormat('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($cycle->end_date)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="bg-white p-3 rounded shadow-sm text-lg-end">
                    @if($finalProject && $finalProject->isRegistered())
                        <span class="badge bg-success">
                            <i class="fa fa-check-circle"></i> Trabajo final disponible
                        </span>
                    @else
                        <span class="badge bg-warning text-dark">
                            <i class="fa fa-exclamation-circle"></i> Trabajo final no disponible
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nombre del Alumno</th>
                                    <th>Email</th>
                                    <th>Fecha de Compra</th>
                                    <th class="text-center" style="min-width: 200px;">Progreso</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center" style="min-width: 200px;">Trabajo Final</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentsData as $data)
                                    @php
                                        $submission = $data['submission'];
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong>{{ $data['student']->name }}</strong>
                                        </td>
                                        <td>
                                            <small>{{ $data['student']->email }}</small>
                                        </td>
                                        <td>
                                            @if($data['purchase_date'])
                                                <small>{{ $data['purchase_date']->format('d/m/Y') }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar
                                                    @if($data['progress'] == 100) bg-success
                                                    @elseif($data['progress'] >= 75) bg-info
                                                    @elseif($data['progress'] >= 50) bg-warning
                                                    @else bg-danger
                                                    @endif"
                                                    role="progressbar"
                                                    style="width: {{ $data['progress'] }}%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">
                                                    {{ number_format($data['progress'], 1) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($data['progress'] == 100)
                                                <span class="badge bg-success">Completado</span>
                                            @elseif($data['progress'] >= 75)
                                                <span class="badge bg-info">En Progreso</span>
                                            @elseif($data['progress'] > 0)
                                                <span class="badge bg-warning">Iniciado</span>
                                            @else
                                                <span class="badge bg-secondary">No Iniciado</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(!$data['final_project_available'])
                                                <span class="badge bg-secondary">No disponible</span>
                                            @elseif(!$submission)
                                                <span class="badge bg-warning text-dark">No enviado</span>
                                            @else
                                                <div class="d-flex flex-column gap-1 align-items-center">
                                                    <span class="badge bg-success">
                                                        {{ $submission->status_name }}
                                                    </span>
                                                    <a href="{{ route('instructor.cycles.finalProject.download', [$cycle->uuid, $course->id, $submission->id]) }}"
                                                       class="btn btn-sm btn-outline-primary">
                                                        <i class="fa fa-download"></i> Descargar
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            No hay estudiantes inscritos en este curso
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
