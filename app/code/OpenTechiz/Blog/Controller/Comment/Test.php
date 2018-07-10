<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;

class Test extends Action
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
        \Psr\Log\LoggerInterface $logger,
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollection,
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->commentFactory = $commentFactory;
        $this->_logger = $logger;
        $this->postFactory = $postFactory;
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_sendEmail = $sendEmail;
        $this->_userCollection = $userCollection;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        $post = $this->commentFactory->create();
        $post->load(52);
        echo $post->getUserID();
        print_r($post->getData());
        $this->_logger->info('Start Observer'); 
        die();
    }
}