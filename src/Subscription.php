<?php

namespace Nextmux\PaySDK;

class Subscription extends ApiClient
{
    /**
     * Fetch all subscriptions.
     * 
     * @return string
     * @throws \Exception
     */
    public function getAllSubscriptions(): string
    {
        $url = $this->config->getApiUrl() . "/subscriptions";
        return $this->sendRequest($url, [], 'GET');
    }

    /**
     * Create a new subscription.
     * 
     * @param array $subscriptionData
     * @return string
     * @throws \Exception
     */
    public function create(array $subscriptionData): string
    {
        $url = $this->config->getApiUrl() . "/subscriptions";
        return $this->sendRequest($url, $subscriptionData);
    }

    /**
     * Get details of a specific subscription.
     * 
     * @param string $subscriptionId
     * @return string
     * @throws \Exception
     */
    public function detail(string $subscriptionId): string
    {
        $url = $this->config->getApiUrl() . "/subscriptions/{$subscriptionId}";
        return $this->sendRequest($url, [], 'GET');
    }

    /**
     * Cancel a subscription.
     * 
     * @param string $subscriptionId
     * @return string
     * @throws \Exception
     */
    public function cancel(string $subscriptionId): string
    {
        $url = $this->config->getApiUrl() . "/subscriptions/{$subscriptionId}/cancel";
        return $this->sendRequest($url, [], 'POST');
    }

    /**
     * Create a subscription plan.
     * 
     * @param array $planData
     * @return string
     * @throws \Exception
     */
    public function createPlan(array $planData): string
    {
        $url = $this->config->getApiUrl() . "/plans";
        return $this->sendRequest($url, $planData);
    }

    /**
     * Get details of a subscription plan.
     * 
     * @param string $planId
     * @return string
     * @throws \Exception
     */
    public function planDetail(string $planId): string
    {
        $url = $this->config->getApiUrl() . "/plans/{$planId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
