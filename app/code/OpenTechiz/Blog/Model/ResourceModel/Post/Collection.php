<?php
namespace OpenTechiz\Blog\Model\ResourceModel\Post;
/**
 * Class Collection
 * @package OsmanSorkar\Blog\Model\ResourceModel\Post
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	
	/**
     * @var string
     */
    protected $_idFieldName = 'post_id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Post', 'OpenTechiz\Blog\Model\ResourceModel\Post');
    }
}