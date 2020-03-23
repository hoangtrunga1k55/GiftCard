<?php

namespace Mageplaza\GiftCard\Controller\Index;

use Magento\Framework\App\Action\AbstractAction;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\RequestInterface;

abstract class Index extends AbstractAction
{
    protected $_eventManager;
    public function __construct(Context $context)
    {
        $this->_eventManager = $context->getEventManager();
    }
    public function dispatch(RequestInterface $request)
    {
        $eventParameters = ['controller_action' => $this, 'request' => $request];
        $this->_eventManager->dispatch(
            'controller_action_predispatch_' . $request->getFullActionName(),
            $eventParameters
        );
    }
}
