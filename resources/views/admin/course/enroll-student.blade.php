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
                                <h2>{{ __('Add Student In Course') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('Add Student In Course') }}</li>
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
                            <h2>{{ __('Enroll In Course') }}</h2>
                            <!-- Botón para abrir el modal de importación -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#importEnrollmentsModal">
                                {{ __('Importar Inscripciones') }}
                            </button>
                        </div>
                        <form action="{{route('admin.course.enroll.store')}}" method="post" class="form-horizontal" >
                            @csrf

                            <div class="input__group mb-25">
                                <label>{{ __('Student') }} <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" required class="">
                                    <option value="">--{{ __('Select Student') }}--</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(old('user_id') == $user->id) selected @endif>{{ @$user->student->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('user_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('user_id') }}</span>
                                @endif
                            </div>
                            <div class="input__group mb-25">
                                <label>{{ __('Course') }} <span class="text-danger">*</span></label>
                                <select name="course_id" required id="course_id">
                                    <option value="">--{{ __('Select Course') }}--</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" @if(old('course_id') == $course->id) selected @endif>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('course_id'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('course_id') }}</span>
                                @endif
                            </div>
                            
                            <div class="input__group mb-25">
                                <label>{{ __('Expired After Days') }} </label>
                               <input type="number" class="form-control" name="expired_after_days" min=1>
                                @if ($errors->has('expired_after_days'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('expired_after_days') }}</span>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->

    <!-- Modal para la importación de inscripciones -->
    <div class="modal fade" id="importEnrollmentsModal" tabindex="-1" aria-labelledby="importEnrollmentsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importEnrollmentsModalLabel">{{ __('Importar Inscripciones') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.course.enroll.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="csv_file">{{ __('Selecciona el archivo CSV') }}</label>
                            <input type="file" class="form-control" id="csv_file" name="csv_file" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancelar') }}</button>
                            <button type="submit" class="btn btn-primary">{{ __('Importar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script src="{{ asset('admin/js/standalone/selectize.min.js') }}" ></script>
    <link rel="stylesheet" href="{{ asset('admin/css/selectize.bootstrap3.min.css') }}" />
    <script>
        $(document).ready(function () {
            $('select').selectize({
                sortField: 'text'
            });
        })
    </script>
@endpush
