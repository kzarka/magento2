<?php 
namespace OpenTechiz\Blog\Helper;
use Magento\Framework\App\Action\Action;
class Post extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    protected $_resultPageFactory;
    
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \OpenTechiz\Blog\Model\Post $post,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    )
    {
        $this->_post = $post;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    
    public function prepareResultPost(Action $action, $postId = null)
    {
        if ($postId !== null && $postId !== $this->_post->getId()) {
            $delimiterPosition = strrpos($postId, '|');
            if ($delimiterPosition) {
                $postId = substr($postId, 0, $delimiterPosition);
            }
            if (!$this->_post->load($postId)) {
                return false;
            }
        }
        if (!$this->_post->getId()) {
            return false;
        }
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->addHandle('blog_post_view');
        
        $resultPage->addPageLayoutHandles(['id' => $this->_post->getId()]);
        $this->_eventManager->dispatch(
            'opentechiz_blog_post_render',
            ['post' => $this->_post, 'controller_action' => $action]
        );
        return $resultPage;
    }
}