<?php

namespace Nextmux\PaySDK;

abstract class ApiClient
{
    protected $config;

    public function __construct()
    {
        $this->config = NextmuxPay::init();
    }

    /**
     * Make a secure cURL request.
     * 
     * @param string $url
     * @param array  $data
     * @param string $method
     * @return array
     * @throws \Exception
     */
    protected function sendRequest(string $url, array $data = [], string $method = 'POST'): array
    {
        $ch = curl_init($url);
        $access_token = $this->getToken();
        $headers = [
            'Authorization: Bearer ' . $access_token,
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
        $response_json = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON Decode Error: ' . json_last_error_msg());
        }
    
        return $response_json ?: [];
    }


    public function getToken(): string
    {
        $ch = curl_init($this->config->getApiUrl() . '/oauth/token');
        $postData = http_build_query([
            'client_id' => $this->config->getPublicKey(),
            'client_secret' => $this->config->getSecretKey(),
            'grant_type' => 'client_credentials',
            'scope' => ''
        ]);
    
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'X-Forwarded-For: ' . ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'),
            'User-Agent: ' . ($_SERVER['HTTP_USER_AGENT'] ?? 'MyApp cURL'),
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
    
        $decodedResponse = json_decode($response, true);
    
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON Decode Error: ' . json_last_error_msg());
        }
    
        if(isset($decodedResponse['access_token'])) {
            return $decodedResponse['access_token'];
        }
        return null;
    }
    
   
}
