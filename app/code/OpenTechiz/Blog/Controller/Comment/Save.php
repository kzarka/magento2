<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;

class Save extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    protected $_inlineTranslation;

    protected $_transportBuilder;

    protected $_scopeConfig;

    protected $_sendEmail;

    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_sendEmail = $sendEmail
        parent::__construct($context);
    }

    public function execute()
    {
        $error = false;
        $message = '';
        $postData = (array) $this->getRequest()->getPostValue();

        if(!$postData)
        {
            $error = true;
            $message = "Your submission is not valid. Please try again!";
        }
        $this->_inlineTranslation->suspend();
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($postData);

        // validate data
        if(!\Zend_Validate::is(trim($postData['author']), 'NotEmpty'))
        {
            $error = true;
            $message = "Name can not be empty!";
        }

        $jsonResultResponse = $this->_resultJsonFactory->create();
        if(!$error)
        {
            // save data to database
            $author   = $postData['author'];
            $content    = $postData['content'];
            $post_id = $postData['post_id'];
            $email = $postData['email'];

            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);
            $comment->setEmail($email);

            $comment->save();
            $jsonResultResponse->setData([
                'result' => 'success',
                'message' => 'Thank you for your submission. Our Admins will review and approve shortly'
            ]);

            // send email to user
            $this->_sendEmail->approvalEmail($email, $author);
        } else {
            $jsonResultResponse->setData([
                'result' => 'error',
                'message' => $message
            ]);     
        }

        return $jsonResultResponse;
    }
}