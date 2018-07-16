<?php
namespace OpenTechiz\Blog\Model;
use OpenTechiz\Blog\Api\Data\NotificationInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Notification extends \Magento\Framework\Model\AbstractModel implements NotificationInterface,IdentityInterface
{

	const CACHE_TAG='opentechiz_blog_comment_approval_notification';

	function _construct()
	{
		$this->_init('OpenTechiz\Blog\Model\ResourceModel\Notification');
	}
	
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    /**
     * @{initialize}
     */
    function getId(){
        return $this->getData(self::NOTI_ID);
    }

    function getContent(){
        return $this->getData(self::CONTENT);
    }

    function getPostId(){
        return $this->getData(self::POST_ID);
    }

    function getUserId(){
        return $this->getData(self::USER_ID);
    }

    function getCommentId(){
        return $this->getData(self::COMMENT_ID);
    }

    function isViewed($isViewed = null){
        $result = $this->getData(self::IS_VIEWED);
        if($isViewed != null)
        {
            $this->setData(self::IS_VIEWED, $isViewed);
        }
        return $result;
    }

    function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }
    
    function setId($id){
        $this->setData(self::NOTI_ID,$id);
        return $this;
    }
    
    function setUserId($userID){
        $this->setData(self::USER_ID,$userID);
        return $this;
    }

    function setContent($content){
        $this->setData(self::CONTENT,$content);
        return $this;
    }
    
    function setPostId($postId){
        $this->setData(self::POST_ID,$postId);
        return $this;
    }

    function setCommentId($commentID){
        $this->setData(self::COMMENT_ID, $commentID);
        return $this;
    }

    function setCreationTime($creatTime){
        $this->setData(self::CREATION_TIME,$creatTime);
        return $this;
    }

}