<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Logger;
use App\Http\Services\Payment\BasePaymentService;
use App\Models\Addon\Product\Product;
use App\Models\CartManagement;
use App\Models\Order;
use App\Models\Package;
use App\Models\Payment;
use App\Models\UserPackage;
use App\Models\WalletRecharge;
use App\Traits\General;
use App\Traits\ImageSaveTrait;
use App\Traits\SendNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentApiController extends Controller
{
    use ImageSaveTrait, General, SendNotification;
    protected $logger;

    public function __construct()
    {
        $this->logger = new Logger();
    }
    public function paymentNotifier(Request $request, $id)
    {
        if ($this->isMercadoMerchantOrderWebhook($request)) {
            return response('ok', 200);
        }

        $payment_id = $request->input('paymentId', '-1');
        $payer_id = $request->input('PayerID', '-1');
        $mercado_payment_id = $this->extractMercadoPagoPaymentId($request);
        $this->logger->log('Payment Start', '==========');
        $this->logger->log('Payment paymentId', $payment_id);
        $this->logger->log('Payment PayerID', $payer_id);
        $order = Order::where('uuid', $id)->first();
        if (is_null($order)) {
            $this->showToastrMessage('error', __(SWR));
            return redirect()->route('student.cartList');
        }
        if ($order->payment_status === 'paid') {
            $this->showToastrMessage('success', __('Payment has been completed'));
            return redirect()->route('student.thank-you');
        }
        if ($order->payment_status !== ORDER_PAYMENT_STATUS_DUE) {
            $this->showToastrMessage('error', __(SWR));
            return redirect()->route('student.cartList');
        }
        Log::info($order);

        if($order->payment_method == MERCADOPAGO){
            if (!is_null($mercado_payment_id)) {
                $order->payment_id = $mercado_payment_id;
                $order->save();
            }
        }

        $this->logger->log('Payment verify request : ', json_encode($request->all()));

        $payment_id = $order->payment_id;
        $data = ['id' => $order->uuid, 'payment_method' => getPaymentMethodId($order->payment_method), 'currency' => $order->payment_currency];
        $getWay = new BasePaymentService($data);
        
        if ($payer_id != '-1') {
            $payment_data = $getWay->paymentConfirmation($payment_id, $payer_id);
        } else if ($order->payment_method == IYZIPAY) {
            $payment_data = $getWay->paymentConfirmation($payment_id, $request->token);
        } else if ($order->payment_method == OPENPAY) {
            $payment_data = $getWay->paymentConfirmation($payment_id, $order->id);
        }
         else {
            $payment_data = $getWay->paymentConfirmation($payment_id);
        }

        $this->logger->log('Payment done for order', json_encode($order));
        $this->logger->log('Payment details', json_encode($payment_data));

        if ($payment_data['success']) {
            if ($payment_data['data']['payment_status'] == 'success') {
                $paymentJustProcessed = false;
                DB::beginTransaction();
                try {
                    $lockedOrder = Order::where('id', $order->id)->lockForUpdate()->first();
                    if (is_null($lockedOrder)) {
                        throw new \Exception(__('Order not found during payment confirmation'));
                    }
                    if ($lockedOrder->payment_status === 'paid') {
                        $order = $lockedOrder;
                        $this->logger->log('status', 'already_paid');
                    } else {
                        if ($lockedOrder->payment_method == MERCADOPAGO && !empty($payment_data['data']['payment_id'])) {
                            $lockedOrder->payment_id = (string)$payment_data['data']['payment_id'];
                        }
                        $lockedOrder->payment_status = 'paid';
                        $lockedOrder->payment_method = $payment_data['data']['payment_method'];
                        $lockedOrder->save();
                        $this->logger->log('status', 'paid');

                        /* Start:: Create transaction, affiliate history, user balance increment/decrement */
                        distributeCommission($lockedOrder);
                        /* End:: Create transaction, affiliate history, user balance increment/decrement */
                        $paymentJustProcessed = true;
                        $order = $lockedOrder;
                    }

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->logger->log('End with Exception', $e->getMessage());
                }
                if (!$paymentJustProcessed) {
                    $this->showToastrMessage('success', __('Payment has been completed'));
                    return redirect()->route('student.thank-you');
                }

                CartManagement::whereUserId($order->user_id)->delete();
                $text = __("New student enrolled");
                $target_url = route('instructor.all-student');
                foreach ($order->items as $item) {
                    if ($item->course) {
                        $this->send($text, 2, $target_url, $item->course->user_id);
                    }
                    elseif(!is_null($item->product_id)){
                        Product::where('id', $item->product_id)->decrement('quantity', $item->unit);

                        $text = __("Your have purchase product.");
                        $target_url = route('lms_product.student.purchase_list');
        
                        /** ====== Send notification to instructor =========*/
                        $text2 = "New product sold";
                        $target_url2 = route('lms_product.instructor.product.my-product');
                        $this->send($text2, 2, $target_url2, @$item->product->user_id);
                        /** ====== Send notification to instructor =========*/
        
                    } else {
                        $text = __("Your bank payment has been cancelled.");
                        $target_url = route('lms_product.student.purchase_list');
                        $this->send($text, 3, $target_url, $order->user_id);
                    }
            
                }

                $text = __("Item has been sold");
                $this->send($text, 1, null, null);
                $this->showToastrMessage('success', __('Payment has been completed'));
                return redirect()->route('student.thank-you');
            }
        }

        $this->showToastrMessage('error', __('Payment has been declined'));
        return redirect()->route('main.index');
    }

    public function paymentSubscriptionNotifier(Request $request, $id)
    {
        if ($this->isMercadoMerchantOrderWebhook($request)) {
            return response('ok', 200);
        }

        $payment_id = $request->input('paymentId', '-1');
        $payer_id = $request->input('PayerID', '-1');
        $mercado_payment_id = $this->extractMercadoPagoPaymentId($request);
        $this->logger->log('Payment Start', '==========');
        $this->logger->log('Payment paymentId', $payment_id);
        $this->logger->log('Payment PayerID', $payer_id);
        $order = Payment::where('uuid', $id)->first();
        if (is_null($order)) {
            $this->showToastrMessage('error', SWR);
            return redirect()->route('main.index');
        }
        if ($order->payment_status === 'paid') {
            $this->showToastrMessage('success', __('Payment has been completed'));
            return redirect()->route('subscription.thank-you');
        }
        if ($order->payment_status !== ORDER_PAYMENT_STATUS_DUE) {
            $this->showToastrMessage('error', SWR);
            return redirect()->route('main.index');
        }

        if ($order->payment_method == MERCADOPAGO && !is_null($mercado_payment_id)) {
            $order->payment_id = $mercado_payment_id;
            $order->save();
        }

        $payment_id = $order->payment_id;
        $data = ['id' => $order->uuid, 'payment_method' => getPaymentMethodId($order->payment_method), 'currency' => $order->payment_currency];
        $getWay = new BasePaymentService($data);
        if ($payer_id != '-1') {
            $payment_data = $getWay->paymentConfirmation($payment_id, $payer_id);
        } else {
            $payment_data = $getWay->paymentConfirmation($payment_id);
        }

        $this->logger->log('s-Payment done for order', json_encode($order));
        $this->logger->log('s-Payment details', json_encode($payment_data));

        if ($payment_data['success']) {
            if ($payment_data['data']['payment_status'] == 'success') {
                DB::beginTransaction();
                try {
                    if ($order->payment_method == MERCADOPAGO && !empty($payment_data['data']['payment_id'])) {
                        $order->payment_id = (string)$payment_data['data']['payment_id'];
                    }
                    $order->payment_status = 'paid';
                    $order->payment_method = $payment_data['data']['payment_method'];
                    $order->save();

                    //add to user package from here
                    $months = ($request->subscription_type) ? 1 : 12;
                    $userPackageData = json_decode($order->payment_details, true);
                    $userPackageData['payment_id'] = $order->id;
                    $userPackageData['enroll_date'] = now();
                    $userPackageData['expired_date'] = Carbon::now()->addMonths($months);
                    $package = Package::where('id', $userPackageData['package_id'])->first();
                    UserPackage::join('packages', 'packages.id', '=', 'user_packages.package_id')->where('package_type', $package->package_type)->where('user_packages.user_id', auth()->id())->where('user_packages.status', PACKAGE_STATUS_ACTIVE)->whereDate('enroll_date', '<=', now())->whereDate('expired_date', '>=', now())->update(['user_packages.status' => PACKAGE_STATUS_CANCELED]);
                    UserPackage::create($userPackageData);

                    $this->logger->log('status', 'paid');

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->logger->log('End with Exception', $e->getMessage());
                }

                /** ====== Send notification =========*/
                $text = __("Subscription purchase completed");
                $this->send($text, 3, null , auth()->id());

                $text = __("Subscription has been sold");
                $package_id = json_decode($order->payment_details, true)['package_id'];
                $package = Package::whereId($package_id)->first();
                $target_url = ($package->package_type == PACKAGE_TYPE_SUBSCRIPTION) ? route('admin.subscriptions.purchase_pending_list') : route('admin.saas.purchase_pending_list');
                $this->send($text, 1, $target_url, null);
                /** ====== Send notification =========*/

                $this->showToastrMessage('success', __('Payment has been completed'));
                return redirect()->route('subscription.thank-you');
            }
        }

        $this->showToastrMessage('error', __('Payment has been declined'));
        return redirect()->route('main.index');
    }
   
    public function paymentWalletRechargeNotifier(Request $request, $id)
    {
        if ($this->isMercadoMerchantOrderWebhook($request)) {
            return response('ok', 200);
        }

        $payment_id = $request->input('paymentId', '-1');
        $payer_id = $request->input('PayerID', '-1');
        $mercado_payment_id = $this->extractMercadoPagoPaymentId($request);
        $this->logger->log('Payment Start', '==========');
        $this->logger->log('Payment paymentId', $payment_id);
        $this->logger->log('Payment PayerID', $payer_id);
        $order = Payment::where('uuid', $id)->first();
        if (is_null($order)) {
            $this->showToastrMessage('error', SWR);
            return redirect()->route('main.index');
        }
        if ($order->payment_status === 'paid') {
            $this->showToastrMessage('success', __('Payment has been completed'));
            return redirect()->route('wallet_recharge.thank-you');
        }
        if ($order->payment_status !== ORDER_PAYMENT_STATUS_DUE) {
            $this->showToastrMessage('error', SWR);
            return redirect()->route('main.index');
        }

        if ($order->payment_method == MERCADOPAGO && !is_null($mercado_payment_id)) {
            $order->payment_id = $mercado_payment_id;
            $order->save();
        }

        $payment_id = $order->payment_id;
        $data = ['id' => $order->uuid, 'payment_method' => getPaymentMethodId($order->payment_method), 'currency' => $order->payment_currency];
        $getWay = new BasePaymentService($data);
        if ($payer_id != '-1') {
            $payment_data = $getWay->paymentConfirmation($payment_id, $payer_id);
        } else {
            $payment_data = $getWay->paymentConfirmation($payment_id);
        }

        $this->logger->log('s-Payment done for order', json_encode($order));
        $this->logger->log('s-Payment details', json_encode($payment_data));

        if ($payment_data['success']) {
            if ($payment_data['data']['payment_status'] == 'success') {
                DB::beginTransaction();
                try {
                    if ($order->payment_method == MERCADOPAGO && !empty($payment_data['data']['payment_id'])) {
                        $order->payment_id = (string)$payment_data['data']['payment_id'];
                    }
                    $order->payment_status = 'paid';
                    $order->payment_method = $payment_data['data']['payment_method'];
                    $order->save();

                    //add to wallet_recharge
                    $walletRecharge = WalletRecharge::create([
                        'payment_id' => $order->id,
                        'amount' => $order->sub_total,
                        'payment_method' => $order->payment_method,
                        'type' => PAYMENT_TYPE_WALLET_RECHARGE
                    ]);

                    createTransaction(auth()->id(), $order->sub_total, TRANSACTION_WALLET_RECHARGE, 'Wallet Recharge', 'Recharge (' . $walletRecharge->id . ')', $walletRecharge->id);
                    $order->user->increment('balance', decimal_to_int($order->sub_total));

                    $this->logger->log('status', 'paid');

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->logger->log('End with Exception', $e->getMessage());
                }

                /** ====== Send notification =========*/
                $text = __("Wallet recharge completed");
                $this->send($text, 3, null , auth()->id());

                $text = __("Wallet recharge");
                $this->send($text, 1, null, null);
                /** ====== Send notification =========*/

                $this->showToastrMessage('success', __('Payment has been completed'));
                return redirect()->route('wallet_recharge.thank-you');
            }
        }

        $this->showToastrMessage('error', __('Payment has been declined'));
        return redirect()->route('main.index');
    }

    public function paymentCancel(Request $request){
        $this->showToastrMessage('error', __('Payment has been canceled'));
        return redirect()->route('main.index');
    }

    protected function extractMercadoPagoPaymentId(Request $request)
    {
        $topic = strtolower((string)($request->input('topic', $request->query('topic', ''))));
        $action = strtolower((string)$request->input('action', ''));
        if ($topic === 'merchant_order' || str_contains($action, 'merchant_order')) {
            return null;
        }

        $data = $request->input('data');
        $resourcePaymentId = $this->extractMercadoPagoPaymentIdFromResource($request);
        $candidates = [
            $request->input('payment_id'),
            $request->input('collection_id'),
            $request->input('paymentId'),
            $request->input('data.id'),
            $request->query('payment_id'),
            $request->query('collection_id'),
            $request->query('paymentId'),
            $resourcePaymentId,
            is_array($data) ? ($data['id'] ?? null) : null,
        ];

        if ($topic === 'payment') {
            $candidates[] = $request->input('id');
            $candidates[] = $request->query('id');
        }

        foreach ($candidates as $candidate) {
            if (is_null($candidate)) {
                continue;
            }

            $candidate = trim((string)$candidate);
            if ($candidate === '' || $candidate === '-1') {
                continue;
            }

            if (preg_match('/^\d+$/', $candidate) === 1) {
                return $candidate;
            }
        }

        return null;
    }

    protected function extractMercadoPagoPaymentIdFromResource(Request $request)
    {
        $resource = $request->input('resource', $request->query('resource'));
        if (is_null($resource)) {
            return null;
        }

        $resource = trim((string)$resource);
        if ($resource === '') {
            return null;
        }

        if (preg_match('/^\d+$/', $resource) === 1) {
            return $resource;
        }

        if (preg_match('/\/v1\/payments\/(\d+)/', $resource, $matches) === 1) {
            return $matches[1];
        }

        return null;
    }

    protected function isMercadoMerchantOrderWebhook(Request $request)
    {
        $topic = strtolower((string)($request->input('topic', $request->query('topic', ''))));
        $action = strtolower((string)$request->input('action', ''));
        return $topic === 'merchant_order' || str_contains($action, 'merchant_order');
    }
}
