<?php
namespace Mageplaza\GiftCard\Block;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;

class Balance extends \Magento\Framework\View\Element\Template
{
    protected $_subscription;
    protected $_subscriberFactory;
    protected $_helperView;
    protected $currentCustomer;
    protected $_currencyFactory;
    protected $customer;
    protected $_orderCurrency = null;
    protected $helperData;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Helper\View $helperView,
        \Magento\Customer\Model\Customer $customer,
        \Magento\Directory\Model\CurrencyFactory $currencyFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->_helperView = $helperView;
        $this->customer = $customer;
        $this->_currencyFactory = $currencyFactory;
        $this->helperData = $helperData;
        parent::__construct($context, $data);
    }
    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    protected function _toHtml()
    {
        return $this->currentCustomer->getCustomerId() ? parent::_toHtml() : '';
    }

    public function getActionUrl (){
        return $this->getUrl('giftcard/customer/redeem');
    }

    public  function getAllow(){
        return $this->helperData->getGiftCard_Enable();
    }

    public function getAllow_Module(){
        return $this->helperData->getGiftCard_Enable_Moudule();
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

    public function getBalance(){
        $id=$this->getCustomer()->getId();
        return $this->customer->load($id)->getGiftcard_balance();
    }
}
