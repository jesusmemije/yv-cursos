<?php

namespace App\Http\Services\Payment;

use Openpay;

class OpenPayService extends BasePaymentService
{
    public $openPayClient;
    public $orderId;
    public $currency;
    public $is3dSecureEnabled;

    public function __construct($object)
    {
        $this->openPayClient = Openpay::getInstance(
            env("OPENPAY_MERCHANT_ID"),
            env("OPENPAY_PRIVATE_KEY")
        );
        Openpay::setProductionMode(env("OPENPAY_PRODUCTION_MODE"));
        $this->is3dSecureEnabled = env("OPENPAY_3D_SECURE_ENABLED");
        $this->orderId = $object['id'];
        $this->currency = $object['currency'];
    }

    public function makePayment($amount, $post_data = null)
    {
        $data = [
            'success' => false,
            'redirect_url' => '',
            'payment_id' => '',
            'message' => ''
        ];

        $chargeData = [
            'method' => 'card',
            'source_id' => $post_data['token_id'],
            'amount' => $amount,
            'currency' => $this->currency,
            'description' => 'Payment',
            'device_session_id' => $post_data['device_session_id'],
            'order_id' => $this->orderId,
        ];

        // Si 3D Secure está habilitado, agregar `use_3d_secure` y `redirect_url`
        if ($this->is3dSecureEnabled) {
            $chargeData['use_3d_secure'] = true;
            $chargeData['redirect_url'] = route('paymentNotify', $this->orderId);
        }

        try {
            $customer = $this->openPayClient->customers->add($post_data['customer']);
            $customerId = $customer->id;
            $customer = $this->openPayClient->customers->get($customerId);
            $charge = $customer->charges->create($chargeData);

            // Si 3D Secure está habilitado y Openpay devuelve una URL de autenticación
            if ($this->is3dSecureEnabled && isset($charge->payment_method->url)) {
                $data['redirect_url'] = $charge->payment_method->url; // URL a la que el usuario debe ser redirigido
            } else {
                $data['redirect_url'] = route('paymentNotify', $this->orderId);
            }

            $data['success'] = true;
            $data['payment_id'] = $charge->id;
            $data['message'] = $charge->status;
            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id, $payer_id = null)
    {
        $data = ['data' => null];
        try {
            $payment = $this->openPayClient->charges->get($payment_id);
            
            if ($payment->status == 'completed') {
                $data['success'] = true;
                $data['data'] = [
                    'amount' => $payment->serializableData["amount"],
                    'currency' => $payment->currency,
                    'payment_status' => 'success',
                    'payment_method' => 'OPENPAY'
                ];
            } else {
                $data['success'] = false;
                $data['data'] = [
                    'amount' => $payment->serializableData["amount"],
                    'currency' => $payment->currency,
                    'payment_status' => 'unpaid',
                    'payment_method' => 'OPENPAY'
                ];
            }
        } catch (\Exception $ex) {
            $data['success'] = false;
            $data['message'] = $ex->getMessage();
        }

        return $data;
    }
}
