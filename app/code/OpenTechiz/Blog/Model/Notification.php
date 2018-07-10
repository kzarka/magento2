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
    function getID(){
        return $this->getData(self::NOTI_ID);
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

    function getUserID(){
        return $this->getData(self::USER_ID);
    }


    function getCreationTime(){
        return $this->getData(self::CREATION_TIME);
    }
    
    function setID($id){
        $this->setData(self::NOTI_ID,$id);
        return $this;
    }
    /**
     * @{initialize}
     */
    function setUserID($userID){
        $this->setData(self::USER_ID,$userID);
        return $this;
    }

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

}