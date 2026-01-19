@extends('layouts.admin')

@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row mb-4 align-items-center">
            <div class="col-md-6">
                <div class="breadcrumb__content">
                    <div class="breadcrumb__title">
                        <h2>Detalles del Grupo</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="{{ route('admin.group.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 font-weight-bold"><i class="fas fa-layer-group me-2"></i>{{ $group->name }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Período del Ciclo</label>
                                <p class="mb-0 text-dark">
                                    <i class="far fa-calendar-alt me-2 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d M, Y') }} - 
                                    {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d M, Y') }}
                                </p>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label class="text-muted small text-uppercase fw-bold">Inscripciones</label>
                                <p class="mb-0 text-dark">
                                    <i class="fas fa-user-plus me-2 text-success"></i>
                                    {{ \Carbon\Carbon::parse($group->enrollment_start_at)->translatedFormat('d M, Y') }} - 
                                    {{ \Carbon\Carbon::parse($group->enrollment_end_at)->translatedFormat('d M, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 font-weight-bold">Diplomados Asociados</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Diplomado</th>
                                        <th>Instructor</th>
                                        <th>Precio</th>
                                        <th class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($courses as $course)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ getImageFile($course->image_path) }}" class="rounded shadow-sm me-3" width="50" height="40" style="object-fit: cover;">
                                                <div>
                                                    <a href="{{ route('course-details', $course->slug) }}" target="_blank" class="fw-bold text-decoration-none text-dark">
                                                        {{ $course->title }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted">{{ $course->user->name ?? 'N/A' }}</span></td>
                                        <td><span class="fw-bold">{{ get_currency_symbol() }}{{ number_format($course->price, 2) }}</span></td>
                                        <td class="text-end pe-4">
                                            <a href="{{ route('course-details', $course->slug) }}" target="_blank" class="btn btn-sm btn-light border">Ver</a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No hay diplomados asociados</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $courses->links() }}
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="m-0 font-weight-bold">Resumen Estadístico</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="small text-muted text-uppercase fw-bold">Cursos Totales</div>
                                    <h5 class="mb-0">{{ $group->courses()->count() }}</h5>
                                </div>
                                <div class="icon-circle bg-info-light text-info p-3 rounded-circle">
                                    <i class="fas fa-book-open"></i>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="small text-muted text-uppercase fw-bold">Estudiantes Inscritos</div>
                                    <h5 class="mb-0">{{ $totalStudents }}</h5>
                                </div>
                                <div class="icon-circle bg-success-light text-success p-3 rounded-circle">
                                    <i class="fas fa-users"></i>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="small text-muted text-uppercase fw-bold">Estado Actual</div>
                                    <span class="badge rounded-pill {{ $group->status == 1 ? 'bg-success' : 'bg-warning' }}">
                                        {{ $group->status == 1 ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                                <div class="icon-circle p-3">
                                    <i class="fas fa-signal {{ $group->status == 1 ? 'text-success' : 'text-warning' }}"></i>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection