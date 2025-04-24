<?php

namespace Nextmux\PaySdk;

class PayIn extends ApiClient
{
    
    /**
     * Create a payment with mobile money
     *
     * @param string $operator_code
     * @param array $params : fullname, email, phone_number, amount, description
     * @param array $custom_params
     * @param bool $get_link    
     * @return array
     * @throws \Exception
     */
    public function with_mobile_money(
     $operator_code,  array $params, $custom_params = [], $get_link = false
    ): array {

        $required_params = [  'fullname',  'email',    'phone_number',   'amount',  'description'];
        // $optional_params = ['pay_type', 'fcm_token', 'pay_type_mode', 'operator_code', 'country_code', 'callback_url', 'notify_url', 'return_url', 'channels', 'lang', 'metadata', 'address', 'city', 'state', 'zip_code'];
        foreach ($required_params as $param) {
            if (!isset($params[$param])) {
                return [
                    'status' => 'error',
                    'message' => "The parameter '$param' is required"
                ];
            }
        }
       $payment_data = $params;
       array_merge($payment_data, $custom_params);
       $payment_data['operator_code'] = strtolower($operator_code);
       $payment_data['payload'] =    json_encode($custom_params);
       $payment_data['currency'] = isset($payment_data['currency']) ? $payment_data['currency'] : 'XOF';

        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins";

        return $this->sendRequest($url, $payment_data, 'POST');
    }

    /**
     * Issue a refund for a payment.
     * 
     * @param string $paymentId
     * @param float  $amount
     * @return array
     * @throws \Exception
     */
    public function refund(string $paymentId): array
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
     * @return array
     * @throws \Exception
     */
    public function status(string $paymentId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins/{$paymentId}";
        return $this->sendRequest($url, [], 'GET');
    }
    public function external_status(string $paymentId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/payins-status/{$paymentId}";
        return $this->sendRequest($url, [], 'GET');
    }

    
}
