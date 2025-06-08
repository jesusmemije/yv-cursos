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
                                <h2>{{__('Events')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('Events')}}</li>
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
                            <h2>{{__('Event List')}}</h2>
                            <a href="{{route('event.create')}}" class="btn btn-success btn-sm"> <i class="fa fa-plus"></i> {{__('Add Event')}} </a>
                        </div>
                        <div class="customers__table">
                            <table id="customers-table" class="row-border data-table-filter table-style">
                                <thead>
                                <tr>
                                    <th>{{__('Image')}}</th>
                                    <th>{{__('Title')}}</th>
                                    <th>{{__('Category')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Organizer')}}</th>
                                    <th>{{__('Action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr class="removable-item">
                                        <td>
                                            <div class="admin-dashboard-blog-list-img">
                                                <img src="{{getImageFile($event->image_path)}}" alt="img">
                                            </div>
                                        </td>
                                        <td>
                                            {{$event->title}}
                                        </td>
                                        <td>
                                            {{$event->category ? $event->category->name : '' }}
                                        </td>
                                        <td>
                                            @if($event->status == 1)
                                                <span class="status bg-green">{{ __('Published') }}</span>
                                            @else
                                                <span class="status bg-red">{{ __('Unpublished') }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $event->user ? $event->user->name : '' }}
                                        </td>
                                        <td>
                                            <div class="action__buttons">
                                                <a href="{{route('event.edit', [$event->uuid])}}" title="Edit" class="btn-action">
                                                    <img src="{{asset('admin/images/icons/edit-2.svg')}}" alt="edit">
                                                </a>
                                                <a href="javascript:void(0);" data-url="{{route('event.delete', [$event->uuid])}}" title="Delete" class="btn-action delete">
                                                    <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash">
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{@$events->links()}}
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
    <link rel="stylesheet" href="{{asset('admin/css/jquery.dataTables.min.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/js/custom/data-table-page.js')}}"></script>
@endpush
