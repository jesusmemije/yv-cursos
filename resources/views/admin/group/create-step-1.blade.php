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
                                    <li class="breadcrumb-item active" aria-current="page">Agregar grupo</li>
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
                            <h2>Agregar Grupo</h2>
                            <a href="{{ route('admin.group.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fa fa-arrow-left"></i> Volver
                            </a>
                        </div>
                        
                        <!-- Ayuda informativa -->
                        <div class="alert alert-info mb-4" role="alert">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Las fechas de inscripción deben terminar antes de que inicie el ciclo.
                        </div>

                        <form action="{{ route('admin.group.storeStepOne') }}" method="post" class="form-horizontal">
                            @csrf
                            
                            <!-- Nombre del Grupo -->
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="input__group text-black">
                                        <label>Nombre del Grupo <span class="text-danger">*</span></label>
                                        <input type="text" name="group_name" value="{{ old('group_name') }}"
                                            placeholder="Ej: Grupo A - Semestre 2024-I" class="form-control @error('group_name') is-invalid @enderror">
                                        @error('group_name')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Período del Ciclo -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input__group text-black">
                                        <label>Fecha Inicio Ciclo <span class="text-danger">*</span></label>
                                        <input type="date" name="start_date" value="{{ old('start_date') }}" 
                                            class="form-control @error('start_date') is-invalid @enderror" required>
                                        <small class="form-text text-muted">Cuándo comienza el ciclo académico</small>
                                        @error('start_date')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input__group text-black">
                                        <label>Fecha Fin Ciclo <span class="text-danger">*</span></label>
                                        <input type="date" name="end_date" value="{{ old('end_date') }}" 
                                            class="form-control @error('end_date') is-invalid @enderror" required>
                                        <small class="form-text text-muted">Cuándo termina el ciclo académico</small>
                                        @error('end_date')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Período de Inscripción -->
                            <h5 class="mb-3">Período de Inscripciones</h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="input__group text-black">
                                        <label>Fecha Inicio Inscripciones <span class="text-danger">*</span></label>
                                        <input type="date" name="enrollment_start_at" value="{{ old('enrollment_start_at') }}" 
                                            class="form-control @error('enrollment_start_at') is-invalid @enderror" required>
                                        <small class="form-text text-muted">Cuándo abren las inscripciones</small>
                                        @error('enrollment_start_at')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="input__group text-black">
                                        <label>Fecha Fin Inscripciones <span class="text-danger">*</span></label>
                                        <input type="date" name="enrollment_end_at" value="{{ old('enrollment_end_at') }}" 
                                            class="form-control @error('enrollment_end_at') is-invalid @enderror" required>
                                        <small class="form-text text-muted">Cuándo cierran las inscripciones</small>
                                        @error('enrollment_end_at')
                                            <span class="text-danger">
                                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Botones de Acción -->
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-arrow-right"></i> Siguiente
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            // Validación de fechas en cliente
            const startDateInput = $('input[name="start_date"]');
            const endDateInput = $('input[name="end_date"]');
            const enrollmentStartInput = $('input[name="enrollment_start_at"]');
            const enrollmentEndInput = $('input[name="enrollment_end_at"]');

            // Validar que end_date sea mayor que start_date
            endDateInput.on('change', function() {
                if (startDateInput.val() && $(this).val() <= startDateInput.val()) {
                    $(this).addClass('is-invalid');
                    showError('La fecha fin debe ser posterior a la fecha inicio del ciclo');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validar que enrollment_end_at sea antes que start_date
            enrollmentEndInput.on('change', function() {
                if (startDateInput.val() && $(this).val() >= startDateInput.val()) {
                    $(this).addClass('is-invalid');
                    showError('Las inscripciones deben terminar antes de que inicie el ciclo');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validar que enrollment_end_at sea mayor que enrollment_start_at
            enrollmentEndInput.on('change', function() {
                if (enrollmentStartInput.val() && $(this).val() <= enrollmentStartInput.val()) {
                    $(this).addClass('is-invalid');
                    showError('Fecha fin de inscripciones debe ser posterior a fecha inicio');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            // Validar que enrollment_start_at sea menor que enrollment_end_at
            enrollmentStartInput.on('change', function() {
                if (enrollmentEndInput.val() && $(this).val() >= enrollmentEndInput.val()) {
                    $(this).addClass('is-invalid');
                    showError('Fecha inicio de inscripciones debe ser anterior a fecha fin');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            function showError(message) {
                toastr.options.positionClass = 'toast-top-right';
                toastr.error(message);
            }
        });
    </script>
@endpush