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
                                <h2>Ciclos escolares</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Ciclos escolares</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm customers__area">
                        <div class="item-title d-flex justify-content-between">
                            <h2>Listado de ciclos escolares</h2>
                            <a href="{{route('admin.group.createStepOne')}}" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Agregar ciclo escolar</a>
                        </div>
                        <div class="card-body p-0">
                            <div class="customers__table table-responsive">
                                <table id="customers-table" class="table table-hover align-middle mb-0">
                                    <thead class="bg-light text-muted uppercase-header">
                                        <tr>
                                            <th class="ps-4">Nombre del ciclo escolar</th>
                                            <th>Período del Ciclo</th>
                                            <th>Período de Inscripción</th>
                                            <th>Estado</th>
                                            <th class="text-center pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($groups as $group)
                                            <tr class="removable-item">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary-light text-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(var(--bs-primary-rgb), 0.1);">
                                                            <i class="fas fa-layer-group"></i>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $group->name }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column small">
                                                        <span class="mb-1 text-nowrap">
                                                            <i class="fa fa-calendar-check text-success me-2 opacity-75"></i>
                                                            {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d M, Y') }}
                                                        </span>
                                                        <span class="text-nowrap">
                                                            <i class="fa fa-calendar-times text-danger me-2 opacity-75"></i>
                                                            {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d M, Y') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column small">
                                                        <span class="mb-1 text-nowrap">
                                                            <i class="far fa-clock text-info me-2 opacity-75"></i>
                                                            {{ \Carbon\Carbon::parse($group->enrollment_start_at)->translatedFormat('d M, Y') }}
                                                        </span>
                                                        <span class="text-nowrap">
                                                            <i class="far fa-clock text-muted me-2 opacity-75"></i>
                                                            {{ \Carbon\Carbon::parse($group->enrollment_end_at)->translatedFormat('d M, Y') }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="status-badge-container">
                                                        <select
                                                            class="status-select form-select form-select-sm border-0 text-white rounded-pill px-3" 
                                                            data-id="{{ $group->id }}"
                                                            style="background-color: {{ $group->status == 1 ? '#28a745' : '#dc3545' }}; min-width: 100px; cursor: pointer;">
                                                            <option value="1" @selected($group->status == 1)>Activo</option>
                                                            <option value="0" @selected($group->status == 0)>Inactivo</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <td class="text-center pe-4">
                                                    <div class="d-flex justify-content-center gap-2">
                                                        <a href="{{route('admin.group.view', [$group->uuid])}}" class="btn btn-sm btn-outline-primary border-0 rounded-circle p-2" title="Ver Detalles">
                                                            <img src="{{asset('admin/images/icons/eye-2.svg')}}" width="18" alt="eye">
                                                        </a>
                                                        <button class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2 delete-btn" data-uuid="{{ $group->uuid }}" title="Eliminar">
                                                            <img src="{{ asset('admin/images/icons/trash-2.svg') }}" width="18" alt="eliminar">
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-25"></i>
                                                        <p class="mb-0">No se encontraron ciclos escolares disponibles</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="small text-muted mb-0">Mostrando registros actuales</p>
                                {{ @$groups->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}">
    <style>
        .table > :not(caption) > * > * {
            padding: 1rem 0.75rem;
        }
        .removable-item:hover {
            background-color: rgba(0,0,0,0.01);
        }
        .status-select {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 10px 10px;
        }
        .btn-outline-primary:hover, .btn-outline-danger:hover {
            background-color: rgba(0,0,0,0.05);
            transform: translateY(-1px);
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/data-table-page.js') }}"></script>
    <script>
        'use strict'

        // Cambiar estado del ciclo escolar
        $(document).on('change', '.status-select', function () {
            const $select = $(this);
            const previousValue = $select.data('previous');
            const status = $select.val();
            const statusText = status == 1 ? 'Activo' : 'Inactivo';
            const id = $select.data('id');

            Swal.fire({
                title: "¡Cambiar estado!",
                text: `¿Deseas cambiar el estado del ciclo escolar a "${statusText}"?`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, cambiar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.group.changeStatus') }}",
                        data: {
                            id: id,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.options.positionClass = 'toast-bottom-right';
                            if (response.status) {
                                const bgColor = status == 1 ? '#28a745' : '#dc3545';
                                $select.css('background-color', bgColor);
                                toastr.success(response.message);
                                $select.data('previous', status);
                            } else {
                                revert();
                                toastr.error(response.message);
                            }
                        },
                        error: function () {
                            revert();
                            toastr.error('Error al cambiar el estado');
                        }
                    });
                } else {
                    revert();
                }
            });

            function revert() {
                $select.val(previousValue);
                const bgColor = previousValue == 1 ? '#28a745' : '#dc3545';
                $select.css('background-color', bgColor);
            }
        });

        $(document).ready(function () {
            $('.status-select').each(function () {
                $(this).data('previous', $(this).val());
            });
        });

        // Eliminar ciclo escolar
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            const $row = $(this).closest('tr');

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Se eliminará el ciclo escolar y toda su información.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('admin.group.delete') }}",
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'uuid': uuid
                        },
                        success: function(response) {
                            toastr.options.positionClass = 'toast-bottom-right';
                            if (response.status) {
                                toastr.success(response.message);
                                // Eliminar la fila con animación
                                $row.fadeOut('fast', function() {
                                    $(this).remove();
                                });
                                setTimeout(() => { location.reload(); }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush