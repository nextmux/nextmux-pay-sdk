<?php

namespace Nextmux\PaySdk;

class Subscription extends ApiClient
{
    /**
     * Fetch all subscriptions.
     * 
     * @return array
     * @throws \Exception
     */
    public function getAllSubscriptions(): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/subscriptions";
        return $this->sendRequest($url, [], 'GET');
    }

    /**
     * Create a new subscription.
     * 
     * @param array $subscriptionData
     * @return array
     * @throws \Exception
     */
    public function create(array $subscriptionData): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/subscriptions";
        return $this->sendRequest($url, $subscriptionData);
    }

    /**
     * Get details of a specific subscription.
     * 
     * @param string $subscriptionId
     * @return array
     * @throws \Exception
     */
    public function detail(string $subscriptionId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/subscriptions/{$subscriptionId}";
        return $this->sendRequest($url, [], 'GET');
    }

    /**
     * Cancel a subscription.
     * 
     * @param string $subscriptionId
     * @return array
     * @throws \Exception
     */
    public function cancel(string $subscriptionId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/subscriptions/{$subscriptionId}/cancel";
        return $this->sendRequest($url, [], 'POST');
    }

    /**
     * Create a subscription plan.
     * 
     * @param array $planData
     * @return array
     * @throws \Exception
     */
    public function createPlan(array $planData): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/plans";
        return $this->sendRequest($url, $planData);
    }

    /**
     * Get details of a subscription plan.
     * 
     * @param string $planId
     * @return array
     * @throws \Exception
     */
    public function planDetail(string $planId): array
    {
        $url = $this->config->getApiUrl() ."/".$this->config->getVersion(). "/plans/{$planId}";
        return $this->sendRequest($url, [], 'GET');
    }
}
