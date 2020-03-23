<?php

namespace Mageplaza\GiftCard\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Api\Data\OrderInterface;
use Mageplaza\GiftCard\Model\GiftCardFactory;
use Mageplaza\GiftCard\Model\HistoryFactory;

class History extends \Magento\Framework\View\Element\Template
{   protected  $currentCustomer;
    protected  $customer;
    protected $_test;
    protected $_giftcard;
    protected $_orderCurrency = null;
    protected $_currencyFactory;

    public function __construct(
        Context $context,
        HistoryFactory $test,
        GiftCardFactory $giftcard,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData
    ) {
        $this->_test = $test;
        $this->currentCustomer = $currentCustomer;
        $this->customer = $customer;
        $this->_giftcard = $giftcard;
        $this->_currencyFactory = $currencyFactory;
        parent::__construct($context);
    }

    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }



    public function getCode($aaa){
        $giftcard = $this->_giftcard->create();
        $collection = $giftcard->getCollection();
        foreach($collection as $collect){
            if($aaa->getGiftcard_id()==$collect->getGiftcard_id()){
                return $collect->getCode();
                break;
            }
        }

    }

    public function getTestCollection()
    {
        $test = $this->_test->create();
        $id = $this->getCustomer()->getId();
        $collection = $test->getCollection();
        $data = array();
        foreach ($collection as $collect){
            if($collect->getCustomer_id()==$id){
                array_push($data,$collect);
            }
        }
        return $data;
    }
    public function getActionUrl (){
        return $this->getUrl('giftcard/index/addData');
    }

    public function getOrderCurrencyCode()
    {
        return $this->getData(OrderInterface::ORDER_CURRENCY_CODE);
    }



    public function getOrderCurrency()
    {
        if ($this->_orderCurrency === null) {
            $this->_orderCurrency = $this->_currencyFactory->create();
            $this->_orderCurrency->load($this->getOrderCurrencyCode());
        }
        return $this->_orderCurrency;
    }

    public function formatPricePrecision($price, $precision, $addBrackets = false)
    {
        return $this->getOrderCurrency()->formatPrecision($price, $precision, [], true, $addBrackets);
    }
    public function formatPrice($price, $addBrackets = false)
    {
        return $this->formatPricePrecision($price, 2, $addBrackets);
    }

}
