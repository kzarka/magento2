<?php
namespace OpenTechiz\Blog\Model\ResourceModel\Notification;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	
	/**
     * @var string
     */
    protected $_idFieldName = 'noti_id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Notification', 'OpenTechiz\Blog\Model\ResourceModel\Notification');
    }
}