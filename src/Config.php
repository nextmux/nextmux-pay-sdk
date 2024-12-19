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

   
}
