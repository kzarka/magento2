<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;

class Save extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_commentFactory;

    protected $_resultJsonFactory;

    protected $_inlineTranslation;

    protected $_transportBuilder;

    protected $_scopeConfig;

    protected $_sendEmail;

    protected $_customerSession;

    function __construct(
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\Session $customerSession,
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_commentFactory = $commentFactory;
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_sendEmail = $sendEmail;
        $this->_customerSession = $customerSession;
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

        // declare user
        $customer = null;
        if($this->_customerSession->isLoggedIn())
        {
            $customer = $this->_customerSession->getCustomer();
            $postData['author'] = $customer->getName();
            $postData['email'] = $customer->getEmail();
            $postData['user_id'] = $customer->getId();
        }
        else if(!\Zend_Validate::is(trim($postData['author']), 'NotEmpty'))
        {
            // validate data
            $error = true;
            $message = "Name can not be empty!";
        }

        $jsonResultResponse = $this->_resultJsonFactory->create();
        if(!$error)
        {
            // save data to database
            $author = $postData['author'];
            $content = $postData['content'];
            $post_id = $postData['post_id'];
            $email = $postData['email'];
            $comment = $this->_commentFactory->create();
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);
            $comment->setEmail($email);
            if(isset($postData['user_id'])){
                $comment->setUserID($postData['user_id']);
            }

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