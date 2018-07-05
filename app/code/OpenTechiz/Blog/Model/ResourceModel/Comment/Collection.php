<?php
namespace OpenTechiz\Blog\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	
	/**
     * @var string
     */
    protected $_idFieldName = 'comment_id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Comment', 'OpenTechiz\Blog\Model\ResourceModel\Comment');
    }
}