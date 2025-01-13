<?php

namespace App\Helpers;

use CodeIgniter\HTTP\CURLRequest;

class SatusehatHelper
{
    private $client_id;
    private $client_secret;
    private $base_url;
    private $token;

    public function __construct()
    {
        // https://satusehat.kemkes.go.id/platform/docs/id/api-code/
        $this->client_id = env('SATUSEHAT_CLIENT_ID');
        $this->client_secret = env('SATUSEHAT_CLIENT_SECRET');
        $this->base_url = env('SATUSEHAT_BASE_URL');
        $this->token = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        $client = service('curlrequest');

        $response = $client->request('POST', $this->base_url . '/oauth/token', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'grant_type' => 'client_credentials',
                'client_id' => $this->client_id,
                'client_secret' => $this->client_secret,
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['access_token'] ?? null;
    }

    public function sendRequest($endpoint, $method = 'GET', $data = [])
    {
        if (!$this->token) {
            return ['error' => 'Failed to retrieve access token'];
        }

        $client = service('curlrequest');
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];

        $options = ['headers' => $headers];
        if (!empty($data) && $method === 'POST') {
            $options['json'] = $data;
        }

        $response = $client->request($method, $this->base_url . $endpoint, $options);
        return json_decode($response->getBody(), true);
    }
}
