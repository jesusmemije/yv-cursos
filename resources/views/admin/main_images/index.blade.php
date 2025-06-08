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
                                <h2>Imágenes principales</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Imágenes</li>
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
                            <h2>Lista de imágenes</h2>
                            <span class="text-muted">Importante: Para que el carusel funcione correctamente solo tiene que haber <strong>4 imágenes agregadas.</strong></span>
                        </div>
                        <div class="customers__table all-course">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Image') }}</th>
                                        <th>Redirección</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($images as $item)
                                        <tr class="removable-item">
                                            <td>{{ $images->firstItem() + $loop->index }}</td>
                                            <td><a href="#"> <img src="{{ getImageFile($item->image_url) }}" width="80"> </a></td>
                                            <td>{{ $item->redirect_url }}</td>
                                            <td>
                                                <div class="action__buttons">
                                                    <button class="btn-action ms-2 deleteItem" data-formid="delete_row_form_{{ $item->id }}">
                                                        <img src="{{ asset('admin/images/icons/trash-2.svg') }}" alt="trash">
                                                    </button>
                                                    <form action="{{ route('admin.main-images.delete', [$item->id]) }}" method="get" id="delete_row_form_{{ $item->id }}"></form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{ $images->links() }}
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
@endpush
