@extends('layouts.instructor')

@section('breadcrumb')
    <div class="page-banner-content text-center">
        <h3 class="page-banner-heading text-black pb-15">Mis Grupos</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item font-14"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item font-14 active" aria-current="page">Grupos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="instructor-profile-right-part">
        <div class="instructor-my-courses-title d-flex justify-content-between align-items-center">
            <h6>Grupos Disponibles</h6>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="instructor-my-courses-box bg-white">
                    @forelse($groupsWithStats as $item)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <h5 class="card-title mb-2">{{ $item['group']->name }}</h5>
                                        <p class="text-muted mb-2">
                                            <strong>Período:</strong>
                                            {{ \Carbon\Carbon::parse($item['group']->start_date)->translatedFormat('d \d\e F \d\e Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item['group']->end_date)->translatedFormat('d \d\e F \d\e Y') }}
                                        </p>
                                        <p class="text-muted mb-0">
                                            <strong>Diplomados Relacionados:</strong> {{ $item['related_courses'] }}
                                        </p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <div class="mb-2">
                                            <span class="badge bg-primary">
                                                <i class="fa fa-users"></i> {{ $item['total_students'] }} estudiantes
                                            </span>
                                        </div>
                                        <a href="#" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#groupModal{{ $item['group']->id }}">
                                            Ver Estudiantes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Estudiantes -->
                        <div class="modal fade" id="groupModal{{ $item['group']->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Estudiantes - {{ $item['group']->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Email</th>
                                                    <th>Fecha de Inscripción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item['group']->students as $student)
                                                    <tr>
                                                        <td>{{ $student->name }}</td>
                                                        <td>{{ $student->email }}</td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle"></i> No tienes grupos asociados aún
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection