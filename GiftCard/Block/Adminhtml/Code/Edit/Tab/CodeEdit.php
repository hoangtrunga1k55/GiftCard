<?php
namespace Mageplaza\GiftCard\Block\Adminhtml\Code\Edit\Tab;
use Mageplaza\GiftCard\Block\TestView;



class CodeEdit extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $block;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        array $data = [],
        TestView $aaa
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
        $this->block = $aaa;
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create();
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Gift Card Information')]);


        $fieldset->addField(
            'code', ///database field
            'text',
            [
                'label' => __('Code '),
                'name' => 'code',
                'required' => false,
                'maxlength' => '255',
                'value' => $this->block->getSingleData()->getCode(),
                'readonly' =>true
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
                'value' => $this->block->getSingleData()->getBalance(),
                'class' => 'validate-not-negative-number'
            ]
        );

        $fieldset->addField(
            'create_from', ///database field
            'text',
            [
                'label' => __('create_from'),
                'name' => 'create_from',
                'required' => false,
                'maxlength' => '255',
                'value' => $this->block->getSingleData()->getCreate_from(),
                'readonly' => true
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
