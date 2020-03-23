<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\Context;

class Curd extends \Magento\Framework\App\Action\Action
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

    public function editData($post,$id){
        $data = $post->load($id);
        if ($post->getData('giftcard_id')) {
            $post->addData(array('code'=>'hoang binh','balance'=>'136500'))->save();
            echo "Success";
        } else {
            echo "Post id does not exist";
        }
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

   public function showData($post){
       $collection = $post->getCollection();
       foreach($collection as $item){
           echo "<pre>";
           print_r($item->getData());
           echo "</pre>";
       }
       exit();
       return $this->_pageFactory->create();
   }
    public function execute()
    {
        $post = $this->_postFactory->create();
        $array = (array) $post->load(1);
        var_dump($array);
        $data = [
            'code' => "Hoang Trung",
            'balance' => 300000,
            'amount_used' => 13000,
            'create_from' => 'admin',
        ];

//        $this->addData($post,$data);
//        $this->editData($post,5);
//        $this->deleteData($post,2);
//        $this->showData($post);

    }
}
