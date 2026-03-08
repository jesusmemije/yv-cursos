@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content d-flex justify-content-between align-items-center mb-4">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2 class="fw-bold">Editar video</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.video-gallery.index') }}">Galería</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Editar video</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title mb-0 fw-bold text-secondary">
                                <i class="fas fa-edit text-primary me-2"></i>Modificar información
                            </h5>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('admin.video-gallery.update', $video->uuid) }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label fw-semibold">Título del video <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                                            <input type="text" name="title" 
                                                   class="form-control @error('title') is-invalid @enderror" 
                                                   value="{{ old('title', $video->title) }}" 
                                                   placeholder="Ingrese el nuevo título" required>
                                        </div>
                                        @error('title')
                                            <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="alert alert-light border-0 bg-light p-3 rounded-3 mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-info-circle text-info me-3 fa-lg"></i>
                                        <div>
                                            <small class="text-muted d-block">Archivo actual:</small>
                                            <span class="text-dark fw-medium small text-break">{{ $video->file_path }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                    <a href="{{ route('admin.video-gallery.index') }}" class="btn btn-light px-4">
                                        <i class="fas fa-arrow-left me-1"></i> Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                        <i class="fas fa-sync-alt me-1"></i> Actualizar nombre
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .input-group-text {
        border-right: none;
    }
    .form-control:focus {
        border-color: #dee2e6;
        box-shadow: none;
    }
    .card {
        transition: all 0.3s ease;
    }
</style>