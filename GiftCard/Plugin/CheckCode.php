<?php

namespace Mageplaza\GiftCard\Plugin;

class CheckCode
{
    protected $_checkoutSession;
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->_checkoutSession = $checkoutSession;
    }

    public function afterGetCouponCode(\Magento\Checkout\Block\Cart\Coupon $subject, $title)
    {
        if($this->_checkoutSession->getTestData()){
            $title = $this->_checkoutSession->getTestData();
        }
        else{
            $this->_checkoutSession->unsTestData();
        }
        return $title;
    }

}
