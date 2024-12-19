<?php

namespace Nextmux\PaySDK;

class Config
{
    private static $instance;
    private $publicKey;
    private $secretKey;
    private $apiUrl;

    private function __construct() {}

    public static function getInstance(): Config
    {
        if (!self::$instance) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public function setKeys(string $publicKey, string $secretKey, string $apiUrl = 'https://api.nextmuxpay.com'): void
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;
        $this->apiUrl = $apiUrl;
    }

    public function setApiUrl(string $apiUrl): void
    {
        $this->apiUrl = $apiUrl;
    }

    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }
    public function getPublictKey(): string
    {
        return $this->publicKey;
    }
}
