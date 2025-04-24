<?php

namespace Nextmux\PaySdk;

class NextmuxPay
{
    private static $instance;
    private $publicKey;
    private $secretKey;
    private $apiUrl;
    private $version = 'v1';

    private function __construct(array $params = [])
    {
        $this->publicKey = $params['publicKey'] ?? null;
        $this->secretKey = $params['secretKey'] ?? null;
        $this->apiUrl = $params['apiUrl'] ?? 'https://api.nextmuxpay.com';
        $this->version = $params['version'] ?? $this->version;
    }
    public static function init(array $params = []): NextmuxPay
    {
        if (!self::$instance) {
            self::$instance = new NextmuxPay($params);
        } else {
            if (!empty($params)) {
                throw new \Exception("NextmuxPay instance is already initialized. Parameters cannot be redefined.");
            }
        }
        return self::$instance;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getToken(): string | null
    {
        $ch = curl_init($this->apiUrl . '/oauth/token');
        $postData = http_build_query([
            'client_id' => $this->publicKey,
            'client_secret' => $this->secretKey,
            'grant_type' => 'client_credentials',
            'scope' => ''
        ]);
    
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'X-Forwarded-For: ' . ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'),
            'User-Agent: ' . ($_SERVER['HTTP_USER_AGENT'] ?? 'App cURL'),
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
