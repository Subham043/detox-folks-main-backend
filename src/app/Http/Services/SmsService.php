<?php

namespace App\Http\Services;

class SmsService
{

    public function send(int $phone, string $msg)
    {
        $key = config('app.sms.key');
        // Account details
        $apiKey = urlencode($key);
        // Message details
        $numbers = array($phone);
        $sender = urlencode('TXTLCL');
        $message = rawurlencode($msg);

        $numbers = implode(',', $numbers);

        // Prepare data for POST request
        $data = array('apikey' => $apiKey, 'numbers' => $numbers, 'sender' => $sender, 'message' => $message);
        // Send the POST request with cURL
        $ch = curl_init('https://api.textlocal.in/send/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        // Process your response here
        if ($err) {
            // throw $err;
            return false;
        }
        return $response;
    }

}