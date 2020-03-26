<?php

namespace Mageplaza\GiftCard\Observer;

use Magento\Checkout\Model\Cart as CustomerCart;

class CheckCode   implements \Magento\Framework\Event\ObserverInterface
{
    protected $_giftCardFactory;
    protected  $messageManager;
    protected $_responseFactory;
    protected $_url;
    protected $_checkoutSession;
    protected $cart;

    public function __construct(
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory,
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        \Magento\Checkout\Model\Session $checkoutSession,
        CustomerCart $cart
    )
    {
        $this->messageManager = $messageManager;
        $this->_giftCardFactory = $giftCardFactory;
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
        $this->_checkoutSession = $checkoutSession;
        $this->cart = $cart;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $giftcard = $this->_giftCardFactory->create();
        $cartQuote = $this->cart->getQuote();
        $controller = $observer->getEvent()->getControllerAction();
        $couponCode = $controller->getRequest()->getParam('coupon_code');
        $remove = $controller->getRequest()->getParam('remove');

        if($remove){
            $this->_checkoutSession->unsTestData();
        }
        else{
            $check = $giftcard->load($couponCode,'code');
            if($check->getGiftcard_id()){
                if($check->getBalance()>0){
                    $this->_checkoutSession->setTestData($couponCode);
                    $cartQuote->setTestData($couponCode)->collectTotals();
                    $this->messageManager->addSuccessMessage(__(" Gift code applied successfully"));
                }
                else{
                    $this->messageManager->addSuccessMessage(__("Out of money"));
                }
                $cartUrl = $this->_url->getUrl('checkout/cart/index');
                $this->_responseFactory->create()->setRedirect($cartUrl)->sendResponse();
                exit;
            }
        }
    }
}
