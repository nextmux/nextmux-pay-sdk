<?php

namespace Nextmux\PaySDK;

abstract class ApiClient
{
    protected $config;

    public function __construct()
    {
        $this->config = Config::getInstance();
    }

    /**
     * Make a secure cURL request.
     * 
     * @param string $url
     * @param array  $data
     * @param string $method
     * @return string
     * @throws \Exception
     */
    protected function sendRequest(string $url, array $data = [], string $method = 'POST'): string
    {
        $ch = curl_init($url);

        $headers = [
            'Authorization: Bearer ' . $this->config->getSecretKey(),
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Forwarded-For: ' . $_SERVER['REMOTE_ADDR'], 
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'],  
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'GET') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Request Error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }

    protected function getToken(): string
    {
        $ch = curl_init( $this->config->getApiUrl().'/oauth/token');
        $postData = http_build_query([
            'client_id' => $this->config->getPublictKey(),
            'client_secret' => $this->config->getSecretKey(),
            'grant_type' => 'client_credentials',
            'scope' => ''
        ] );
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'X-Forwarded-For: ' . $_SERVER['REMOTE_ADDR'], 
            'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'],  
        ];

        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode < 200 || $httpCode >= 300) {
            throw new \Exception("HTTP Error: $httpCode, Response: $response");
        }

        curl_close($ch);

        return $response;
    }
}
