<?php
namespace Mageplaza\GiftCard\Model\Total\Quote;
use Magento\Checkout\Model\Cart as CustomerCart;

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
        $couponCode = $this->_checkoutSession->getTestData();
        $check = $giftcard->load($couponCode,'code');
        if($check->getGiftcard_id()){
            $balance =$check->getBalance();
            if($total->getGrandTotal() - $balance >0){
                $baseDiscount=$balance;
            }
            else{
                $baseDiscount =$total->getGrandTotal();
            }
            $this->_discount = $baseDiscount;
            $total->setGrandTotal($total->getGrandTotal() - $baseDiscount);
            $total->setBaseGrandTotal($total->getBaseGrandTotal() - $baseDiscount);

            return $this;
        }else{
            $this->_discount =0;
            $this->_checkoutSession->unsTestData();
        }
    }

    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $this->_checkoutSession->setDicount($this->_discount);
        return [
            'code' => 'custom_discount',
            'title' => 'Gift Card',
            'value' => -$this->_discount,
        ];
    }
}
