@extends('layouts.admin')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>Agregar video</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Inicio</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.video-gallery.index') }}">Galeria de videos</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Agregar video</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title">
                            <h2>Nuevo video</h2>
                        </div>

                        <form action="{{ route('admin.video-gallery.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Titulo del video <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Archivo de video <span class="text-danger">*</span></label>
                                    <input type="file" name="video_file" id="video_file" class="form-control" accept=".mp4,.mov,.avi,.mkv,.webm,.wmv" required>
                                    <input type="hidden" name="file_duration" id="file_duration">
                                    <small class="text-muted">Formatos permitidos: mp4, mov, avi, mkv, webm, wmv.</small>
                                    @error('video_file')
                                        <span class="text-danger d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="{{ route('admin.video-gallery.index') }}" class="btn btn-outline-secondary">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function () {
            var input = document.getElementById('video_file');
            if (!input) return;
            input.addEventListener('change', function () {
                if (!this.files || !this.files.length) return;
                var file = this.files[0];
                var video = document.createElement('video');
                video.preload = 'metadata';
                video.onloadedmetadata = function () {
                    window.URL.revokeObjectURL(video.src);
                    var seconds = Number(video.duration || 0);
                    document.getElementById('file_duration').value = seconds > 0 ? seconds : '';
                };
                video.src = URL.createObjectURL(file);
            });
        })();
    </script>
@endpush
