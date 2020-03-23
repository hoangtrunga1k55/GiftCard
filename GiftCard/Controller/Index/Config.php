<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\Exception\LocalizedException;

class Config extends \Magento\Framework\App\Action\Action
{

    protected $helperData;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Mageplaza\GiftCard\Helper\Data $helperData

    )
    {
        $this->helperData = $helperData;
        return parent::__construct($context);
    }

    public function getCode(){
        return  $code  = $this->helperData->getGeneralConfig();
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        $code  = $this->helperData->getGeneralConfig();
        echo $code;
        exit();

    }
}
