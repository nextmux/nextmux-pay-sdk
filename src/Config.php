<?php

namespace Nextmux\PaySDK;

class Config
{
    private static $instance;
    private $publicKey;
    private $secretKey;
    private $apiUrl;
    private $version = 'v1';

    private function __construct() {}

    public static function getInstance(): Config
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function setKeys(string $publicKey, string $secretKey, string $apiUrl = 'https://api.nextmuxpay.com', string $version = '1'): void
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->setApiUrl($apiUrl);
        $this->setVersion($version);
    }

    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
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

    public function getToken(): array
    {
        $ch = curl_init($this->getApiUrl() . '/oauth/token');
        $postData = http_build_query([
            'client_id' => $this->getPublicKey(),
            'client_secret' => $this->getSecretKey(),
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
    
        return $decodedResponse;
    }
    
}
