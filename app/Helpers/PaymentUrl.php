<?php

namespace App\Helpers;
use Exception;
use Http;
use Config;
use Log;

class PaymentUrl
{
    public static function url($data)
    {
        try {
            $vpay_api = Config('services.vpay_api');

            Log::info('BODY JSON enviado a VPay: ' . json_encode($data, JSON_PRESERVE_ZERO_FRACTION));

            $payment = Http::baseUrl($vpay_api)
            ->withHeaders(['Content-Type' => 'application/json'])
            ->withBody(json_encode($data, JSON_PRESERVE_ZERO_FRACTION), 'application/json')
            ->post('getLink');
            
            if($payment->successful()){
                return $payment->json();
            } else {
                throw new Exception(json_encode($payment->json()), $payment->status());
            }
        } catch(Exception $e){
            throw $e;
        }
    }
}