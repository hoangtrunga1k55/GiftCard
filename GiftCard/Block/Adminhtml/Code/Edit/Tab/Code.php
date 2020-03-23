<?php
namespace Mageplaza\GiftCard\Block\Adminhtml\Code\Edit\Tab;

use Mageplaza\GiftCard\Helper\Data;
use Magento\Framework\Message\ManagerInterface;

class Code extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $helperData;
public function __construct(
    \Magento\Backend\Block\Template\Context $context,
    \Magento\Framework\Registry $registry,
    \Magento\Framework\Data\FormFactory $formFactory,
    Data $helperData,
    array $data = []
    )
{
parent::__construct($context, $registry, $formFactory, $data);
    $this->helperData = $helperData;
}

protected function _prepareForm()
{
$form = $this->_formFactory->create();

    $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Gift Card Information')]);

    $fieldset->addField(
        '', ///database field
        'text',
        [
            'label' => __('Code Length'),
            'name' => 'length',
            'required' => false,
            'maxlength' => '255',
            'value' => $this->helperData->getGeneralConfig(),
            'class' => 'validate-not-negative-number'

        ]
    );
    $fieldset->addField(
        'balance', ///database field
        'text',
        [
            'label' => __('Balance'),
            'name' => 'balance',
            'required' => true,
            'maxlength' => '255',
            'class' => 'validate-not-negative-number'
        ]
    );
$this->setForm($form);
return parent::_prepareForm();
}


public function getTabLabel()
{
return __('Gift card information');
}

public function getTabTitle()
{
return $this->getTabLabel();
}

public function canShowTab()
{
return true;
}

public function isHidden()
{
return false;
}
}
