<?php

namespace Nextmux\PaySDK;

class PayIn extends ApiClient
{
    /**
     * Process a payment request (PayIn).
     * 
     * @param float  $amount
     * @param string $currency
     * @param array  $paymentDetails
     * @return string
     * @throws \Exception
     */
    public function create(float $amount, string $currency, array $paymentDetails): string
    {
        $url = $this->config->getApiUrl() . "/payins";
        $data = array_merge($paymentDetails, ['amount' => $amount, 'currency' => $currency]);
        return $this->sendRequest($url, $data);
    }

    /**
     * Issue a refund for a payment.
     * 
     * @param string $paymentId
     * @param float  $amount
     * @return string
     * @throws \Exception
     */
    public function refund(string $paymentId, float $amount): string
    {
        $url = $this->config->getApiUrl() . "/payins/{$paymentId}/refund";
        $data = ['amount' => $amount];
        return $this->sendRequest($url, $data);
    }

    /**
     * Retrieve the status of a payment.
     * 
     * @param string $paymentId
     * @return string
     * @throws \Exception
     */
    public function status(string $paymentId): string
    {
        $url = $this->config->getApiUrl() . "/payins/{$paymentId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
