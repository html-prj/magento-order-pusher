<?php

class Picqer_Webhook_Model_Sales_Order_Webhook
{

    /**
     * Send order information to Picqer
     *
     * @param null $observer
     */
    public function sendWebhook($observer = null)
    {
        // Only run when configured as active
        $active = Mage::getStoreConfig('picqer_webhook_options/general_settings/picqer_webhook_active');
        if ($active != 1) {
            return;
        }

        $order = $observer->getOrder();

        // Only run when correct state is set
        if ( ! $this->hasCorrectState($order)) {
            return;
        }

        // Get preferences
        $magentoKey = Mage::getStoreConfig('picqer_webhook_options/general_settings/picqer_magento_key');
        $domain = Mage::getStoreConfig('picqer_webhook_options/general_settings/picqer_domain');

        // Get the API Order Model
        $apiOrder = Mage::getModel('sales/order_api');
        $orderData = $apiOrder->info($order->getIncrementId());
        $orderData['picqer_magento_key'] = $magentoKey;
        $orderData = json_encode($orderData);

        // Send the order to Picqer
        $this->post('https://' . $domain . '.picqer.com/webshops/magento/orderPush/' . $magentoKey, $orderData);
    }


    /**
     * POST data to URL with cURL
     *
     * @param $url
     * @param $data
     *
     * @return mixed
     */
    private function post($url, $data)
    {
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            ),
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_TIMEOUT        => 10
        );
        curl_setopt_array($ch, $curlConfig);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }


    private function hasCorrectState($order)
    {
        $state = $order->getState();
        $requestedState = Mage::getStoreConfig('picqer_webhook_options/general_settings/picqer_order_state');

        return $state === $requestedState;
    }
}