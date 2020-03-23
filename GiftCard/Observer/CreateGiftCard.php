<?php

namespace Mageplaza\GiftCard\Observer;

use Magento\Customer\Model\ResourceModel\Customer as CustomerResourceModel;
use Magento\Framework\Math\Random;
use Magento\Framework\App\Action\Context;
use Magento\Checkout\Model\Cart;

class CreateGiftCard implements \Magento\Framework\Event\ObserverInterface
{
    protected $mathRandom;
    protected $_postFactory;
    protected $helper;
    protected $helperData;
    protected $currentCustomer;
    protected $_customer;
    protected $customerResourceModel;

    public function __construct(
        Context $context,
        Random $mathRandom,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory,
        \Mageplaza\GiftCard\Helper\Data $helperData,
        \Magento\Catalog\Model\ProductFactory $_productloader,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Mageplaza\GiftCard\Model\HistoryFactory $historyFactory,
        \Magento\Customer\Model\CustomerFactory $customer,
        CustomerResourceModel $customerResourceModel

    )
    {
        $this->mathRandom = $mathRandom;
        $this->_postFactory = $postFactory;
        $this->helperData = $helperData;
        $this->_productloader = $_productloader;
        $this->_history = $historyFactory;
        $this->currentCustomer = $currentCustomer;
        $this->customerResourceModel = $customerResourceModel;
        $this->_customer = $customer;
    }

    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if ($this->helperData->getGiftCard_Enable_Moudule()) {
            $quote = $observer->getEvent()->getQuote();
            $order = $observer->getEvent()->getOrder();

            $listProduct = $quote->getAllVisibleItems();
            $length = $this->helperData->getGeneralConfig();
            $customer = $this->_customer->create();
            $id_cus = $this->getCustomer()->getId();
            //set balance for user
            $this->customerResourceModel->getConnection()->update(
                $this->customerResourceModel->getTable('customer_entity'),
                [
                    'giftcard_balance' => $customer->load($id_cus)->getGiftcard_balance() - $quote->getGrandTotal(),
                ],
                $this->customerResourceModel->getConnection()->quoteInto('entity_id = ?', $id_cus)
            );

            foreach ($listProduct as $item) {
                $product = $this->_productloader->create();
                $product->load($item->getProductId());
                if ($product->getTypeId() == "virtual") {
                    if ($product->getGiftcard_amount() > 0) {
                        for ($i = 1; $i <= $item->getQty(); $i++) {
                            $post = $this->_postFactory->create();
                            $history = $this->_history->create();
                            $random = $this->mathRandom->getRandomString($length);
                            $post->addData(array(
                                'code' => $random,
                                'create_from' => "order increment #" . $order->getIncrementId(),
                                'balance' => $product->getGiftcard_amount()
                            ))->save();
                            $history->addData(array(
                                'action' => 'create',
                                'amount' => $product->getGiftcard_amount(),
                                'giftcard_id' => $post->getGiftcard_id(),
                                'customer_id' => $this->getCustomer()->getId()
                            ))->save();
                        }
                    }
                }

            }
        }
    }
}

