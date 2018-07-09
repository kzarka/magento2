<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;

class Mail extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    protected $_inlineTranslation;

    protected $_transportBuilder;

    protected $_scopeConfig;

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
        $this->sendEmail = $sendEmail;
        parent::__construct($context);
    }

    public function execute()
    {
        $email = 'nhtienptit@gmail.com';
        $name = "Tien";
        $this->sendEmail->approvalEmail($email, $name);
    }
}