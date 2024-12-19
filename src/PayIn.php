<?php

namespace Nextmux\PaySDK;

class PayIn extends ApiClient
{
    /**
     * Process a payment request (PayIn).
     * 
     * @param string $fullname
     * @param string $email
     * @param string $phone_number
     * @param float  $amount
     * @param string $description
     * @param string $currency
     * @param string|null $operator_code
     * @param string|null $country_code
     * @param string|null $callback_url
     * @param string|null $notify_url
     * @param string|null $return_url
     * @param string|null $channels
     * @param string|null $lang
     * @param array|null  $metadata
     * @param string|null $address
     * @param string|null $city
     * @param string|null $state
     * @param string|null $zip_code
     * @return string
     * @throws \Exception
     */
    public function create(
        string $fullname,
        string $email,
        string $phone_number,
        float $amount,
        string $description,
        string $currency,
        ?string $operator_code = null,
        ?string $country_code = null,
        ?string $callback_url = null,
        ?string $notify_url = null,
        ?string $return_url = null,
        ?string $channels = null,
        ?string $lang = null,
        ?array $metadata = null,
        ?string $address = null,
        ?string $city = null,
        ?string $state = null,
        ?string $zip_code = null
    ): string {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins";
        $data = [
            'fullname'       => $fullname,
            'email'          => $email,
            'phone_number'   => $phone_number,
            'amount'         => $amount,
            'description'    => $description,
            'currency'       => $currency,
            'operator_code'  => $operator_code,
            'country_code'   => $country_code,
            'callback_url'   => $callback_url,
            'notify_url'     => $notify_url,
            'return_url'     => $return_url,
            'channels'       => $channels,
            'lang'           => $lang,
            'metadata'       => $metadata,
            'address'        => $address,
            'city'           => $city,
            'state'          => $state,
            'zip_code'       => $zip_code
        ];
        
        $data = array_filter($data, fn($value) => !is_null($value));

        return $this->sendRequest($url, $data, 'POST');
    }

    /**
     * Issue a refund for a payment.
     * 
     * @param string $paymentId
     * @param float  $amount
     * @return string
     * @throws \Exception
     */
    public function refund(string $paymentId): string
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins/{$paymentId}/refund";
        // $data = ['amount' => $amount];
        return $this->sendRequest($url, [], 'POST');
        // return $this->sendRequest($url, $data, 'POST');
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
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins/{$paymentId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
