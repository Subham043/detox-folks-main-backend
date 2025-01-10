<?php

namespace App\Http\Services;

class SmsService
{

    private function send(int $phone, string $msg, string $sndr = 'PRCCTR')
    {
        if(!((boolean) config('app.sms.enabled'))){
            return true;
        }
        $key = config('app.sms.key');
        // Account details
        $apiKey = urlencode($key);
        // Message details
        $numbers = array($phone);
        $sender = urlencode($sndr);
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
        return true;
    }

    public function sendDeliveryConfirmation(string $phone, string $otp)
    {
        $message = "Please share this OTP with the delivery agent to complete the order. Your OTP is " . $otp . ". Parcelcounter.";
        return $this->send('91'.$phone, $message);
    }

    public function sendLoginOtp(string $phone, string $otp)
    {
        $message = "Your one time password for login is ".$otp.". Do not share with anyone. Parcelcounter.";
        return $this->send('91'.$phone, $message);
    }

    public function sendLoginOtpLocal(string $phone, string $otp)
    {
        $message = "Your OTP is: ".$otp.". @localhost #".$otp.". Please do not share it with anyone. Parcel Counter.";
        return $this->send('91'.$phone, $message);
    }

    public function sendLoginOtpWeb(string $phone, string $otp)
    {
        $message = "Your OTP is: ".$otp.". @parcelcounter.in #".$otp." Please do not share it with anyone. Parcel Counter.";
        return $this->send('91'.$phone, $message);
    }

    public function sendLoginOtpAutoRead(string $phone, string $otp, string $hash)
    {
        $message = "Your OTP code is: ".$otp.". Please do not share it with anyone. ".$hash.". Parcel Counter.";
        return $this->send('91'.$phone, $message);
    }

}
