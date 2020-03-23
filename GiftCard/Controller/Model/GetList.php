<?php
namespace Mageplaza\GiftCard\Controller\Model;

use Magento\Framework\App\Action\Context;

class GetList extends \Magento\Framework\App\Action\Action
{
    protected $_postFactory;

    public function __construct(
        Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory
    )
    {
        $this->_postFactory = $postFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->_postFactory->create();
        $collection = $post->getCollection();
        $post->load(1);
        echo "<pre>";
        print_r($post->getData());
        echo "</pre>";

        echo $collection->getSelect()->__toString();
        echo "<pre>";
        print_r($collection->getData());
        echo "</pre>";
    }
}
