<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    function __construct(
        \Magento\Framework\App\Action\Context $context,
        \OpenTechiz\Blog\Model\Post $post
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_post = $post;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->_resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $postData = (array) $this->getRequest()->getPost();

        if (!empty($postData)) {
            // Retrieve your form data
            $author   = $postData['author'];
            $content    = $postData['content'];
            $post_id = $postData['post_id'];

            $this->_post->load($post_id);
            $urlPost = $this->_post->getUrl();

            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);

            $comment->save();
            // Display the succes form validation message
            $this->messageManager->addSuccessMessage('Comment added succesfully!');
            if($urlPost)
            {
                $resultRedirect->setUrl($urlPost);
            } else $resultRedirect->setUrl('/magento2/blog/');
            return $resultRedirect;
        }
        
        $resultRedirect->setUrl('/magento2/blog/');
        return $resultRedirect;
    }
}