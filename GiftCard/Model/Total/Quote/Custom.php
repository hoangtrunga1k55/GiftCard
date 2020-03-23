<?php
namespace Mageplaza\GiftCard\Model\Total\Quote;
/**
 * Class Custom
 * @package Mageplaza\HelloWorld\Model\Total\Quote
 */
class Custom extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;
    protected $_checkoutSession;
    protected $_giftCardFactory;
    protected $_discount;
    /**
    /**
     * Custom constructor.
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Mageplaza\GiftCard\Model\GiftCardFactory $giftCardFactory
    ){
        $this->_priceCurrency = $priceCurrency;
        $this->_checkoutSession = $checkoutSession;
        $this->_giftCardFactory = $giftCardFactory;
    }

    public  function checkCode($collection,$couponCode){
        foreach ($collection as $collect) {
            if ($couponCode == $collect->getCode()) {
                return $collect->getBalance() ;
                break;
            }
        }
    }


    /**
     * @param \Magento\Quote\Model\Quote $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     * @return $this|bool
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $giftcard = $this->_giftCardFactory->create();
        $collection = $giftcard->getCollection();
        $couponCode = $this->_checkoutSession->getTestData();
        if($couponCode){
            $balance =$this->checkCode($collection,$couponCode);
            $baseDiscount=$balance;
        }else{
            $this->_checkoutSession->unsTestData();
            $baseDiscount =0;
        }
        $this->_discount =  $this->_priceCurrency->convert($baseDiscount);
        $total->addTotalAmount('customer_discount', -$this->_discount);
        $total->addBaseTotalAmount('customer_discount', -$this->_discount);
        $total->setBaseGrandTotal($total->getBaseGrandTotal() - $this->_discount);
        return $this;
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        return [
            'code' => 'custom_discount',
            'title' => 'Gift Card',
            'value' => -$this->_discount,
        ];
    }
}
