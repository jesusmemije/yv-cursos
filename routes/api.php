<?php

use App\Http\Controllers\Api\PaymentConfirmController;
use Illuminate\Support\Facades\Route;

Route::match(['GET', 'POST'], '/payment-order-notify/{id}', [PaymentConfirmController::class, 'paymentOrderNotifier'])
    ->name('api.payment-order-notify');

Route::match(['GET', 'POST'], '/payment-cancel', [PaymentConfirmController::class, 'paymentCancel'])
    ->name('api.payment-cancel');

