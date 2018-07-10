<?php 

namespace OpenTechiz\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;

class Approval implements ObserverInterface
{
    protected $_postFactory;

    protected $_customerSession;

    protected $_checkoutSession;

    protected $_notiFactory;
 
    public function __construct(
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \OpenTechiz\Blog\Model\NotificationFactory $notiFactory
    )
    {
        $this->_postFactory = $postFactory;
        $this->_notiFactory = $notiFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $comment = $observer->getData('comment');
        $request = $observer->getData('request');
        // new comment then return
        if(!$request->getParam('comment_id')) return;
        $newStatus = $request->getParam('is_active');
        $oldStatus = $comment->isActive();

        $user_id = $comment->getUserID();
        $post_id = $comment->getPostID();
        $comment_id = $comment->getID();
        // if user_id null then return
        if(!$user_id) return;

        if($oldStatus != 0) return;
        if($newStatus == null) return;
        if($newStatus == 2) return;
        if($oldStatus == $newStatus) return;
        // get post info

        $post = $this->_postFactory->create()->load($post_id);
        $postTitle = $post->getTitle();
        $noti = $this->_notiFactory->create();
        $content = "Your comment ID: $comment_id at Post: $postTitle has been approved by Admin";
        $noti->setContent($content);
        $noti->setUserID($user_id);
        $noti->setCommentID($comment_id);
        $noti->setPostID($post_id);
        $noti->save();
    }
}