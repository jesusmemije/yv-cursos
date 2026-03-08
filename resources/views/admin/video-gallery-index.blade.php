@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>Galeria de videos</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Galeria de videos</li>
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
                            <h2>Videos</h2>
                            <a href="{{ route('admin.video-gallery.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Agregar video
                            </a>
                        </div>

                        <div class="customers__table">
                            <table id="video-gallery-table" class="row-border table-style">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Titulo del video</th>
                                    <th>Fecha de creacion</th>
                                    <th width="12%">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($videos as $video)
                                    <tr class="removable-item">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $video->title }}</td>
                                        <td>{{ $video->created_at ? $video->created_at->format('d/m/Y H:i') : '-' }}</td>
                                        <td>
                                            <div class="action__buttons">
                                                <a href="{{ route('admin.video-gallery.edit', $video->uuid) }}" class="btn-action" title="Editar">
                                                    <img src="{{ asset('admin/images/icons/edit-2.svg') }}" alt="editar">
                                                </a>
                                                <button type="button" class="btn-action ms-2 deleteItem" data-formid="delete_row_form_{{ $video->uuid }}" title="Eliminar">
                                                    <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="eliminar">
                                                </button>
                                                <form action="{{ route('admin.video-gallery.delete', $video->uuid) }}" method="POST" id="delete_row_form_{{ $video->uuid }}">
                                                    @csrf
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No hay videos registrados.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('admin/css/jquery.dataTables.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(function () {
            $('#video-gallery-table').DataTable({
                language: {
                    emptyTable: 'No hay datos disponibles en la tabla',
                    info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
                    infoEmpty: 'Mostrando 0 a 0 de 0 registros',
                    infoFiltered: '(filtrado de _MAX_ registros totales)',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    loadingRecords: 'Cargando...',
                    processing: 'Procesando...',
                    search: 'Buscar:',
                    zeroRecords: 'No se encontraron resultados',
                    paginate: {
                        first: 'Primero',
                        last: 'Ultimo',
                        next: 'Siguiente',
                        previous: 'Anterior'
                    }
                },
                pageLength: 20,
                order: [[0, 'asc']]
            });
        });
    </script>
@endpush
