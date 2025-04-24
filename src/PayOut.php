<?php

namespace Nextmux\PaySdk;

class PayOut extends ApiClient
{
    /**
     * Create a payout request.
     * 
     * @param float  $amount
     * @param string $currency
     * @param array  $recipientDetails
     * @return array
     * @throws \Exception
     */
    public function create(float $amount, string $currency, array $recipientDetails): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payouts";
        $data = array_merge($recipientDetails, ['amount' => $amount, 'currency' => $currency]);
        return $this->sendRequest($url, $data);
    }

    /**
     * Get the status of a payout.
     * 
     * @param string $payoutId
     * @return array
     * @throws \Exception
     */
    public function status(string $payoutId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payouts/{$payoutId}";
        return $this->sendRequest($url, [], 'GET');
    }

    public function external_status(string $payoutId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payouts-status/{$payoutId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
