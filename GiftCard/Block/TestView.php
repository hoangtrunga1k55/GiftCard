<?php

namespace Mageplaza\GiftCard\Block;

use Magento\Framework\View\Element\Template\Context;
use Mageplaza\GiftCard\Model\GiftCardFactory;
/**
 * Test View block
 */
class TestView extends \Magento\Framework\View\Element\Template
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
        $this->pageConfig->getTitle()->set(__('Gift Card '));

        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
//        var_dump($this->getRequest()->getParams());/// post va get
        $id = $this->getRequest()->getParam('id');
        /// ->getPostValue();
        $test = $this->_test->create();
        $singleData = $test->load($id);
        return $singleData;
    }
    public function getActionUrl (){
        return $this->getUrl('giftcard/index/edit');
    }
}
