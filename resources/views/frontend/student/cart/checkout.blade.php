@extends('frontend.layouts.app')

@section('content')
    <div class="bg-page">
        <!-- Page Header Start -->
        <header class="page-banner-header blank-page-banner-header gradient-bg position-relative">
            <div class="section-overlay">
                <div class="blank-page-banner-wrap">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12">
                                <div class="page-banner-content text-center">
                                    <h3 class="page-banner-heading color-heading pb-15">{{ __('Checkout') }}</h3>

                                    <!-- Breadcrumb Start-->
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb justify-content-center">
                                            <li class="breadcrumb-item font-14"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                                            <li class="breadcrumb-item font-14 active" aria-current="page">
                                                {{ __('Checkout') }}</li>
                                        </ol>
                                    </nav>
                                    <!-- Breadcrumb End-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Header End -->

        <!-- Cart Page Area Start -->
        <section class="checkout-page">
            <div class="container">
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <strong>{{ __('Error!') }}</strong> {{ $message }}
                    </div>
                @endif

                <form method="post" action="{{ route('student.pay') }}" data-cc-on-file="false" id="payment-form"
                    class="require-validation" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="token_id" name="token_id">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="checkout-page-left-part">
                                <div class="billing-address-box bg-white">

                                    <h6 class="font-16 font-medium color-heading mb-30">{{ __('Billing Address') }}
                                    </h6>

                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('First Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" id="first_name" value="{{ $student->first_name }}"
                                                required class="form-control" placeholder="{{ __('First Name') }}">
                                            @if ($errors->has('first_name'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('first_name') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Last Name') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="last_name" id="last_name" value="{{ $student->last_name }}"
                                                required class="form-control" placeholder="{{ __('Last Name') }}">
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('last_name') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Email Address') }} <span class="text-danger">*</span></label>
                                            <input type="email" name="email" value="{{ $student->user->email }}" id="email"
                                                required class="form-control"
                                                placeholder="{{ __('Email Address') }}">
                                            @if ($errors->has('email'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Address') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="address" id="address" value="{{ $student->address }}"
                                                class="form-control" required placeholder="{{ __('Address') }}">
                                            @if ($errors->has('street_address'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('street_address') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 mb-30">
                                            <label
                                                class="font-medium font-15 color-heading">{{ __('Country') }}</label>

                                            @if ($student->country_id && $student->country)
                                                <input type="text" value="{{ $student->country->country_name }}"
                                                    class="form-control" readonly>
                                                <input type="hidden" name="country_id"
                                                    value="{{ $student->country_id }}">
                                            @else
                                                <select name="country_id" id="country_id" class="form-select">
                                                    <option value="">{{ __('Select Country') }}</option>
                                                    @foreach ($countries as $country)
                                                        <option value="{{ $country->id }}"
                                                            @if (old('country_id')) {{ old('country_id') == $country->id ? 'selected' : '' }} @else  {{ $student->country_id == $country->id ? 'selected' : '' }} @endif>
                                                            {{ $country->country_name }}</option>
                                                    @endforeach
                                                </select>
                                            @endif

                                            @if ($errors->has('country_id'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('country_id') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('State') }}</label>

                                            @if ($student->state_id && $student->state)
                                                <input type="text" value="{{ $student->state->name }}"
                                                    class="form-control" readonly>
                                                <input type="hidden" name="state_id" value="{{ $student->state_id }}">
                                            @else
                                                <select name="state_id" id="state_id" class="form-select">
                                                    <option value="">{{ __('Select State') }}</option>
                                                    @if (old('country_id'))
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id }}"
                                                                {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                                {{ $state->name }}</option>
                                                        @endforeach
                                                    @else
                                                        @if ($student->country)
                                                            @foreach ($student->country->states as $selected_state)
                                                                <option value="{{ $selected_state->id }}"
                                                                    {{ $student->state_id == $selected_state->id ? 'selected' : '' }}>
                                                                    {{ $selected_state->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            @endif
                                            @if ($errors->has('state_id'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('state_id') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('City') }}</label>

                                            @if ($student->city_id && $student->city)
                                                <input type="text" value="{{ $student->city->name }}"
                                                    class="form-control" readonly>
                                                <input type="hidden" name="city_id" value="{{ $student->city_id }}">
                                            @else
                                                <select name="city_id" id="city_id" class="form-select">
                                                    <option value="">{{ __('Select City') }}</option>
                                                    @if (old('state_id'))
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                                {{ $city->name }}</option>
                                                        @endforeach
                                                    @else
                                                        @if ($student->state)
                                                            @foreach ($student->state->cities as $selected_city)
                                                                <option value="{{ $selected_city->id }}"
                                                                    {{ $student->city_id == $selected_city->id ? 'selected' : '' }}>
                                                                    {{ $selected_city->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            @endif
                                            @if ($errors->has('city_id'))
                                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                                                    {{ $errors->first('city_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Zip Code') }}</label>
                                            <input type="text" name="postal_code" id="postal_code"
                                                value="{{ $student->postal_code }}" class="form-control"
                                                placeholder="{{ __('Zip code') }}">
                                        </div>
                                        <div class="col-md-6 mb-30">
                                            <label
                                                class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Phone') }} <span class="text-danger">*</span></label>
                                            <input type="text" name="phone_number" id="phone_number"
                                                value="{{ $student->phone_number }}" required class="form-control"
                                                placeholder="{{ __('Type your phone number') }}">
                                        </div>
                                    </div>

                                </div>
                                <div class="payment-method-box bg-white">
                                    <h6 class="font-16 font-medium color-heading mb-30">{{ __('Payment Method') }}
                                    </h6>
                                    <!-- OPENPAY INTEGRATION -->
                                    <div class="form-check payment-method-card-box paypal-box pb-0 mt-30">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                                value="openpay" {{ old('payment_method') == 'openpay' ? 'checked' : '' }}
                                                id="stripePayment">
                                        <label class="form-check-label" for="stripePayment">
                                            <span>
                                                <span class="font-16 color-heading font-medium me-3">Openpay</span>
                                            </span>
                                            <span class="payment-card-list">
                                                <img src="{{ asset('frontend/assets/img/student-profile-img/payment-openpay.png') }}"
                                                    alt="openpay">
                                            </span>
                                        </label>
                                        <div class="mt-3 px-4 d-none" id="openpay-form">
                                            @include('frontend.student.cart.partial.payments.openpay-form')
                                        </div>
                                    </div>                                    
                                    @if (get_option('paypal_status') == 1)
                                        <div class="form-check payment-method-card-box paypal-box mb-15">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="paypal" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}
                                                id="paypalPayment">
                                            <label class="form-check-label" for="paypalPayment">
                                                <span>
                                                    <span class="font-16 color-heading font-medium me-3">PayPal</span>
                                                    <span class="font-14">{{ __('You will be redirected to the PayPal website after submitting your order') }}</span>
                                                </span>
                                                <span class="payment-card-list">
                                                    <img src="{{ asset('frontend/assets/img/student-profile-img/payment-paypal.png') }}"
                                                        alt="paypal">
                                                </span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('bank_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="bank" {{ old('payment_method') == 'bank' ? 'checked' : '' }}
                                                id="bankPayment">
                                            <label class="form-check-label" for="bankPayment">
                                                <span class="font-16 color-heading font-medium">{{ __('Bank') }}</span>
                                            </label>
                                            <div class="payment-method-card-info-box">
                                                <div class="row">
                                                    <div class="col-md-6 mb-30">
                                                        <label class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Name') }}</label>
                                                        <select name="bank_id" id="bank_id" class="form-control">
                                                            <option value="">{{ __('Select One') }}</option>
                                                            @foreach ($banks as $bank)
                                                                <option value="{{ $bank->id }}">
                                                                    {{ $bank->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Account Number') }}</label>
                                                        <input type="text" class="form-control account_number"
                                                            id="account_number" readonly>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Deposit By') }}</label>
                                                        <input type="text" class="form-control" placeholder="{{ __('Name') }}" readonly
                                                            name="deposit_by" value="{{ auth()->user()->student->name }}">
                                                    </div>
                                                    <div class="col-md-6 mb-30">
                                                        <label
                                                            class="label-text-title color-heading font-medium font-16 mb-3">{{ __('Deposit Slip') }}</label>
                                                        <input type="file" class="form-control" name="deposit_slip">
                                                    </div>
                                                </div>

                                                <div class="form-row row">
                                                    <div class="col-md-12 d-none error form-group">
                                                        <div class="alert-danger alert  bank-error-message">
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endif

                                    @if (get_option('stripe_status') == 1)
                                        <div class="form-check payment-method-card-box paypal-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                   value="stripe" {{ old('payment_method') == 'stripe' ? 'checked' : '' }}
                                                   id="stripePayment">
                                            <label class="form-check-label" for="stripePayment">
                                                <span>
                                                    <span class="font-16 color-heading font-medium me-3">Stripe</span>
                                                    <span class="font-14">{{ __('You will be redirected to the stripe website after submitting your order') }}</span>
                                                </span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('mollie_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="mollie" {{ old('payment_method') == 'mollie' ? 'checked' : '' }}
                                                id="molliePayment">
                                            <label class="form-check-label mb-0" for="molliePayment">
                                                <span class="font-16 color-heading font-medium">Mollie</span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('im_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="instamojo"
                                                {{ old('payment_method') == 'instamojo' ? 'checked' : '' }}
                                                id="instamojoPayment">
                                            <label class="form-check-label mb-0" for="instamojoPayment">
                                                <span class="font-16 color-heading font-medium">Instamojo</span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('razorpay_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="razorpay"
                                                {{ old('payment_method') == 'razorpay' ? 'checked' : '' }}
                                                id="razorpayPayment">
                                            <label class="form-check-label mb-0" for="razorpayPayment">
                                                <span class="font-16 color-heading font-medium">Razorpay</span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('paystack_status') == 1)
                                    <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                        <input class="form-check-input" type="radio" name="payment_method"
                                               value="paystack"
                                               {{ old('payment_method') == 'paystack' ? 'checked' : '' }}
                                               id="paystackPayment">
                                        <label class="form-check-label mb-0" for="paystackPayment">
                                            <span class="font-16 color-heading font-medium">Paystack</span>
                                        </label>
                                    </div>
                                    @endif

                                    @if (get_option('sslcommerz_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="sslcommerz"
                                                {{ old('payment_method') == 'sslcommerz' ? 'checked' : '' }}
                                                id="sslcommerzPayment">
                                            <label class="form-check-label mb-0" for="sslcommerzPayment">
                                                <span class="font-16 color-heading font-medium">SSLCOMMERZ</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if (get_option('mercado_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="mercadopago"
                                                {{ old('payment_method') == 'mercadopago' ? 'checked' : '' }}
                                                id="mercadopagoPayment">
                                            <label class="form-check-label mb-0" for="merPayment">
                                                <span class="font-16 color-heading font-medium">MERCADO PAGO</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if (get_option('flutterwave_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="flutterwave"
                                                {{ old('payment_method') == 'flutterwave' ? 'checked' : '' }}
                                                id="flutterwavePayment">
                                            <label class="form-check-label mb-0" for="merPayment">
                                                <span class="font-16 color-heading font-medium">Flutterwave</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if (get_option('coinbase_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="coinbase"
                                                {{ old('payment_method') == 'coinbase' ? 'checked' : '' }}
                                                id="coinbasePayment">
                                            <label class="form-check-label mb-0" for="coinbasePayment">
                                                <span class="font-16 color-heading font-medium">Coinbase</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if (get_option('zitopay_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="zitopay"
                                                {{ old('payment_method') == 'zitopay' ? 'checked' : '' }}
                                                id="zitopayPayment">
                                            <label class="form-check-label mb-0" for="zitopayPayment">
                                                <span class="font-16 color-heading font-medium">Zitopay</span>
                                            </label>
                                        </div>
                                    @endif
                                    @if (get_option('iyzipay_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="iyzipay"
                                                {{ old('payment_method') == 'iyzipay' ? 'checked' : '' }}
                                                id="iyzipayPayment">
                                            <label class="form-check-label mb-0" for="iyzipayPayment">
                                                <span class="font-16 color-heading font-medium">Iyzico</span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('bitpay_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="bitpay"
                                                {{ old('payment_method') == 'bitpay' ? 'checked' : '' }}
                                                id="bitpayPayment">
                                            <label class="form-check-label mb-0" for="bitpayPayment">
                                                <span class="font-16 color-heading font-medium">Bitpay</span>
                                            </label>
                                        </div>
                                    @endif

                                    @if (get_option('braintree_status') == 1)
                                        <div class="form-check payment-method-card-box other-payment-box pb-0 mt-30">
                                            <input class="form-check-input" type="radio" name="payment_method"
                                                value="braintree"
                                                {{ old('payment_method') == 'braintree' ? 'checked' : '' }}
                                                id="braintreePayment">
                                            <label class="form-check-label mb-0" for="braintreePayment">
                                                <span class="font-16 color-heading font-medium">Braintree</span>
                                            </label>
                                        </div>
                                    @endif

                                    <div class="checkout-we-protect-content d-flex align-items-center mt-30">
                                        <div class="flex-shrink-0">
                                            <span class="iconify color-hover font-24"
                                                data-icon="ant-design:lock-filled"></span>
                                        </div>
                                        <div class="flex-grow-1 ms-2 font-13">
                                            {{ __('We protect your payment information using encryption to provide bank-level security') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="checkout-page-right-part sticky-top">
                                <div class="checkout-right-side-box checkout-order-review-box">
                                    <div class="accordion" id="accordionExample1">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingOne">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseOne" aria-expanded="true"
                                                    aria-controls="collapseOne">
                                                    {{ __('Order Review') }}
                                                </button>
                                            </h2>
                                            <div id="collapseOne" class="accordion-collapse collapse show"
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
                                                <div class="accordion-body">
                                                    <div class="checkout-items-count font-13 color-heading mb-2">
                                                        {{ $carts->count() }} {{ __('Items In Card') }}</div>
                                                    <div class="table-responsive mb-20">
                                                        <table class="table bg-white checkout-table mb-0">
                                                            <tbody>
                                                                @foreach ($carts as $cart)
                                                                    <tr>
                                                                        <td class="checkout-course-item">
                                                                            <div
                                                                                class="card course-item wishlist-item border-0 d-flex align-items-center">
                                                                                <div
                                                                                    class="course-img-wrap overflow-hidden flex-shrink-0">
                                                                                    @if($cart->course_id)
                                                                                        @if(@$cart->course)
                                                                                            <a href="{{ route('course-details', @$cart->course->slug) }}"
                                                                                                target="_blank"><img
                                                                                                    src="{{ getImageFile(@$cart->course->image_path) }}"
                                                                                                    alt="course"
                                                                                                    class="img-fluid"></a>
                                                                                        @endif
                                                                                    @elseif($cart->bundle_id)
                                                                                        @if(@$cart->bundle)
                                                                                            <a href="{{ route('bundle-details', [@$cart->bundle->slug]) }}"
                                                                                               target="_blank"><img
                                                                                                    src="{{ getImageFile(@$cart->bundle->image) }}"
                                                                                                    alt="bundle course"
                                                                                                    class="img-fluid"></a>
                                                                                        @endif
                                                                                    @elseif($cart->consultation_slot_id)
                                                                                        @if(@$cart->consultationSlot)
                                                                                        <a href="{{ route('userProfile', [@$cart->consultationSlot->user->id]) }}"
                                                                                           target="_blank"><img
                                                                                                src="{{ getImageFile(@$cart->consultationSlot->user->image) }}"
                                                                                                alt="bundle course"
                                                                                                class="img-fluid"></a>
                                                                                        @endif
                                                                                    @endif
                                                                                </div>
                                                                                <div class="card-body flex-grow-1">
                                                                                    <h5 class="card-title course-title">
                                                                                        @if($cart->course_id)
                                                                                            @if(@$cart->course)
                                                                                            <a href="{{ route('course-details', @$cart->course->slug) }}" target="_blank">
                                                                                                {{ @$cart->course->title }}</a>
                                                                                            @endif
                                                                                        @elseif($cart->bundle_id)
                                                                                            @if(@$cart->bundle)
                                                                                            <a href="{{ route('bundle-details', [@$cart->bundle->slug]) }}"
                                                                                               target="_blank">{{ @$cart->bundle->name }}</a>
                                                                                            @endif
                                                                                        @elseif($cart->consultation_slot_id)
                                                                                            @if(@$cart->consultationSlot)
                                                                                            <a href="{{ route('userProfile', [@$cart->consultationSlot->user->id]) }}"
                                                                                               target="_blank">{{ $cart->consultationSlot->user->name }}</a>
                                                                                            @endif
                                                                                        @endif
                                                                                    </h5>

                                                                                    @if ($cart->course && $cart->course->instructor)
                                                                                        <p class="card-text instructor-name-certificate font-medium">
                                                                                            {{ $cart->course->instructor->name }}
                                                                                        </p>
                                                                                    @elseif($cart->bundle && $cart->bundle->user->instructor)
                                                                                        <p class="card-text instructor-name-certificate font-medium">
                                                                                            {{ $cart->bundle->user->instructor->name }}
                                                                                        </p>
                                                                                    @elseif($cart->consultation_slot_id)
                                                                                        <p class="card-text instructor-name-certificate font-medium">
                                                                                            (Consultation)
                                                                                        </p>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td
                                                                            class="wishlist-price font-13 color-heading text-end">
                                                                            <div class="wishlist-remove font-13">
                                                                                @if (get_currency_placement() == 'after')
                                                                                    {{ get_number_format(@$cart->price, 2) }}
                                                                                    {{ get_currency_symbol() }}
                                                                                @else
                                                                                    {{ get_currency_symbol() }}
                                                                                    {{ get_number_format(@$cart->price, 2) }}
                                                                                @endif
                                                                            </div>
                                                                            <div>

                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="checkout-right-side-box checkout-billing-summary-box">

                                    <div class="accordion" id="accordionExample3">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseThree" aria-expanded="true"
                                                    aria-controls="collapseThree">
                                                    {{ __('Billing Summary') }}
                                                </button>
                                            </h2>
                                            <div id="collapseThree" class="accordion-collapse collapse show"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample3">
                                                <div class="accordion-body">
                                                    <table class="table billing-summary-table">
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ __('Subtotal') }}</td>
                                                                <td>
                                                                    @if (get_currency_placement() == 'after')
                                                                        {{ get_number_format($carts->sum('price')) }}
                                                                        {{ get_currency_symbol() }}
                                                                    @else
                                                                        {{ get_currency_symbol() }}
                                                                        {{ get_number_format($carts->sum('price')) }}
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>{{ __('Discount') }}</td>
                                                                <td>-

                                                                    @if (get_currency_placement() == 'after')
                                                                        {{ get_number_format($carts->sum('discount')) }}
                                                                        {{ get_currency_symbol() }}
                                                                    @else
                                                                        {{ get_currency_symbol() }}
                                                                        {{ get_number_format($carts->sum('discount')) }}
                                                                    @endif

                                                                </td>
                                                            </tr>
                                                            @if($carts->sum('shipping_charge') > 0)
                                                            <tr>
                                                                <td>{{ __('Shipping Charge') }} </td>
                                                                <td>
                                                                    @if (get_currency_placement() == 'after')
                                                                        {{ get_number_format($carts->sum('shipping_charge')) }}
                                                                        {{ get_currency_symbol() }}
                                                                    @else
                                                                        {{ get_currency_symbol() }}
                                                                        {{ get_number_format($carts->sum('shipping_charge')) }}
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            @endif
                                                            <tr>
                                                                <td>{{ __('Platform Charge') }} </td>
                                                                <td>
                                                                    @if (get_currency_placement() == 'after')
                                                                        {{ get_platform_charge($carts->sum('price')+$carts->sum('shipping_charge')) }}
                                                                        {{ get_currency_symbol() }}
                                                                    @else
                                                                        {{ get_currency_symbol() }}
                                                                        {{ get_platform_charge($carts->sum('price')+$carts->sum('shipping_charge')) }}
                                                                    @endif
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="col">{{ __('Grand Total') }}</th>
                                                                <th scope="col">
                                                                    @if (get_currency_placement() == 'after')
                                                                        <span
                                                                            class="grand_total">{{ get_number_format($carts->sum('price') + $carts->sum('shipping_charge') + get_platform_charge($carts->sum('shipping_charge')+$carts->sum('price'))) }}</span>
                                                                        {{ get_currency_symbol() }}
                                                                    @else
                                                                        {{ get_currency_symbol() }} <span
                                                                            class="grand_total">{{ get_number_format($carts->sum('price') + $carts->sum('shipping_charge') + get_platform_charge($carts->sum('shipping_charge')+$carts->sum('price'))) }}</span>
                                                                    @endif
                                                                </th>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                    <table class="table billing-summary-table">
                                                        <tbody>
                                                            <tr>
                                                                <td>{{ __('Conversion Rate') }} </td>
                                                                <td>
                                                                    1 {{ get_currency_symbol() }} =
                                                                    <span class="selected_conversation_rate">?</span> <span
                                                                        class="selected_currency"></span>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="col">In<span
                                                                        class="ms-1 gateway_calculated_rate_currency"></span>
                                                                </th>
                                                                <th scope="col" class="gateway_calculated_rate_price">
                                                                </th>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <div class="row mb-30">
                                                        <div class="col-md-12">
                                                            <div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" id="flexCheckChecked" checked>
                                                                    <label class="form-check-label mb-0"
                                                                        for="flexCheckChecked">
                                                                        Por favor, marca esta casilla para confirmar que aceptas nuestra <a
                                                                            href="{{ route('privacy-policy') }}" target="_blank" rel="noopener"
                                                                            class="color-hover text-decoration-underline">Política de Privacidad y Términos</a>
                                                                    </label>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="row mb-30">
                                                        @if (env('APP_DEMO') == 'active')
                                                            <div class="col-md-12">
                                                                <div class="">
                                                                    <button type="button"
                                                                        class="theme-btn theme-button1 theme-button3 font-15 fw-bold w-100 appDemo">
                                                                        {{ __('Pay') }}
                                                                        <span
                                                                            class="ms-1  gateway_calculated_rate_price"></span><span
                                                                            class="ms-1 gateway_calculated_rate_currency"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <div class="sslcz-btn d-none">
                                                                    <input type="hidden" name="">
                                                                    <button
                                                                        class="your-button-class theme-btn theme-button1 theme-button3 font-15 fw-bold w-100"
                                                                        id="sslczPayBtn"
{{--                                                                        token="if you have any token validation"--}}
                                                                        postdata="your javascript arrays or objects which requires in backend"
{{--                                                                        order="If you already have the transaction generated for current order"--}}
{{--                                                                        endpoint="/student/pay-via-sslcommerz"--}}
                                                                    >
                                                                        {{ __('Pay') }}
                                                                        {{ @$sslcommerz_grand_total_with_conversion_rate }}
                                                                        {{ get_option('sslcommerz_currency') }}
                                                                    </button>
                                                                </div>

                                                                <div class="regular-btn">
                                                                    <button type="submit"
                                                                        id="payment-button"
                                                                        class="theme-btn theme-button1 theme-button3 font-15 fw-bold w-100 ">
                                                                        {{ __('Pay') }}
                                                                        <span
                                                                            class="ms-1  gateway_calculated_rate_price"></span><span
                                                                            class="ms-1 gateway_calculated_rate_currency"></span>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @php
                    $razorpay_pay_amount = $razorpay_grand_total_with_conversion_rate * 100;
                    $orderId = rand();
                @endphp


                <div class="d-none">
                    <form action="{{ route('student.razorpay_payment') }}" method="POST" id="razorpay_payment">
                        @csrf
                        <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZORPAY_KEY') }}"
                            data-amount="{{ $razorpay_pay_amount }}" data-buttontext="Pay" data-name="{{ get_option('app_name') }}"
                            data-description="Buy Course" data-prefill.name="name" data-prefill.email="email" data-theme.color="#0000FF">
                        </script>
                    </form>
                </div>

                <div class="d-none">
                    <form action="{{ route('student.pay') }}" method="POST" id="paystack_payment">
                        @csrf
                        <input type="hidden" name="callback_url" value="{{ route('student.paystack_payment.callback') }}">
                        <input type="hidden" name="orderID" value="{{ $orderId }}">
                        <input type="hidden" name="metadata" value="{{ json_encode($array = ['orderID' => $orderId]) }}" >

                        <input type="hidden" name="email" value="{{Auth::user()->email}}"> {{-- required --}}
                        <input type="hidden" name="amount" value="{{$paystack_grand_total_with_conversion_rate * 100}}"> {{-- required in kobo --}}
                        <input type="hidden" name="currency" value="NGN">
                        {{--<input type="hidden" name="reference" value="{{ Paystack::genTranxRef() }}">--}}
                        <input type="hidden" name="payment_method" value="paystack">
                        {{ csrf_field() }}
                    </form>
                </div>

            </div>
        </section>
        <!-- Cart Page Area End -->
    </div>
    <input type="hidden" class="paypal_currency" value="{{ get_option('paypal_currency') }}">
    <input type="hidden" class="paypal_conversion_rate" value="{{ get_option('paypal_conversion_rate') }}">

    <input type="hidden" class="bank_currency" value="{{ get_option('bank_currency') }}">
    <input type="hidden" class="bank_conversion_rate" value="{{ get_option('bank_conversion_rate') }}">

    <input type="hidden" class="stripe_currency" value="{{ get_option('stripe_currency') }}">
    <input type="hidden" class="stripe_conversion_rate" value="{{ get_option('stripe_conversion_rate') }}">

    <input type="hidden" class="openpay_currency" value="{{ get_option('openpay_currency') }}">
    <input type="hidden" class="openpay_conversion_rate" value="{{ get_option('openpay_conversion_rate') }}">

    <input type="hidden" class="razorpay_currency" value="{{ get_option('razorpay_currency') }}">
    <input type="hidden" class="razorpay_conversion_rate" value="{{ get_option('razorpay_conversion_rate') }}">

    <input type="hidden" class="instamojo_currency" value="{{ get_option('im_currency') }}">
    <input type="hidden" class="instamojo_conversion_rate" value="{{ get_option('im_conversion_rate') }}">

    <input type="hidden" class="mollie_currency" value="{{ get_option('mollie_currency') }}">
    <input type="hidden" class="mollie_conversion_rate" value="{{ get_option('mollie_conversion_rate') }}">

    <input type="hidden" class="sslcommerz_currency" value="{{ get_option('sslcommerz_currency') }}">
    <input type="hidden" class="sslcommerz_conversion_rate" value="{{ get_option('sslcommerz_conversion_rate') }}">

    <input type="hidden" class="mercado_currency" value="{{ get_option('mercado_currency') }}">
    <input type="hidden" class="mercado_conversion_rate" value="{{ get_option('mercado_conversion_rate') }}">

    <input type="hidden" class="flutterwave_currency" value="{{ get_option('flutterwave_currency') }}">
    <input type="hidden" class="flutterwave_conversion_rate" value="{{ get_option('flutterwave_conversion_rate') }}">

    <input type="hidden" class="paystack_currency" value="{{ get_option('paystack_currency') }}">
    <input type="hidden" class="paystack_conversion_rate" value="{{ get_option('paystack_conversion_rate') }}">

    <input type="hidden" class="coinbase_currency" value="{{ get_option('coinbase_currency') }}">
    <input type="hidden" class="coinbase_conversion_rate" value="{{ get_option('coinbase_conversion_rate') }}">

    <input type="hidden" class="zitopay_currency" value="{{ get_option('zitopay_currency') }}">
    <input type="hidden" class="zitopay_conversion_rate" value="{{ get_option('zitopay_conversion_rate') }}">

    <input type="hidden" class="iyzipay_currency" value="{{ get_option('iyzipay_currency') }}">
    <input type="hidden" class="iyzipay_conversion_rate" value="{{ get_option('iyzipay_conversion_rate') }}">

    <input type="hidden" class="bitpay_currency" value="{{ get_option('bitpay_currency') }}">
    <input type="hidden" class="bitpay_conversion_rate" value="{{ get_option('bitpay_conversion_rate') }}">

    <input type="hidden" class="braintree_currency" value="{{ get_option('braintree_currency') }}">
    <input type="hidden" class="braintree_conversion_rate" value="{{ get_option('braintree_conversion_rate') }}">

    <input type="hidden" class="fetchBankRoute" value="{{ route('student.fetchBank') }}">
@endsection

@push('script')

    @if (get_option('sslcommerz_mode') == 'live')
        <script>
            var obj = {};
            obj.cus_name = $('#first_name').val() + $('#last_name').val();
            obj.cus_phone = $('#phone_number').val();
            obj.cus_email = $('#email').val();
            obj.cus_addr1 = $('#address').val();
            obj.postal_code = $('#postal_code').val();

            $('#sslczPayBtn').prop('postdata', obj);
            (function(window, document) {
                var loader = function() {
                    var script = document.createElement("script"),
                        tag = document.getElementsByTagName("script")[0];
                    script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36)
                        .substring(7); // USE THIS FOR LIVE
                    tag.parentNode.insertBefore(script, tag);
                };
                window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
                    loader);
            })(window, document);
        </script>
    @else
        <script>
            var obj = {};
            obj.cus_name = $('#first_name').val() + $('#last_name').val();
            obj.cus_phone = $('#phone_number').val();
            obj.cus_email = $('#email').val();
            obj.cus_addr1 = $('#address').val();
            obj.postal_code = $('#postal_code').val();
            obj.country_name = $('#country_name').val();

            // $('#sslczPayBtn').prop('postdata', obj);
            // (function(window, document) {
            //     var loader = function() {
            //         var script = document.createElement("script"),
            //             tag = document.getElementsByTagName("script")[0];
            //         script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(
            //             7); // USE THIS FOR SANDBOX
            //         tag.parentNode.insertBefore(script, tag);
            //     };
            //     console.log(loader);
            //     window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload",
            //         loader);
            // })(window, document);
        </script>
    @endif

    <!-- OPENPAY INTEGRATION -->
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay-data.v1.min.js"></script>

    <script>
        OpenPay.setId('{{ env("OPENPAY_MERCHANT_ID") }}');
        OpenPay.setApiKey('{{ env("OPENPAY_PUBLIC_KEY") }}');
        OpenPay.setSandboxMode({{ env("OPENPAY_PRODUCTION_MODE") == false}});
        OpenPay.deviceData.setup("payment-form", "device_session_id");
    </script>
    <script src="{{ asset('frontend/assets/js/custom/student-profile.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom/checkout.js') }}"></script>
@endpush
