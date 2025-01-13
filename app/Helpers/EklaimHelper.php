<?php

namespace App\Helpers;

use CodeIgniter\HTTP\CURLRequest;

class EklaimHelper
{
    private $cons_id;
    private $secret_key;
    private $base_url;

    public function __construct()
    {
        $this->cons_id = env('EKLAIM_CONS_ID');
        $this->secret_key = env('EKLAIM_SECRET_KEY');
        $this->base_url = env('EKLAIM_BASE_URL');
    }

    private function getSignature()
    {
        $timestamp = time();
        $data = $this->cons_id . "&" . $timestamp;
        $signature = hash_hmac('sha256', $data, $this->secret_key, true);
        return [
            'signature' => base64_encode($signature),
            'timestamp' => $timestamp,
        ];
    }

    public function sendRequest($endpoint, $method = 'GET', $data = [])
    {
        $client = service('curlrequest');
        $signatureData = $this->getSignature();

        $headers = [
            'X-cons-id' => $this->cons_id,
            'X-timestamp' => $signatureData['timestamp'],
            'X-signature' => $signatureData['signature'],
            'Content-Type' => 'application/json',
        ];

        $options = [
            'headers' => $headers,
        ];

        if (!empty($data) && $method === 'POST') {
            $options['json'] = $data;
        }

        $response = $client->request($method, $this->base_url . $endpoint, $options);
        return json_decode($response->getBody(), true);
    }
}
