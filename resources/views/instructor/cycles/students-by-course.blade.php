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
                <h6>{{ Str::limit($course->title, 50) }}</h6>
                <small class="text-muted">Ciclo: {{ $cycle->name }}</small>
            </div>
            <a href="{{ route('instructor.cycles.coursesByCycle', $cycle->uuid) }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Volver
            </a>
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
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($studentsData as $data)
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
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
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