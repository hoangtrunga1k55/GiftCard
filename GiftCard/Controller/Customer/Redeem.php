<?php

namespace Mageplaza\GiftCard\Controller\Customer;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Model\ResourceModel\Customer as CustomerResourceModel;

class Redeem extends \Magento\Framework\App\Action\Action
{
    protected $_postFactory;
    protected $_cardFactory;
    protected $_customer;
    protected $currentCustomer;
    protected $customerRepository;
    protected $customerResourceModel;
    protected $check =0;

    public function __construct(
        Context $context,
        \Mageplaza\GiftCard\Model\GiftCardFactory $postFactory,
        \Mageplaza\GiftCard\Model\HistoryFactory $cardFactory,
        \Magento\Customer\Model\CustomerFactory $customer,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        CustomerRepositoryInterface $customerRepository,
        CustomerResourceModel $customerResourceModel
    )
    {
        $this->_postFactory = $postFactory;
        $this->_cardFactory = $cardFactory;
        $this->_customer = $customer;
        $this->currentCustomer = $currentCustomer;
        $this->customerRepository = $customerRepository;
        $this->customerResourceModel = $customerResourceModel;
        parent::__construct($context);

    }

    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function checkCode($collection,$code){
        foreach ($collection as $collect){
            if($code==$collect->getCode()){
                $this->check =1;
                return $collect;
                break;
            }
        }

    }

    public function addHistory($card,$data){
        if($data!=null){
            $card->addData($data)->save();
            echo "Success";
        }
        else{
            echo "ko co gia tri";
        }
}

    public function getGiftCard($collection,$code){
        foreach ($collection as $a){
            if($a->getCode()==$code){
                return $a->getGiftcard_id();
                break;
            }
        }
    }
    public function execute()
    {
        $post = $this->_postFactory->create();
        $card = $this->_cardFactory->create();
        $customer = $this->_customer->create();
        $code = $this->getRequest()->getPostValue('code');
        $collection = $post->getCollection();
        $id_cus =$this->getCustomer()->getId();
        $collect =$this->checkCode($collection,$code);
            if($collect){
                if($collect->getBalance()>0){
                    $id = $this->getGiftCard($collection,$code);
                    ///update set where customer_id = 1
                    $this->customerResourceModel->getConnection()->update(
                        $this->customerResourceModel->getTable('customer_entity'),
                        [
                            'giftcard_balance' => $customer->load($id_cus)->getGiftcard_balance()+$post->load($id)->getBalance(),
                        ],
                        $this->customerResourceModel->getConnection()->quoteInto('entity_id = ?', $id_cus)
                    );
                    $action = "Redeem";
                    $data = [
                        'giftcard_id'=>$id,
                        'customer_id' => $this->getCustomer()->getId(),
                        'action' => $action,
                        'amount'=> $post->load($id)->getBalance()
                    ];
                    $this->addHistory($card,$data);
                    $post->load($id)->addData(array('balance'=>0,'amount_used'=>$post->load($id)->getBalance()))->save();
                    $this->messageManager->addSuccessMessage(__("Success"));
                    $this->_redirect('giftcard/customer/index');
                }
                else{
                    $this->messageManager->addErrorMessage(__("Out of money"));
                    $this->_redirect('giftcard/customer/index');
                }
            }
            else{
                $this->messageManager->addErrorMessage(__("Cant find code"));
                $this->_redirect('giftcard/customer/index');
            }

    }
}
