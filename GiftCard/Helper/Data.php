<?php

namespace Mageplaza\GiftCard\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{

//    const XML_PATH_HELLOWORLD = 'gitcard/';
//
//    public function getConfigValue($field, $storeId = null)
//    {
//        return $this->scopeConfig->getValue(
//            $field, ScopeInterface::SCOPE_STORE, $storeId
//        );
//    }

    public function getGeneralConfig()
    {
        return $this->scopeConfig->getValue('giftcard/general_test_child/display_text', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getGiftCard_Enable()
    {
        return $this->scopeConfig->getValue('giftcard/general/enable12', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public function getGiftCard_Enable_Moudule()
    {
        return $this->scopeConfig->getValue('giftcard/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    public  function getCountProduct(){
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
       return $cart->getQuote()->getItemsCount();
    }


}
