<?php

class Picqer_Webhook_Model_Orderstate
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'new', 'label' => Mage::helper('picqer_webhook')->__('New')),
            array('value' => 'pending_payment', 'label' => Mage::helper('picqer_webhook')->__('Pending Payment')),
            array('value' => 'processing', 'label' => Mage::helper('picqer_webhook')->__('Processing')),
            array('value' => 'complete', 'label' => Mage::helper('picqer_webhook')->__('Complete')),
            array('value' => 'closed', 'label' => Mage::helper('picqer_webhook')->__('Closed')),
            array('value' => 'canceled', 'label' => Mage::helper('picqer_webhook')->__('Canceled')),
            array('value' => 'holded', 'label' => Mage::helper('picqer_webhook')->__('On Hold')),
            array('value' => 'payment_review', 'label' => Mage::helper('picqer_webhook')->__('Payment Review')),
        );
    }
}