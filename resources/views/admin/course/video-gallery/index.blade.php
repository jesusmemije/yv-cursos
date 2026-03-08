@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content d-flex justify-content-between align-items-center mb-4">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2 class="fw-bold">Galería de videos</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Galería de videos</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div
                            class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0 fw-bold text-secondary"><i
                                    class="fas fa-photo-video me-2 text-primary"></i>Listado de Videos</h5>
                            <a href="{{ route('admin.video-gallery.create') }}" class="btn btn-primary shadow-sm">
                                <i class="fas fa-plus-circle me-1"></i> Agregar video
                            </a>
                        </div>

                        <div class="card-body p-4">
                            <div class="customers__table">
                                <table id="customers-table" class="row-border data-table-filter table-style">
                                    <thead>
                                        <tr>
                                            <th class="ps-3">#</th>
                                            <th>Título del video</th>
                                            <th class="text-center">Fecha de creación</th>
                                            <th class="text-end pe-3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($videos as $video)
                                            <tr>
                                                <td class="ps-3 text-muted">{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-play-circle text-primary me-2 fs-5"></i>
                                                        <span class="fw-semibold text-dark">{{ $video->title }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-light text-secondary border">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        {{ $video->created_at ? $video->created_at->format('d/m/Y') : '-' }}
                                                    </span>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <a href="{{ getVideoFile($video->file_path) }}" target="_blank"
                                                            class="btn btn-sm btn-outline-primary shadow-sm"
                                                            title="Ver video original">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>

                                                        <a href="{{ route('admin.video-gallery.edit', $video->uuid) }}"
                                                            class="btn btn-sm btn-outline-info shadow-sm" title="Editar">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <button type="button"
                                                            class="btn btn-sm btn-outline-danger shadow-sm deleteItem"
                                                            data-formid="delete_row_form_{{ $video->uuid }}"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                        <form
                                                            action="{{ route('admin.video-gallery.delete', $video->uuid) }}"
                                                            method="POST" id="delete_row_form_{{ $video->uuid }}">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 d-flex justify-content-center">
                                {{ $videos->links() }}
                            </div>
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
    <script src="{{ asset('admin/js/custom/data-table-page.js') }}"></script>
@endpush
