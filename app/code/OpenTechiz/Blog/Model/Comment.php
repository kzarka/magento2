<?php
namespace OpenTechiz\Blog\Model;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Comment extends \Magento\Framework\Model\AbstractModel implements CommentInterface,IdentityInterface
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED =2;
    const STATUS_PENDING = 0;
	const CACHE_TAG='opentechiz_blog_comment';

	function _construct()
	{
		$this->_init('OpenTechiz\Blog\Model\ResourceModel\Comment');
	}
	
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled'), self::STATUS_PENDING => __('Pending')];
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    /**
     * @{initialize}
     */
    function getID(){
        return $this->getData(self::COMMENT_ID);
    }

    /**
     * @{initialize}
     */
    function getContent(){
        return $this->getData(self::CONTENT);
    }
    /**
     * @{initialize}
     */
    function getPostID(){
        return $this->getData(self::POST_ID);
    }
    /**
     * @{initialize}
     */
    function getAuthor(){
        return $this->getData(self::AUTHOR);
    }
    /**
     * @{initialize}
     */
    function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }
    /**
     * @{initialize}
     */

    function isActive(){
        return $this->getData(self::IS_ACTIVE);
    }
    
    function setID($id){
        $this->setData(self::COMMENT_ID,$id);
        return $this;
    }
    /**
     * @{initialize}
     */
    function setAuthor($author){
        $this->setData(self::AUTHOR,$author);
        return $this;
    }
    /**
     * @{initialize}
     */
    function setContent($content){
        $this->setData(self::CONTENT,$content);
        return $this;
    }
    /**
     * @{initialize}
     */
    function setPostID($postId){
        $this->setData(self::POST_ID,$postId);
        return $this;
    }

    /**
     * @{initialize}
     */
    function setCreationTime($creatTime){
        $this->setData(self::CREATION_TIME,$creatTime);
        return $this;
    }

    function setIsActive($isActive){
        $this->setData(self::IS_ACTIVE,$isActive);
        return $this;
    }
}