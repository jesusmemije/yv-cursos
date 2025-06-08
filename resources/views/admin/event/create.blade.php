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
                                <h2>{{__('Add Event')}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a href="{{route('event.index')}}">{{__('All Events')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__('Add Event')}}</li>
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
                            <h2>{{__('Add Event')}}</h2>
                        </div>
                        <form action="{{route('event.store')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf

                            <div class="input__group mb-25">
                                <label>{{__('Title')}} <span class="text-danger">*</span></label>
                                <input type="text" name="title" value="{{old('title')}}" placeholder="{{__('Title')}}" class="form-control slugable"  onkeyup="slugable()">
                                @if ($errors->has('title'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Slug')}} <span class="text-danger">*</span></label>
                                <input type="text" name="slug" value="{{old('slug')}}" placeholder="{{__('Slug')}}" class="form-control slug" onkeyup="getMyself()">
                                @if ($errors->has('slug'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('slug') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Event Category')}} <span class="text-danger">*</span></label>
                                <select name="event_category_id" class="form-control">
                                    <option value="">{{__('Select Category')}}</option>
                                    @foreach($eventCategories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('event_category_id'))
                                    <span class="text-danger">{{ $errors->first('event_category_id') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Tags')}}</label>
                                <select name="tag_ids[]" class="form-control multiple-basic-single" multiple>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Event Start Date and Time')}} <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="start" value="{{old('start')}}" class="form-control">
                                @if ($errors->has('start'))
                                    <span class="text-danger">{{ $errors->first('start') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Timezone')}} <span class="text-danger">*</span></label>
                                <select name="time_zone" class="form-control select2">
                                    @foreach(getTimeZonesList() as $key => $value)
                                        <option value="{{ $key }}" {{ $key == env('TIMEZONE', 'UTC') ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('time_zone'))
                                    <span class="text-danger">{{ $errors->first('time_zone') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Event End Date and Time')}} <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="end" value="{{old('end')}}" class="form-control">
                                @if ($errors->has('end'))
                                    <span class="text-danger">{{ $errors->first('end') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Location')}} <span class="text-danger">*</span></label>
                                <input type="text" name="location" value="{{old('location')}}" placeholder="{{__('Event Location')}}" class="form-control">
                                @if ($errors->has('location'))
                                    <span class="text-danger">{{ $errors->first('location') }}</span>
                                @endif
                            </div>

                            <div class="input__group mb-25">
                                <label>{{__('Details')}} <span class="text-danger">*</span></label>
                                <textarea name="details" id="summernote">{{old('details')}}</textarea>
                                @if ($errors->has('details'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('details') }}</span>
                                @endif
                            </div>

                            <div class="row">
                                <label>{{ __('Event Image') }}</label>
                                <div class="col-md-3">
                                    <div class="upload-img-box mb-25">
                                        <img src="">
                                        <input type="file" name="image" id="image" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">{{__('Image')}}</p>
                                        </div>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('image') }}</span>
                                @endif
                                <p>{{ __('Accepted Files') }}: JPEG, JPG, PNG <br> {{ __('Recommend Size') }}: 870 x 500 (1MB)</p>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">{{ __('Save Event') }}</button>
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
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">

    <!-- Summernote CSS - CDN Link -->
    <link href="{{ asset('common/css/summernote/summernote.min.css') }}" rel="stylesheet">
    <link href="{{ asset('common/css/summernote/summernote-lite.min.css') }}" rel="stylesheet">
    <!-- //Summernote CSS - CDN Link -->
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{asset('admin/js/custom/slug.js')}}"></script>
    <script src="{{asset('admin/js/custom/form-editor.js')}}"></script>

    <!-- Summernote JS - CDN Link -->
    <script src="{{ asset('common/js/summernote/summernote-lite.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#summernote").summernote({dialogsInBody: true});
            $('.dropdown-toggle').dropdown();
            $('.select2').select2();
        });
    </script>
    <!-- //Summernote JS - CDN Link -->
@endpush
