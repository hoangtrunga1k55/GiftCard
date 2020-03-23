<?php
namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\Context;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $_postFactory;
    protected $_helper;
    protected $_orderFactory;
    protected $orderRepository;
    protected $_checkoutSession;

    public function __construct(
        Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory,
        \Magento\Checkout\Helper\Cart $helper,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Checkout\Model\Session $checkoutSession

    )
    {
        $this->_postFactory = $postFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
        $this->_helper = $helper;
        $this->orderRepository = $orderRepository;
        return parent::__construct($context);

    }


    public function getRealOrderId()
    {
        $lastorderId = $this->_checkoutSession->getLastOrderId();
        return $lastorderId;
    }

    public function getOrder()
    {
        if ($this->_checkoutSession->getLastRealOrderId()) {
            $order = $this->_orderFactory->create()->loadByIncrementId($this->_checkoutSession->getLastRealOrderId());
            return $order;
        }
        return false;
    }



    public function execute()
    {
        echo $this->_checkoutSession->getTestData();
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $collections = $objectManager->create('Magento\Sales\Model\Order')->getCollection();
//        $i=0;
//        foreach($collections as $collection){
//            if($i == 0){
//                $firstItem = $collection;
//                $i++;
//            } else{
//                $lastItem = $collection;
//            }
//        }
//        $array = (array) $lastItem;
//        var_dump($lastItem->getEntity_id());
//        $orders = $objectManager->create('Magento\Sales\Model\Order')->load(000000242);
//        $array = (array) $orders;
//        var_dump($orders);
//        $firstItem = $orders->getFirstItem();
//        $lastItem = $orders->getLastItem();
//        var_dump($firstItem);
//        var_dump( (array) $orders );
//        $array = (array) $orders;
//        $fruit = array_pop($array);
//        var_dump($fruit);
//        echo $orders->getSize();



//        $objectManager =  \Magento\Framework\App\ObjectManager::getInstance();
//        $orderDatamodel = $objectManager->get('Magento\Sales\Model\Order')->getCollection()->getLastItem();
//        $orderId   =   $orderDatamodel->getId();
//        $order = $objectManager->create('\Magento\Sales\Model\Order')->load($orderId);
//        $orderItems = $order->getAllItems();
//
//        foreach ($orderItems as $item) {
//            $product_name=   $item->getName();
//            echo $product_name;
//            $product_id=   $item->getProductId();
//            echo $product_id;
//        }

//        $this->_checkoutSession->getQuote()->reserveOrderId();
//        $reservedOrderId = $this->_checkoutSession->getQuote()->getReservedOrderId();
//        echo $reservedOrderId;
//
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $checkout_session = $objectManager->get('Magento\Checkout\Model\Session');
//        $order = $checkout_session->getLastRealOrder();
//        $orderId= $order->getEntityId();
//        echo $order->getIncrementId();
//
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $checkout_session = $objectManager->get('Magento\Checkout\Model\Session');
//        $order = $checkout_session->getLastRealOrder();
//        $orderId= $order->getEntityId();
//        echo $order->getIncrementId();
//
//        $order = $this->_checkoutSession->getLastRealOrder();
//        $orderId=$order->getEntityId();
//        echo $orderId;
//        echo $order->getIncrementId();
//        var_dump($this->getRealOrderId());
//        $product_id=2047;
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $product = $objectManager->get('Magento\Catalog\Model\Product')->load($product_id);
//        echo $product->getName();
//        echo $product->getGiftcard_amount();
//
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
//
//        $totalItems = $cart->getQuote()->getItemsCount();
//        $totalQuantity = $cart->getQuote()->getItemsQty();
//        echo $helper = $this->_helper->getItemsCount();
//        echo $totalItems."x";
//        echo $totalQuantity;
//        $post = $this->_postFactory->create();
//        $collection = $post->getCollection();
//        $post->load(1);
//        echo "<pre>";
//        print_r($post->getData());
//        echo "</pre>";
//
//        echo $collection->getSelect()->__toString();
//        echo "<pre>";
//        print_r($collection->getData());
//        echo "</pre>";
    }
}
