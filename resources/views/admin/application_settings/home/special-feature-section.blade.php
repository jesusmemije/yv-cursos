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
                                <h2>{{ __('Home Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                   <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a>{{__('Application Setting')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$title) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.application_settings.home-sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style admin-special-feature-section-page">
                        <div class="item-top mb-30"><h2>{{ __(@$title) }}</h2></div>
                        <form action="{{route('settings.general_setting.cms.update')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if(get_option('theme', THEME_DEFAULT) != THEME_DEFAULT)
                            <div class="row">
                                <div class="custom-form-group mb-3 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                                    <label for="home_special_feature_title" class="text-lg-right text-black"> {{ __('Feature Section Title') }}</label>
                                    <input type="text" name="home_special_feature_title" id="home_special_feature_title"
                                           value="{{ get_option('home_special_feature_title') }}" class="form-control"
                                               placeholder="{{ __('Type title') }}" required>

                                </div>
                            </div>
                            @endif
                            
                            <div class="row">
                                <div class="custom-form-group mb-3 col-md-12 col-lg-3 col-xl-3 col-xxl-2">
                                    <label for="home_special_feature_first_logo" class=" text-lg-right text-black"> {{ __('First Logo') }} </label>
                                    <div class="upload-img-box">
                                        @if(get_option('home_special_feature_first_logo') != '')
                                            <img src="{{ getImageFile(get_option('home_special_feature_first_logo')) }}">
                                        @else
                                            <img src="">
                                        @endif
                                        <input type="file" name="home_special_feature_first_logo" id="logo" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">{{ __('Logo') }}</p>
                                        </div>
                                    </div>
                                    @if ($errors->has('home_special_feature_first_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('home_special_feature_first_logo') }}</span>
                                    @endif
                                    <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 77 x 77</p>
                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                                    <label for="home_special_feature_first_title" class="text-lg-right text-black"> {{ __('First Title') }}</label>
                                    <input type="text" name="home_special_feature_first_title" id="home_special_feature_first_title"
                                           value="{{ get_option('home_special_feature_first_title') }}" class="form-control"
                                               placeholder="{{ __('Type title') }}" required>

                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-5 col-xl-5 col-xxl-6">
                                    <label for="home_special_feature_first_subtitle" class="text-lg-right text-black"> {{ __('First Subtitle') }}</label>
                                    <input type="text" name="home_special_feature_first_subtitle" id="home_special_feature_first_subtitle"
                                           value="{{ get_option('home_special_feature_first_subtitle') }}" class="form-control"
                                               placeholder="{{ __('Type subtitle') }}" required>

                                </div>
                            </div>

                            <div class="row">
                                <div class="custom-form-group mb-3 col-md-12 col-lg-3 col-xl-3 col-xxl-2">
                                    <label for="home_special_feature_second_logo" class=" text-lg-right text-black"> {{ __('Second Logo') }} </label>
                                    <div class="upload-img-box">
                                        @if(get_option('home_special_feature_second_logo') != '')
                                            <img src="{{ getImageFile(get_option('home_special_feature_second_logo')) }}">
                                        @else
                                            <img src="">
                                        @endif
                                        <input type="file" name="home_special_feature_second_logo" id="home_special_feature_second_logo" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">Logo</p>
                                        </div>
                                    </div>
                                    @if ($errors->has('home_special_feature_second_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('home_special_feature_second_logo') }}</span>
                                    @endif
                                    <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 77 x 77</p>
                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                                    <label for="home_special_feature_second_title" class="text-lg-right text-black"> {{ __('Second Title') }}</label>
                                    <input type="text" name="home_special_feature_second_title" id="home_special_feature_second_title"
                                           value="{{ get_option('home_special_feature_second_title') }}" class="form-control"
                                               placeholder="{{ __('Type title') }}" required>

                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-5 col-xl-5 col-xxl-6">
                                    <label for="home_special_feature_second_subtitle" class="text-lg-right text-black"> {{ __('Second Subtitle') }}</label>
                                    <input type="text" name="home_special_feature_second_subtitle" id="home_special_feature_second_subtitle"
                                           value="{{ get_option('home_special_feature_second_subtitle') }}" class="form-control"
                                               placeholder="{{ __('Type subtitle') }}" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="custom-form-group mb-3 col-md-12 col-lg-3 col-xl-3 col-xxl-2">
                                    <label for="home_special_feature_third_logo" class=" text-lg-right text-black"> {{ __('Third Logo') }} </label>
                                    <div class="upload-img-box">
                                        @if(get_option('home_special_feature_third_logo') != '')
                                            <img src="{{ getImageFile(get_option('home_special_feature_third_logo')) }}">
                                        @else
                                            <img src="">
                                        @endif
                                        <input type="file" name="home_special_feature_third_logo" id="home_special_feature_third_logo" accept="image/*" onchange="previewFile(this)">
                                        <div class="upload-img-box-icon">
                                            <i class="fa fa-camera"></i>
                                            <p class="m-0">{{ __('Logo') }}</p>
                                        </div>
                                    </div>
                                    @if ($errors->has('home_special_feature_third_logo'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('home_special_feature_third_logo') }}</span>
                                    @endif
                                    <p><span class="text-black">{{ __('Accepted Files') }}:</span> PNG <br> <span class="text-black">{{ __('Accepted Size') }}:</span> 77 x 77</p>
                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                                    <label for="home_special_feature_third_title" class="text-lg-right text-black"> {{ __('Third Title') }}</label>
                                    <input type="text" name="home_special_feature_third_title" id="home_special_feature_third_title"
                                           value="{{ get_option('home_special_feature_third_title') }}" class="form-control"
                                           placeholder="{{ __('Type title') }}" required>

                                </div>
                                <div class="custom-form-group mb-3 col-md-12 col-lg-5 col-xl-5 col-xxl-6">
                                    <label for="home_special_feature_thirdsubtitle" class="text-lg-right text-black"> {{ __('Third Subtitle') }}</label>
                                    <input type="text" name="home_special_feature_third_subtitle" id="home_special_feature_third_subtitle"
                                           value="{{ get_option('home_special_feature_third_subtitle') }}" class="form-control"
                                           placeholder="{{ __('Type subtitle') }}" required>
                                </div>
                            </div>


                            <div class="row justify-content-end">
                                <div class="col-md-2 text-right ">
                                    @updateButton
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
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
@endpush
