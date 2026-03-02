<?php


namespace App\Http\Services\Payment;



class MarcadoPagoService
{
    private $successUrl ;
    private $cancelUrl ;
    private $currency ;
    private $order_id ;
    private $access_token ;

    public function __construct($object)
    {
        if(isset($object['id'])){
            $defaultCancelUrl = $this->buildPublicRoute('paymentCancel', $object['id']);
            $defaultSuccessUrl = $this->buildPublicRoute('paymentNotify', $object['id']);

            $providedCancelUrl = isset($object['cancelUrl']) ? trim((string) $object['cancelUrl']) : '';
            if ($providedCancelUrl === '' && isset($object['cancelUrl '])) {
                $providedCancelUrl = trim((string) $object['cancelUrl ']);
            }

            $providedSuccessUrl = isset($object['successUrl']) ? trim((string) $object['successUrl']) : '';

            $this->cancelUrl = $providedCancelUrl !== '' ? $providedCancelUrl : $defaultCancelUrl;
            $this->successUrl = $providedSuccessUrl !== '' ? $providedSuccessUrl : $defaultSuccessUrl;
            $this->order_id = $object['id'];
        }

        $this->currency = strtoupper($object['currency']);
        $this->access_token = env('MERCADO_PAGO_ACCESS_TOKEN');
    }
    protected function setAccessToken(){
        if (empty($this->access_token)) {
            throw new \Exception(__('Mercado Pago access token is missing'));
        }
        return \MercadoPago\SDK::setAccessToken($this->access_token);
    }
    public function makePayment($price){
        $data['success'] = false;
        $data['redirect_url'] = '';
        $data['payment_id'] = '';
        $data['message'] = '';
        try {
            $order_id =  $this->order_id;
            $this->verify_currency();
            $this->validateTokenAgainstMode();
            $this->setAccessToken();
            $preference = new \MercadoPago\Preference();

            $item = new \MercadoPago\Item();
            $item->id = $order_id;
            $item->title = "Order #".$order_id;
            $item->quantity = 1;
            $item->unit_price = (float)$price;

            $preference->items = array($item);
            $preference->external_reference = (string)$order_id;

            $successUrl = trim((string) $this->successUrl);
            $cancelUrl = trim((string) $this->cancelUrl);
            if (!$this->isValidBackUrl($successUrl)) {
                throw new \Exception(__('Mercado Pago success URL is invalid. Please configure APP_URL with a public URL'));
            }
            if ($this->isLocalBackUrl($successUrl)) {
                throw new \Exception(__('Mercado Pago success URL cannot use localhost/127.0.0.1. Use a public URL (for example ngrok)'));
            }
            if (!$this->isValidBackUrl($cancelUrl)) {
                $cancelUrl = $successUrl;
            }

            $preference->back_urls = array(
                "success" => $successUrl,
                "failure" => $cancelUrl,
                "pending" => $successUrl
            );
            // Webhook fallback so orders can be updated even if user does not return manually.
            $preference->notification_url = $successUrl;
            // Instant-only checkout: force binary result and block offline/pending payment flows.
            $preference->binary_mode = true;
            $preference->payment_methods = array(
                "excluded_payment_types" => array(
                    array("id" => "ticket"),
                    array("id" => "atm"),
                    array("id" => "bank_transfer"),
                ),
            );
            $preference->auto_return = "approved";
            $preference->metadata = array(
                "order_id" => $order_id,
            );

            $saved = $preference->save();
            if (!$saved) {
                $errorMessage = $this->getPreferenceErrorMessage($preference);
                throw new \Exception($errorMessage);
            }

            $savedSuccessUrl = '';
            $savedAutoReturn = '';
            if (!empty($preference->back_urls) && is_object($preference->back_urls)) {
                $savedSuccessUrl = trim((string)($preference->back_urls->success ?? ''));
            }
            $savedAutoReturn = trim((string)($preference->auto_return ?? ''));

            if ($savedSuccessUrl === '' || strtolower($savedAutoReturn) !== 'approved') {
                throw new \Exception(__('Mercado Pago preference was created without back_urls/auto_return. Configure a public APP_URL (not localhost) and verify account credentials.'));
            }

            // Checkout Pro should use init_point in both test and production.
            // sandbox_init_point is kept only as legacy fallback.
            $redirectUrl = !empty($preference->init_point)
                ? $preference->init_point
                : $preference->sandbox_init_point;

            if (empty($redirectUrl)) {
                throw new \Exception(__('Mercado Pago did not return a redirect URL'));
            }

            $data['redirect_url'] = $redirectUrl;
            $data['payment_id'] = $preference->id;
            $data['success'] = true;
            return $data;
        } catch (\Exception $ex) {
            $data['message'] = $ex->getMessage();
            return $data;
        }
    }

