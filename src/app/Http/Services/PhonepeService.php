<?php

namespace App\Http\Services;

use App\Enums\PaymentStatus;
use App\Modules\Order\Models\Order;
use Ixudra\Curl\Facades\Curl;

class PhonepeService
{

    public function generate(string $id, int $user_id, float $amount): string
    {
        $data = array (
            'merchantId' => config('app.phonepe_merchant_id'),
            'merchantTransactionId' => $id,
            'merchantUserId' => $user_id,
            'amount' => $amount * 100,
            'redirectUrl' => route('phonepe_response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('phonepe_response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' => array (
              'type' => 'PAY_PAGE',
            ),
        );

        $encode = base64_encode(json_encode($data));

        $saltKey = config('app.phonepe_salt_key');
        $saltIndex = config('app.phonepe_salt_index');

        $string = $encode.'/pg/v1/pay'.$saltKey;
        $sha256 = hash('sha256',$string);

        $finalXHeader = $sha256.'###'.$saltIndex;

        $response = Curl::to(config('app.phonepe_url'))
                ->withHeader('Content-Type:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withData(json_encode(['request' => $encode]))
                ->post();

        $rData = json_decode($response);

        return $rData->data->instrumentResponse->redirectInfo->url;
    }

    public function verify(array $input, Order $order):string
    {
        $saltKey = config('app.phonepe_salt_key');
        $saltIndex = config('app.phonepe_salt_index');

        $finalXHeader = hash('sha256','/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'].$saltKey).'###'.$saltIndex;

        $response = Curl::to(config('app.phonepe_status_url').'/'.$input['merchantId'].'/'.$input['transactionId'])
                ->withHeader('Content-Type:application/json')
                ->withHeader('accept:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withHeader('X-MERCHANT-ID:'.$input['merchantId'])
                ->get();
        $rData = json_decode($response);
        if($rData->success==true && $rData->code=="PAYMENT_SUCCESS"){
            $order->payment->update([
                'status' => PaymentStatus::PAID->value,
                'payment_data' => json_encode($input)
            ]);
            return route('payment_success');
        }else{
            return route('payment_fail');
        }
    }

    public function refund(string $transactionId, string $id, int $user_id, float $amount): void
    {
        $data = array (
            'merchantId' => config('app.phonepe_merchant_id'),
            'merchantUserId' => $user_id,
            'merchantTransactionId' => $id,
            'originalTransactionId' => $transactionId,
            'amount' => $amount * 100,
        );

        $encode = base64_encode(json_encode($data));

        $saltKey = config('app.phonepe_salt_key');
        $saltIndex = config('app.phonepe_salt_index');

        $string = $encode.'/pg/v1/refund'.$saltKey;
        $sha256 = hash('sha256',$string);

        $finalXHeader = $sha256.'###'.$saltIndex;

        Curl::to(config('app.phonepe_refund_url'))
                ->withHeader('Content-Type:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withData(json_encode(['request' => $encode]))
                ->post();
    }

}