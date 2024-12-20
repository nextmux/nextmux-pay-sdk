<?php

namespace Nextmux\PaySDK;

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
}
