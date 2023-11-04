<?php

namespace App\Http\Services;

use App\Enums\OrderMode;
use App\Enums\PaymentStatus;
use App\Modules\Cart\Models\Cart;
use App\Modules\Order\Models\Order;
use App\Modules\Order\Models\OrderPayment;
use Ixudra\Curl\Facades\Curl;

class PhonepeService
{

    public function generate(string $id, float $amount): string
    {
        $data = array (
            'merchantId' => 'PGTESTPAYUAT',
            'merchantTransactionId' => $id,
            'merchantUserId' => 'MUID123',
            'amount' => $amount * 100,
            'redirectUrl' => route('phonepe_response'),
            'redirectMode' => 'POST',
            'callbackUrl' => route('phonepe_response'),
            'mobileNumber' => '9999999999',
            'paymentInstrument' =>
            array (
              'type' => 'PAY_PAGE',
            ),
        );

        $encode = base64_encode(json_encode($data));

        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $string = $encode.'/pg/v1/pay'.$saltKey;
        $sha256 = hash('sha256',$string);

        $finalXHeader = $sha256.'###'.$saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay')
                ->withHeader('Content-Type:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withData(json_encode(['request' => $encode]))
                ->post();

        $rData = json_decode($response);

        return $rData->data->instrumentResponse->redirectInfo->url;
    }

    public function verify(array $input):string
    {
        $saltKey = '099eb0cd-02cf-4e2a-8aca-3e6c6aff0399';
        $saltIndex = 1;

        $finalXHeader = hash('sha256','/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'].$saltKey).'###'.$saltIndex;

        $response = Curl::to('https://api-preprod.phonepe.com/apis/merchant-simulator/pg/v1/status/'.$input['merchantId'].'/'.$input['transactionId'])
                ->withHeader('Content-Type:application/json')
                ->withHeader('accept:application/json')
                ->withHeader('X-VERIFY:'.$finalXHeader)
                ->withHeader('X-MERCHANT-ID:'.$input['transactionId'])
                ->get();
        $rData = json_decode($response);
        if($rData->success==true && $rData->code=="PAYMENT_SUCCESS"){
            $payment = OrderPayment::where('order_id', $input['transactionId'])->firstOrFail();
            $payment->status = PaymentStatus::PAID->value;
            $payment->payment_data = json_encode($rData->data);
            $payment->save();
            Cart::where('user_id', $payment->order->user_id)->delete();
            if($payment->order->order_mode == OrderMode::WEBSITE){
                return "https://parcelcounter.in/orders?success=true";
            }else{
                return "https://parcelcounter.in/checkout";
            }
        }else{
            return "https://parcelcounter.in/checkout";
        }
    }

}
