<?php

namespace Nextmux\PaySDK;

class PayOut extends ApiClient
{
    /**
     * Create a payout request.
     * 
     * @param float  $amount
     * @param string $currency
     * @param array  $recipientDetails
     * @return string
     * @throws \Exception
     */
    public function create(float $amount, string $currency, array $recipientDetails): string
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payouts";
        $data = array_merge($recipientDetails, ['amount' => $amount, 'currency' => $currency]);
        return $this->sendRequest($url, $data);
    }

    /**
     * Get the status of a payout.
     * 
     * @param string $payoutId
     * @return string
     * @throws \Exception
     */
    public function status(string $payoutId): string
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payouts/{$payoutId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
