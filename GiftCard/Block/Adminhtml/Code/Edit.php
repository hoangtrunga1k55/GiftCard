<?php
namespace Mageplaza\GiftCard\Block\Adminhtml\Code;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $_coreRegistry;

    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\Block\Widget\Context $context,
        array $data = []
    )
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_objectId = 'id';
        $this->_blockGroup = 'Mageplaza_GiftCard';
        $this->_controller = 'adminhtml_code';
        parent::_construct();

        $this->buttonList->add(
            'save_and_continue',
            [
                'label' => __('Save and Continue Edit'),
                'class' => 'save',
                'data_attribute' => [
                    'mage-init' => [
                        'button' => [
                            'event' => 'saveAndContinueEdit',
                            'target' => '#edit_form'
                        ]
                    ]
                ]
            ],
            -100
        );

//        $this->buttonList->add(
//            'delete',
//            [
//                'label' => __('Delete'),
//                'onclick' => 'deleteConfirm(' . json_encode(__('Are you sure you want to do this?'))
//                    . ','
//                    . json_encode($this->getUrl('giftcard/code/delete/',[
//                        'idlll'=>$this->getRequest()->getParam('id'),
//                        'test'=> 'acv'
//                    ])
//                    )
//                    . ')',
//                'class' => 'scalable delete',
//                'level' => -1
//            ]
//        );
    }

}
