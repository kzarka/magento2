<?php
namespace OpenTechiz\Blog\Model\ResourceModel;

class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	protected function _construct()
	{
        $this->_init('opentechiz_blog_comment', 'comment_id');
    }
}