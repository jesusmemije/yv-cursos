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
                                    <li class="breadcrumb-item active" aria-current="page">Grupos</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30 admin-dashboard-blog-list-page">
                        <div class="item-title d-flex justify-content-between">
                            <h2>Listado de Grupos</h2>
                            <a href="{{ route('admin.group.createStepOne') }}" class="btn btn-success btn-sm"> 
                                <i class="fa fa-plus"></i> Agregar Grupo
                            </a>
                        </div>
                        <div class="customers__table">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                    <tr>
                                        <th>Nombre del Grupo</th>
                                        <th>Período del Ciclo</th>
                                        <th>Período de Inscripción</th>
                                        <th>Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($groups as $group)
                                        <tr class="removable-item">
                                            <td>
                                                <strong>{{ $group->name }}</strong>
                                            </td>
                                            <td>
                                                <div class="finance-table-inner-item">
                                                    <i class="fa fa-calendar-plus text-success" title="Fecha de inicio"></i>
                                                    {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>

                                                <div class="finance-table-inner-item">
                                                    <i class="fa fa-calendar-times text-danger" title="Fecha de fin"></i>
                                                    {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="finance-table-inner-item">
                                                    <i class="fa fa-calendar-check text-success" title="Inicio de inscripción"></i>
                                                    {{ \Carbon\Carbon::parse($group->enrollment_start_at)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>

                                                <div class="finance-table-inner-item">
                                                    <i class="fa fa-calendar-times text-danger" title="Fin de inscripción"></i>
                                                    {{ \Carbon\Carbon::parse($group->enrollment_end_at)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                <select
                                                    class="status-select badge text-white" data-id="{{ $group->id }}"
                                                    style="background-color: {{ $group->status == 1 ? '#28a745' : '#dc3545' }};">
                                                    <option value="1" @selected($group->status == 1)>Activo</option>
                                                    <option value="0" @selected($group->status == 0)>Inactivo</option>
                                                </select>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="delete-btn" data-uuid="{{ $group->uuid }}" title="Eliminar">
                                                    <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="eliminar">
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p class="m-0">No hay datos disponibles</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-3">
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
@endpush

@push('script')
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom/data-table-page.js') }}"></script>
    <script>
        'use strict'

        // Cambiar estado del grupo
        $(document).on('change', '.status-select', function () {
            const $select = $(this);
            const previousValue = $select.data('previous');
            const status = $select.val();
            const statusText = status == 1 ? 'Activo' : 'Inactivo';
            const id = $select.data('id');

            Swal.fire({
                title: "¡Cambiar estado!",
                text: `¿Deseas cambiar el estado del grupo a "${statusText}"?`,
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

        // Eliminar grupo
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();
            const uuid = $(this).data('uuid');
            const $row = $(this).closest('tr');

            Swal.fire({
                title: "¿Estás seguro?",
                text: "Se eliminará el grupo y toda su información. ¡No podrás recuperar estos datos!",
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
                                
                                // Recargar después de 1 segundo
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.options.positionClass = 'toast-bottom-right';
                            let errorMessage = 'Error al eliminar el grupo';
                            
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            toastr.error(errorMessage);
                            console.error(xhr);
                        }
                    });
                }
            });
        });
    </script>
@endpush