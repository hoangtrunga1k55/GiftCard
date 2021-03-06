<?php
namespace Mageplaza\GiftCard\Model\ResourceModel\History;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'history_id';

    protected function _construct()
    {
        $this->_init(\Mageplaza\GiftCard\Model\History::class, \Mageplaza\GiftCard\Model\ResourceModel\History::class);
    }
}
