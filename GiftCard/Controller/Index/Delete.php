<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\Context;

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
            echo "Success";
        } else {
            echo "Post id does not exist";
        }
    }

    public function execute()
    {

        $post = $this->_postFactory->create();
        $id = $this->getRequest()->getParam('id');
        $this->deleteData($post,$id);

        return $this->_redirect('giftcard/index/listdata');

    }
}
