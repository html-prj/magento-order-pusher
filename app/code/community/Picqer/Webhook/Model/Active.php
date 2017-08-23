<?php

class Picqer_Webhook_Model_Active
{
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('picqer_webhook')->__('Yes')),
            array('value' => 0, 'label' => Mage::helper('picqer_webhook')->__('No'))
        );
    }
}