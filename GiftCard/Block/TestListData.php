<?php

namespace Mageplaza\GiftCard\Block;

use Magento\Framework\View\Element\Template\Context;
use Mageplaza\GiftCard\Model\GiftCardFactory;
/**
 * Test List block
 */
class TestListData extends \Magento\Framework\View\Element\Template
{
    public function __construct(
        Context $context,
        GiftCardFactory $test
    ) {
        $this->_test = $test;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Gift Card'));

        return parent::_prepareLayout();
    }

    public function getTestCollection()
    {

        $test = $this->_test->create();
        $collection = $test->getCollection();
        return $collection;
    }

    public function getActionUrl (){
        return $this->getUrl('giftcard/index/addData');
}
}
