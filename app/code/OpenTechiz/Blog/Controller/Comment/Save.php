<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Save extends Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultFactory;

    function __construct(
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
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

            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);

            $comment->save();
            // Display the succes form validation message
            $this->messageManager->addSuccessMessage('Comment added succesfully!');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            return $resultRedirect;
        }
        
        $resultRedirect->setUrl('/magento2/blog/');
        return $resultRedirect;
    }
}