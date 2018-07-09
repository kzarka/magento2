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
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\User\Model\ResourceModel\User\CollectionFactory $userCollection,
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_sendEmail = $sendEmail;
        $this->_userCollection = $userCollection;
        parent::__construct($context);
    }

    public function execute()
    {
        
        $admins = $this->_userCollection->create();
        foreach ($admins as $admin) {
            $email = $admin->getEmail();
            $name = $admin->getUserName();
            $this->_sendEmail->reminderEmail(5, $email, $name);
        }
    }
}