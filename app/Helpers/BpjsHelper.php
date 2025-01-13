<?php

namespace App\Helpers;

use CodeIgniter\HTTP\CURLRequest;

class BpjsHelper
{
    private $cons_id;
    private $secret_key;
    private $base_url;

    public function __construct()
    {
        $this->cons_id = env('BPJS_CONS_ID');
        $this->secret_key = env('BPJS_SECRET_KEY');
        $this->base_url = env('BPJS_API_URL');

        // https://new-api.bpjs-kesehatan.go.id/pcare-rest-v3.0
        // https://dvlp.bpjs-kesehatan.go.id:8888/trust-mark/portal.html
    }

    private function getSignature()
    {
        $time = time();
        $signature = hash_hmac('sha256', $this->cons_id . "&" . $time, $this->secret_key, true);
        return base64_encode($signature);
    }

    public function sendRequest($endpoint, $method = 'GET', $data = [])
    {
        $client = service('curlrequest');
        $headers = [
            'X-cons-id' => $this->cons_id,
            'X-timestamp' => time(),
            'X-signature' => $this->getSignature(),
        ];

        $options = [
            'headers' => $headers,
        ];

        if (!empty($data) && $method === 'POST') {
            $options['form_params'] = $data;
        }

        $response = $client->request($method, $this->base_url . $endpoint, $options);
        return json_decode($response->getBody(), true);
    }
}