    public function paymentConfirmation($payment_id)
    {

        $data['success'] = false;
        $data['data'] = null;
        $data['message'] = '';
        try {
            $this->validateTokenAgainstMode();
            $this->setAccessToken();
            $payment = null;
            $resolvedPaymentId = null;

            if ($this->isValidPaymentId($payment_id)) {
                $resolvedPaymentId = trim((string)$payment_id);
                $payment = \MercadoPago\Payment::find_by_id($resolvedPaymentId);
            }

            if (is_null($payment)) {
                $payment = $this->findPaymentByExternalReference();
                if (!is_null($payment) && $this->isValidPaymentId($payment->id ?? null)) {
                    $resolvedPaymentId = trim((string)$payment->id);
                }
            }

            if (!is_null($payment) && $payment->status == 'approved') {
                $data['success'] = true;
                $data['data']['payment_id'] = $resolvedPaymentId;
                $data['data']['amount'] = $payment->transaction_amount;
                $data['data']['currency'] = !empty($payment->currency_id) ? $payment->currency_id : $this->currency;
                $data['data']['payment_status'] =  'success' ;
                $data['data']['payment_method'] = MERCADOPAGO;
            } else{
                $data['success'] = false;
                $data['data']['currency'] = $this->currency;
                $data['data']['payment_status'] =  'unpaid' ;
                $data['data']['payment_method'] = MERCADOPAGO;
                if (is_null($resolvedPaymentId)) {
                    $data['message'] = __('Unable to resolve Mercado Pago payment id');
                }
            }
        } catch (\Exception $ex) {
            $data['data']['currency'] = $this->currency;
            $data['data']['payment_status'] = 'unpaid';
            $data['data']['payment_method'] = MERCADOPAGO;
            $data['message'] = $ex->getMessage();
        }


        return $data;
    }

    public function verify_currency()
    {
        if (in_array($this->currency, $this->supported_currency_list(), true)){
            return true;
        }
        return throw new \Exception($this->currency.__(' is not supported by '.$this->gateway_name()));

    }

    public function supported_currency_list()
    {
        return ['ARS', 'BRL', 'CLP', 'COP', 'MXN', 'PEN', 'UYU', 'USD'];
    }


    public function gateway_name()
    {
        return 'mercadopago';
    }

    protected function isValidPaymentId($payment_id)
    {
        if (is_null($payment_id)) {
            return false;
        }

        $payment_id = trim((string)$payment_id);
        if ($payment_id === '' || $payment_id === '-1') {
            return false;
        }

        return preg_match('/^\d+$/', $payment_id) === 1;
    }

    protected function isValidBackUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    protected function isLocalBackUrl($url)
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        return in_array($host, ['localhost', '127.0.0.1', '::1'], true);
    }

    protected function buildPublicRoute($routeName, $id)
    {
        $relativePath = route($routeName, $id, false);
        $baseUrl = rtrim((string) config('app.url'), '/');
        if ($baseUrl === '') {
            return route($routeName, $id);
        }

        return $baseUrl.'/'.ltrim($relativePath, '/');
    }

    protected function validateTokenAgainstMode()
    {
        $token = trim((string) $this->access_token);
        if ($token === '') {
            throw new \Exception(__('Mercado Pago access token is missing'));
        }

        $isAllowedPrefix = stripos($token, 'TEST-') === 0 || stripos($token, 'APP_USR-') === 0;
        if (!$isAllowedPrefix) {
            throw new \Exception(__('Mercado Pago access token format is invalid'));
        }
    }

    protected function getPreferenceErrorMessage($preference)
    {
        $errorMessage = 'Mercado Pago preference creation failed';
        $error = null;

        if (method_exists($preference, 'getError')) {
            $error = $preference->getError();
        } elseif (method_exists($preference, 'Error')) {
            $error = $preference->Error();
        }

        if (is_null($error)) {
            return $errorMessage;
        }

        $main = trim(($error->error ?? '').' '.($error->message ?? ''));
        if ($main === '' && !empty($error->status)) {
            $main = 'HTTP '.$error->status;
        }

        $causes = '';
        if (!empty($error->causes) && is_array($error->causes)) {
            $causeParts = [];
            foreach ($error->causes as $cause) {
                $desc = is_object($cause) ? ($cause->description ?? null) : null;
                if (!empty($desc)) {
                    $causeParts[] = $desc;
                }
            }
            if (!empty($causeParts)) {
                $causes = ' | '.implode(' ; ', $causeParts);
            }
        }

        $detailed = trim($main.$causes);
        return $detailed !== '' ? $detailed : $errorMessage;
    }

    protected function findPaymentByExternalReference()
    {
        if (empty($this->order_id)) {
            return null;
        }

        $payments = \MercadoPago\Payment::search([
            'external_reference' => (string)$this->order_id,
            'sort' => 'date_created',
            'criteria' => 'desc',
            'limit' => 10,
        ]);

        if (is_null($payments) || count($payments) === 0) {
            return null;
        }

        foreach ($payments as $payment) {
            if (!is_null($payment) && ($payment->status ?? null) === 'approved') {
                return $payment;
            }
        }

        return $payments[0] ?? null;
    }
}
