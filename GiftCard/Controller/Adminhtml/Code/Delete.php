<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Phrase;
use Magento\Framework\Math\Random ;

class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_postFactory;

    public function __construct(
        Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory
    )
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public  function deleteData($post,$id){
        $data = $post->load($id);
        if ($post->getData('giftcard_id')) {
            $post->delete();
           $this->messageManager->addSuccessMessage(__("Delete Successful"));
        } else {
            $this->messageManager->addSuccessMessage(__("Didnt exist id"));
        }
    }

    public function execute()
    {
        $post = $this->_postFactory->create();
        $this->deleteData($post,$this->getRequest()->getParam('id'));
        return $this->_redirect('giftcard/code/index');
    }
}
