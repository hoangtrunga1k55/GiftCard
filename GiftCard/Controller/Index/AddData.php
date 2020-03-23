<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\Context;

class AddData extends \Magento\Framework\App\Action\Action
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

    public function addData($post,$data){
        if($data!=null){
            $post->addData($data)->save();
            echo "Success";
        }
        else{
            echo "ko co gia tri";
        }
    }

    public function execute()
    {
        $post = $this->_postFactory->create();
        $data = [
            'code' => $_POST['code'],
            'balance' => $_POST['balance'],
            'create_from' => $_POST['creatfrom'],
        ];
        $this->addData($post,$data);
        return $this->_redirect('giftcard/index/listdata');

    }
}
