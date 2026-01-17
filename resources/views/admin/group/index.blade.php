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
                                                    <span class="fw-bold">Inicio:</span> 
                                                    {{ \Carbon\Carbon::parse($group->start_date)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                                <div class="finance-table-inner-item">
                                                    <span class="fw-bold">Fin:</span> 
                                                    {{ \Carbon\Carbon::parse($group->end_date)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="finance-table-inner-item">
                                                    <span class="fw-bold">Inicio:</span> 
                                                    {{ \Carbon\Carbon::parse($group->enrollment_start_at)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                                <div class="finance-table-inner-item">
                                                    <span class="fw-bold">Fin:</span> 
                                                    {{ \Carbon\Carbon::parse($group->enrollment_end_at)->translatedFormat('d \d\e F \d\e Y') }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($group->status == 1)
                                                    <span class="status bg-green">Activo</span>
                                                @else
                                                    <span class="status bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action__buttons text-center">
                                                    <a href="{{ route('admin.group.createStepTwo', $group->uuid) }}" title="Editar">
                                                        <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="editar">
                                                    </a>
                                                    <a href="javascript:void(0);" class="delete-btn" data-uuid="{{ $group->uuid }}" title="Eliminar">
                                                        <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="eliminar">
                                                    </a>
                                                </div>
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
        // Eliminar grupo
        $(document).on('click', '.delete-btn', function(e){
            e.preventDefault();
            let uuid = $(this).data('uuid');
            
            Swal.fire({
                title: "¿Estás seguro?",
                text: "¡No podrás recuperar estos datos!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.group.delete') }}",
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'uuid': uuid
                        },
                        success: function(response){
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush