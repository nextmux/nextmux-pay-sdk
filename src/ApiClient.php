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
            'Content-Type: application/json'
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
}
