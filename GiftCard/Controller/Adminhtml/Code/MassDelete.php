<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Mageplaza\GiftCard\Model\ResourceModel\GiftCard\CollectionFactory;
use Zend\Mvc\Router\Http\Method;

class MassDelete extends \Magento\Backend\App\Action
{
    protected $filter;

    protected $collectionFactory;

    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $block) {
            $block->delete();
        }
        if($collectionSize>0){
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        }
        else{
            $this->messageManager->addError(__('Didnt columns is selected'));
        }
        
        return $this->_redirect('giftcard/code/index');
    }
}
