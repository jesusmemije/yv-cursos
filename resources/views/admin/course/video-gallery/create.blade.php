@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content d-flex justify-content-between align-items-center mb-4">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2 class="fw-bold">Agregar video</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.video-gallery.index') }}">Galería</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Agregar video</li>
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
                                <i class="fas fa-plus-circle me-2 text-primary"></i>Agregar nuevo video a la galería
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.video-gallery.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Título del video <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-tag"></i></span>
                                            <input type="text" name="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                placeholder="Ej: Tutorial de configuración inicial"
                                                value="{{ old('title') }}" required>
                                        </div>
                                        @error('title')
                                            <div class="text-danger mt-1 small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-12">
                                        <label class="form-label fw-semibold">Archivo de video <span
                                                class="text-danger">*</span></label>
                                        <div
                                            class="upload-container p-4 border border-2 border-dashed rounded-3 bg-light text-center">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                            <input type="file" name="video_file" id="video_file"
                                                class="form-control @error('video_file') is-invalid @enderror"
                                                accept=".mp4,.mov,.avi,.mkv,.webm,.wmv" required>

                                            <input type="hidden" name="file_duration" id="file_duration">

                                            <div class="mt-3">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-file-video me-1"></i> Formatos: <strong>mp4, mov, avi,
                                                        mkv, webm, wmv</strong>
                                                </small>
                                                <div id="duration-badge" class="badge bg-info mt-2 d-none">
                                                    <i class="fas fa-clock me-1"></i> Duración detectada: <span
                                                        id="display-duration">0</span>s
                                                </div>
                                            </div>
                                        </div>
                                        @error('video_file')
                                            <div class="text-danger mt-1 small d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                    <a href="{{ route('admin.video-gallery.index') }}" class="btn btn-light px-4">
                                        <i class="fas fa-arrow-left me-1"></i> Volver
                                    </a>
                                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                        <i class="fas fa-save me-1"></i> Guardar Video
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

@push('style')
    <style>
        .border-dashed {
            border-style: dashed !important;
            border-width: 2px !important;
            border-color: #dee2e6 !important;
        }

        .upload-container {
            transition: all 0.3s ease;
        }

        .upload-container:hover {
            border-color: #0d6efd !important;
            background-color: #f8f9ff !important;
        }

        .form-label {
            color: #495057;
            font-size: 0.9rem;
        }

        .card {
            border-radius: 12px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function() {
            var input = document.getElementById('video_file');
            var durationInput = document.getElementById('file_duration');
            var durationBadge = document.getElementById('duration-badge');
            var displayDuration = document.getElementById('display-duration');

            if (!input) return;

            input.addEventListener('change', function() {
                if (!this.files || !this.files.length) return;

                var file = this.files[0];
                var video = document.createElement('video');
                video.preload = 'metadata';

                video.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(video.src);
                    var seconds = Math.round(video.duration || 0); // Redondeamos para el usuario

                    if (seconds > 0) {
                        durationInput.value = seconds;
                        displayDuration.innerText = seconds;
                        durationBadge.classList.remove('d-none'); // Mostramos el badge
                    } else {
                        durationInput.value = '';
                        durationBadge.classList.add('d-none');
                    }
                };
                video.src = URL.createObjectURL(file);
            });
        })();
    </script>
@endpush
