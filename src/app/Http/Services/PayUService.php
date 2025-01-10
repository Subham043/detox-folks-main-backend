<?php

namespace App\Http\Services;

use App\Modules\Order\Models\Order;
use Ixudra\Curl\Facades\Curl;

class PayUService
{
    private string $MERCHANT_KEY;
    private string $SALT;
    private string $PAYU_PAYMENT_URL = "https://secure.payu.in/_payment";
    private string $PAYU_ORDER_URL = "https://info.payu.in/merchant/postservice?form=2";

    public function __construct(){
        $this->MERCHANT_KEY = config('app.payu.merchant_key');
        $this->SALT = config('app.payu.salt');
    }

    public function create_order(Order $order)
    {
        $successURL = route('pay.u.response', ['order_id' => $order->id]);
        $failURL = route('pay.u.cancel', ['order_id' => $order->id]);
        $name = $order->name;
        $email = $order->email;
        $amount = $order->total_price;

        $action = '';
        $txnid = $order->id;
        $posted = array();
        $posted = array(
            'key' => $this->MERCHANT_KEY,
            'txnid' => $txnid,
            'amount' => $amount,
            'firstname' => $name,
            'email' => $email,
            'productinfo' => 'Webappfix',
            'surl' => $successURL,
            'furl' => $failURL,
            'service_provider' => 'payu_paisa',
        );

        if(empty($posted['txnid'])) {
            $txnid = $order->id;
        }
        else{
            $txnid = $posted['txnid'];
        }

        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        if(empty($posted['hash']) && sizeof($posted) > 0) {
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';
            foreach($hashVarsSeq as $hash_var) {
                $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $this->SALT;
            $hash = strtolower(hash('sha512', $hash_string));
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
        }
        elseif(!empty($posted['hash']))
        {
            $hash = $posted['hash'];
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
        }
        return [
            'action' => $action,
            'hash' => $hash,
            'MERCHANT_KEY' => $this->MERCHANT_KEY,
            'txnid' => $txnid,
            'successURL' => $successURL,
            'failURL' => $failURL,
            'name' => $name,
            'email' => $email,
            'amount' => $amount
        ];
    }

    public function get_order(string $order_id)
    {

        $hash = strtolower(hash('sha512', $this->MERCHANT_KEY.'|verify_payment|'.$order_id.'|'.$this->SALT));

        $response = Curl::to($this->PAYU_ORDER_URL)
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withData([
                    'key' => $this->MERCHANT_KEY,
                    'var1' => $order_id,
                    'command' => 'verify_payment',
                    'hash' => $hash,
                ])
                ->post();
        return json_decode($response);
    }

    public function refund(Order $order)
    {
        $mihpayuid = json_decode($order->payment->payment_data)->mihpayid;

        $hash = strtolower(hash('sha512', $this->MERCHANT_KEY.'|cancel_refund_transaction|'.$mihpayuid.'|'.$order->id.'|'.$order->total_price.'|'.$this->SALT));

        Curl::to($this->PAYU_ORDER_URL)
                ->withHeader('Content-Type:application/x-www-form-urlencoded')
                ->withHeader('accept:application/json')
                ->withData([
                    'key' => $this->MERCHANT_KEY,
                    'var1' => $mihpayuid,
                    'var2' => $order->id,
                    'var3' => $order->total_price,
                    'command' => 'cancel_refund_transaction',
                    'hash' => $hash,
                ])
                ->post();
    }

    // public function create_upi_order(Order $order, $successURL, $failURL)
    // {
    //     $name = $order->name;
    //     $email = $order->email;
    //     // $amount = (string) $order->total_price;
    //     $amount = "1.00";
    //     // dd($amount);

    //     $action = '';
    //     $txnid = $order->id;
    //     $posted = array();
    //     $posted = array(
    //         'key' => $this->MERCHANT_KEY,
    //         'txnid' => $txnid,
    //         'amount' => $amount,
    //         'firstname' => $name,
    //         'email' => $email,
    //         'qrId' => 'STQI-test-'.$order->id,
    //         'productinfo' => 'Webappfix',
    //         'pg' => 'DBQR',
    //         'bankcode' => 'UPIDBQR',
    //         // 'enforce_paymethod' => 'qr',
    //         // 'pg' => 'UPI',
    //         // 'bankcode' => 'UPI',
    //         'surl' => $successURL,
    //         'furl' => $failURL,
    //         'service_provider' => 'payu_paisa',
    //         'txn_s2s_flow' => '4',
    //         's2s_client_ip' => request()->ip(),
    //         's2s_device_info' => "Mozilla Firefox",
    //         'expirytime' => "3600",
    //     );

    //     if(empty($posted['txnid'])) {
    //         $txnid = $order->id;
    //     }
    //     else{
    //         $txnid = $posted['txnid'];
    //     }

    //     $hash = '';
    //     $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|||||";

    //     if(empty($posted['hash']) && sizeof($posted) > 0) {
    //         $hashVarsSeq = explode('|', $hashSequence);
    //         $hash_string = '';
    //         foreach($hashVarsSeq as $hash_var) {
    //             $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
    //             $hash_string .= '|';
    //         }
    //         $hash_string .= $this->SALT;
    //         $hash = strtolower(hash('sha512', $hash_string));
    //         // $action = $this->PAYU_PAYMENT_URL . '/_payment';
    //         $action = $this->PAYU_PAYMENT_URL;
    //         // $action = 'https://secure.payu.in/QrPayment';
    //     }
    //     elseif(!empty($posted['hash']))
    //     {
    //         $hash = $posted['hash'];
    //         // $action = $this->PAYU_PAYMENT_URL . '/_payment';
    //         $action = $this->PAYU_PAYMENT_URL;
    //         // $action = 'https://secure.payu.in/QrPayment';
    //     }
    //     return [
    //         'action' => $action,
    //         'hash' => $hash,
    //         'MERCHANT_KEY' => $this->MERCHANT_KEY,
    //         'txnid' => $txnid,
    //         'successURL' => $successURL,
    //         'failURL' => $failURL,
    //         'name' => $name,
    //         'email' => $email,
    //         'amount' => $amount,
    //         'qrId' => 'STQI-test-'.$order->id
    //     ];
    // }

    public function create_upi_order(Order $order, $successURL, $failURL)
    {
        $name = $order->name;
        $email = $order->email;
        $amount = $order->total_price;

        $action = '';
        $txnid = $order->id;
        $posted = array();
        $posted = array(
            'key' => $this->MERCHANT_KEY,
            'txnid' => $txnid,
            'amount' => $amount,
            'firstname' => $name,
            'email' => $email,
            'productinfo' => 'Webappfix',
            'enforce_paymethod' => 'qr',
            'pg' => 'UPI',
            'bankcode' => 'UPI',
            'surl' => $successURL,
            'furl' => $failURL,
            'service_provider' => 'payu_paisa',

            // 'pg' => 'DBQR',
            // 'bankcode' => 'UPIDBQR',
            // 'txn_s2s_flow' => '4',
            // 's2s_client_ip' => request()->ip(),
            // 's2s_device_info' => "Mozilla Firefox",
        );

        if(empty($posted['txnid'])) {
            $txnid = $order->id;
        }
        else{
            $txnid = $posted['txnid'];
        }

        $hash = '';
        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

        if(empty($posted['hash']) && sizeof($posted) > 0) {
            $hashVarsSeq = explode('|', $hashSequence);
            $hash_string = '';
            foreach($hashVarsSeq as $hash_var) {
                $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $this->SALT;
            $hash = strtolower(hash('sha512', $hash_string));
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
        }
        elseif(!empty($posted['hash']))
        {
            $hash = $posted['hash'];
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
            $action = $this->PAYU_PAYMENT_URL . '/_payment';
        }
        return [
            'action' => $action,
            'hash' => $hash,
            'MERCHANT_KEY' => $this->MERCHANT_KEY,
            'txnid' => $txnid,
            'successURL' => $successURL,
            'failURL' => $failURL,
            'name' => $name,
            'email' => $email,
            'amount' => $amount
        ];
    }
}
