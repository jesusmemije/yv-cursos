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
                                <h2>{{ __('Application Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$title) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.application_settings.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style admin-dashboard-payment-method">
                        <div class="item-top mb-30">
                            <h2>{{ __(@$title) }}</h2>
                        </div>
                        <form action="{{ route('settings.save.setting') }}" method="post" class="form-horizontal"
                              enctype="multipart/form-data">
                            @csrf

                            <div class="row justify-content-center p-3 pb-0">
                                <div
                                    class="admin-dashboard-payment-title-left col-6 border border-bottom-0 pr-4 text-center">
                                    <h5 class="p-2">{{ __('PayPal') }}</h5>
                                </div>
                                <div
                                    class="admin-dashboard-payment-title-right col-6 border border-bottom-0 pl-4 text-center">
                                    <h5 class="p-2">{{ __('Stripe') }}</h5>
                                </div>
                            </div>

                            <div class="row justify-content-center px-3 pb-0 mb-3">

                                <div class="payment-getaway admin-dashboard-payment-content-box-left col-md-6 border p-3">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group text-black">
                                                <label>{{ __('Currency ISO Code') }} </label>
                                                <select  name="paypal_currency" class="form-control paypal_currency currency">
                                                    @foreach(getCurrency() as $code => $currency)
                                                        <option value="{{$code}}" {{ get_option('paypal_currency') == $code ? 'selected' : '' }}>{{$currency}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>{{ __('Conversion Rate') }} </label>
                                            <div class="input-group mb-3">
                                                <span
                                                    class="input-group-text">{{ '1 ' . get_currency_symbol() . ' = ' }}</span>
                                                <input type="number" step="any" min="0"
                                                       name="paypal_conversion_rate"
                                                       value="{{ get_option('paypal_conversion_rate') ? get_option('paypal_conversion_rate') : 1 }}"
                                                       class="form-control">
                                                <span class="input-group-text paypal_append_currency append_currency"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group text-black">
                                                <label>{{ __('Status') }} </label>
                                                <select name="paypal_status" class="form-control">
                                                    <option value="1"
                                                        {{ get_option('paypal_status') == 1 ? 'selected' : '' }}>
                                                        {{ __('Enable') }} </option>
                                                    <option value="0"
                                                        {{ get_option('paypal_status') == '0' ? 'selected' : '' }}>
                                                        {{ __('Disable') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <div class="form-group text-black">
                                                <label>{{ __('PayPal Mode') }} </label>
                                                <select name="PAYPAL_MODE" class="form-control">
                                                    <option value="sandbox"
                                                        {{ get_option('PAYPAL_MODE') == 'sandbox' ? 'selected' : '' }}>
                                                        {{ __('Sandbox') }} </option>
                                                    <option value="live"
                                                        {{ get_option('PAYPAL_MODE') == 'live' ? 'selected' : '' }}>
                                                        {{ __('Live') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">

                                            <div class="form-group text-black">
                                                <label>{{ __('PayPal Client ID') }} </label>
                                                <input type="text" name="PAYPAL_CLIENT_ID"
                                                       value="{{ get_option('PAYPAL_CLIENT_ID') }}" class="form-control">
                                            </div>


                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">

                                            <div class="form-group text-black">
                                                <label>{{ __('PayPal Secret') }} </label>
                                                <input type="text" name="PAYPAL_SECRET"
                                                       value="{{ get_option('PAYPAL_SECRET') }}" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="payment-getaway admin-dashboard-payment-content-box-right col-md-6 border p-3">
                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <div class="form-group text-black">
                                                <label>{{ __('Currency ISO Code') }} </label>
                                                <select  name="stripe_currency" class="form-control stripe_currency currency">
                                                    @foreach(getCurrency() as $code => $currency)
                                                        <option value="{{$code}}" {{ get_option('stripe_currency') == $code ? 'selected' : '' }}>{{$currency}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>{{ __('Conversion Rate') }} </label>
                                            <div class="input-group mb-3">
                                                <span
                                                    class="input-group-text">{{ '1 ' . get_currency_symbol() . ' = ' }}</span>
                                                <input type="number" step="any" min="0"
                                                       name="stripe_conversion_rate"
                                                       value="{{ get_option('stripe_conversion_rate') ? get_option('stripe_conversion_rate') : 1 }}"
                                                       class="form-control">
                                                <span class="input-group-text stripe_append_currency append_currency"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group text-black">
                                                <label>{{ __('Status') }} </label>
                                                <select name="stripe_status" class="form-control">
                                                    <option value="1"
                                                        {{ get_option('stripe_status') == 1 ? 'selected' : '' }}>
                                                        {{ __('Enable') }} </option>
                                                    <option value="0"
                                                        {{ get_option('stripe_status') == '0' ? 'selected' : '' }}>
                                                        {{ __('Disable') }} </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <div class="form-group text-black">
                                                <label>{{ __('Stripe Mode') }} </label>
                                                <select name="STRIPE_MODE" class="form-control">
                                                    <option value="sandbox"
                                                        {{ get_option('stripe_mode') == 'sandbox' ? 'selected' : '' }}>
                                                        {{ __('Sandbox') }} </option>
                                                    <option value="live"
                                                        {{ get_option('stripe_mode') == 'live' ? 'selected' : '' }}>
                                                        {{ __('Live') }} </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <div class="form-group text-black">
                                                <label>{{ __('Stripe Secret Key') }}</label>
                                                <input type="text" name="STRIPE_PUBLIC_KEY"
                                                       value="{{ get_option('STRIPE_PUBLIC_KEY') }}" class="form-control">
                                            </div>
                                        </div>
{{--                                        <div class="col-md-12 mb-3">--}}
{{--                                            <div class="form-group text-black">--}}
{{--                                                <label>{{ __('Stripe Secret Key') }}</label>--}}
{{--                                                <input type="text" name="STRIPE_SECRET_KEY"--}}
{{--                                                       value="{{ get_option('STRIPE_SECRET_KEY') }}" class="form-control">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{ __('Update') }}</button>
                                    </div>
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

@push('script')
    <script src="{{ asset('admin/js/custom/payment-method.js') }}"></script>
@endpush
