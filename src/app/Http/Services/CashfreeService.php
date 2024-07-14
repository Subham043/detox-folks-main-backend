<?php

namespace App\Http\Services;

use App\Modules\Order\Models\Order;

class CashfreeService
{
    private string $url;
    private $headers;

    public function __construct(){
        $this->url = config('app.cashfree.url');
        $this->headers = array(
            "Content-Type: application/json",
            "x-api-version: 2023-08-01",
            "x-client-id: ".config('app.cashfree.app_id'),
            "x-client-secret: ".config('app.cashfree.secret_key')
        );
    }

    public function create_order(Order $order): string
    {
        $order_data = json_encode([
            'order_id' =>  'order_'.$order->id,
            'order_amount' => $order->total_price,
            "order_currency" => "INR",
            "customer_details" => [
                "customer_id" => (string) $order->user_id,
                "customer_name" => $order->name,
                "customer_email" => $order->email,
                "customer_phone" => $order->phone,
            ],
            "order_meta" => [
                "return_url" => route('cashfree.response', ['order_id' => $order->id]),
            ]
        ]);

        $order_url = $this->url."/pg/orders";

        $order_curl = curl_init($order_url);

        curl_setopt($order_curl, CURLOPT_URL, $order_url);
        curl_setopt($order_curl, CURLOPT_POST, true);
        curl_setopt($order_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($order_curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($order_curl, CURLOPT_POSTFIELDS, $order_data);

        $order_resp = curl_exec($order_curl);

        curl_close($order_curl);

        return json_decode($order_resp)->payment_session_id;
    }

    public function refund(Order $order): void
    {
        $refund_data = json_encode([
            'refund_id' =>  'order_'.$order->id,
            'refund_amount' => $order->total_price,
            "refund_note" => "Order Cancelled",
        ]);

        $refund_url = $this->url."/pg/orders/order_".$order->id."/refunds";

        $refund_curl = curl_init($refund_url);

        curl_setopt($refund_curl, CURLOPT_URL, $refund_url);
        curl_setopt($refund_curl, CURLOPT_POST, true);
        curl_setopt($refund_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($refund_curl, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($refund_curl, CURLOPT_POSTFIELDS, $refund_data);

        curl_exec($refund_curl);

        curl_close($refund_curl);

    }

    public function get_order(string $order_id)
    {

        $verify_url = $this->url."/pg/orders/order_".$order_id;

        $verify_curl = curl_init($verify_url);

        curl_setopt($verify_curl, CURLOPT_URL, $verify_url);
        curl_setopt($verify_curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($verify_curl, CURLOPT_ENCODING, "");
        curl_setopt($verify_curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($verify_curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($verify_curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($verify_curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($verify_curl, CURLOPT_HTTPHEADER, $this->headers);

        $verify_resp = curl_exec($verify_curl);
        $err = curl_error($verify_curl);

        curl_close($verify_curl);

        if ($err) {
            throw $err;
        }
        return json_decode($verify_resp);
    }
}