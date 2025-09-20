<?php

namespace Oxydaid\Tokopay\Services;

class Tokopay
{
    protected $merchantID;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->merchantID = config('tokopay.merchant_id');
        $this->secretKey  = config('tokopay.secret_key');
        $this->baseUrl    = rtrim(config('tokopay.base_url'), '/');
    }

    public function generateSignature($refID)
    {
        $codeSignature = $this->merchantID . ":" . $this->secretKey . ":" . $refID;
        return md5($codeSignature);
    }

    public function createTransaction(array $data)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->baseUrl . '/v1/order/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => json_encode($data),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    public function checkOrderStatus($merchant, $secret, $refId, $amount, $channel)
    {
        $url = $this->baseUrl . "/v1/order?merchant={$merchant}&secret={$secret}&ref_id={$refId}&nominal={$amount}&metode={$channel}";

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => 'GET',
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
