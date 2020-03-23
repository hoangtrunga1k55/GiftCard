<?php

namespace Mageplaza\GiftCard\Controller\Adminhtml\Code;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Math\Random ;

class Save extends \Magento\Framework\App\Action\Action
{
    protected $_postFactory;
    protected  $mathRandom;

    public function __construct(
        Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory,
        Random $mathRandom
    )
    {
        $this->mathRandom = $mathRandom;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }


    public function addData($post,$xxx){
            $post->addData($xxx)->save();
            $this->messageManager->addSuccessMessage(__("Save success"));
    }

    public function editData($post,$id,$xxx){
        $data = $post->load($id);
        if ($post->getData('giftcard_id')) {
            $post->addData($xxx)->save();
          $this->messageManager->addSuccessMessage(__("Edit and save success"));
        } else {
            $this->messageManager->addError(__("Didnt exist id"));
        }
    }

    public function execute()
    {
        $post = $this->_postFactory->create();
        $length = $this->getRequest()->getPostValue('length');
        if($length){
            $random = $this->mathRandom->getRandomString($length);
        }
        else{
            $random = $this->getRequest()->getPostValue('code');
        }

        if($this->getRequest()->getParam('id')){
            $id = $this->getRequest()->getParam('id');
        }
        else{
            $id = $post->getGiftcard_id();
        }

        if($this->getRequest()->getParam('create_from')){
            $create_from = $this->getRequest()->getParam('create_from');
        }
        else{
            $create_from = 'admin';
        }

       $xxx = array(
           'code' => $random,
           'balance' => $this->getRequest()->getParam('balance'),
           'create_from'=> $create_from
       );
        if($this->getRequest()->getParam('back')){
            if(!$id){
                $this->addData($post,$xxx);
                $id = $post->getGiftcard_id();
                return $this->_redirect('giftcard/code/editpage/',[
                    'id'=>$id
                    ]
                );
            }
            else{
                $this->editData($post,$id,$xxx);
                return $this->_redirect('giftcard/code/editpage/',[
                    'id'=>$id
                ]);
            }
        }
        else{
            if(!$id){
                $this->addData($post,$xxx);
            }
            else{
                $this->editData($post,$id,$xxx);
            }
            return $this->_redirect('giftcard/code/index');
        }
     }
}
