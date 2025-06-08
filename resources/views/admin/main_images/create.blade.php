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
                                <h2>Agregar Imagen</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.main-images.index') }}">Todas las Imágenes</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Agregar Imagen</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex justify-content-between">
                            <h2>Agregar Imagen</h2>
                        </div>
                        <form action="{{ route('admin.main-images.store') }}" method="post" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="input__group mb-25">
                                <label>URL que abrirá la imagen <span class="text-danger">*</span></label>
                                <input type="url" name="redirect_url" value="{{ old('redirect_url') }}" placeholder="Example: https://www.youtube.com/watch?v=xxxx" required class="form-control">
                                @if ($errors->has('redirect_url'))
                                    <span class="text-danger">{{ $errors->first('redirect_url') }}</span>
                                @endif
                            </div>

                            <div class="row">
                                <label>Imagen a mostrar en el carusel <span class="text-danger">*</span></label>
                                <div class="col-md-3">
                                    <div class="upload-img-box mb-25">
                                        <img src="">
                                        <input type="file" name="image_url" id="image_url" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i><p class="m-0">{{ __('Image') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('image_url'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('image_url') }}</span>
                                @endif
                                <p>{{ __('Accepted Files') }}: JPEG, JPG, PNG <br>
                                    Tamaño mínimo: 540 x 540 <br>
                                    Se recomienda subir una <strong>imagen cuadrada (alto x ancho)</strong> para una mejor visualización.
                                </p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">Guardar Imagen</button>
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
    <link rel="stylesheet" href="{{ asset('admin/css/custom/image-preview.css') }}">
@endpush

@push('script')
    <script src="{{ asset('admin/js/custom/image-preview.js') }}"></script>
@endpush
