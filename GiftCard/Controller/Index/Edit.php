<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\Context;

class Edit extends \Magento\Framework\App\Action\Action
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

    public function editData($post,$id){
        $data = $post->load($id);
        if ($post->getData('giftcard_id')) {
            $data->addData(array('code'=> $_POST['code'],
                'balance' => $_POST['balance'],
                'create_from' => $_POST['creatfrom']))->save();
            echo "Success";
        } else {
            echo "Post id does not exist";
        }
    }

    public function execute()
    {
       var_dump($this->getRequest()->getParams());
//        var_dump($this->getRequest()->getPostValue('code')); getPost()
        $post = $this->_postFactory->create();
        $id = $this->getRequest()->getParam('id');
        $this->editData($post,$id);
        // return $this->_redirect('giftcard/index/listdata');


    }
}
