<?php

namespace Mageplaza\GiftCard\Observer;


class Coupon implements \Magento\Framework\Event\ObserverInterface
{
    protected $_postFactory;
    protected $_checkoutSession;

    public function __construct(
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory,
        \Magento\Checkout\Model\Session $checkoutSession
    )
    {
        $this->_postFactory = $postFactory;
        $this->_checkoutSession = $checkoutSession;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $post = $this->_postFactory->create();
        $code = $this->_checkoutSession->getTestData();
        if($code){
            $post->load($code,'code')->addData(array(
                'amount_used' =>$post->load($code,'code')->getBalance(),
                'balance' => 0,
            ))->save();
            $this->_checkoutSession->unsTestData();
        }
    }
}

