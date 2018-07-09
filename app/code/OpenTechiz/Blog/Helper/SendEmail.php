<?php 
namespace OpenTechiz\Blog\Helper;
use Magento\Framework\App\Action\Action;
class SendEmail extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    protected $_transportBuilder;

    protected $_scopeConfig;
    
    public function __construct(
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Helper\Context $context
    )
    {
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }
    
    public function approvalEmail($email, $name)
    {
        $postObject = new \Magento\Framework\DataObject();
        $data['name'] = $name;
        $postObject->setData($data);

        $sender = [
                'name' => 'Test Name',
                'email' => 'tiensendemail@gmail.com'
            ];

        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
        $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->_scopeConfig->getValue('blog/general/template', $storeScope))
            ->setTemplateOptions(
                [
                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($sender)
            ->addTo($email)
            ->getTransport()
            ->sendMessage();
    }

    public function reminderEmail()
    {
        $postObject = new \Magento\Framework\DataObject();
        $data['name'] = $name;
        $data['comment_count'] = 5;
        $postObject->setData($data);

        $sender = [
                'name' => 'Test Name',
                'email' => 'tiensendemail@gmail.com'
            ];
        
        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
        //get admin's email
        $email = $this->_scopeConfig->getValue('trans_email/ident_support/email', $storeScope);
        $name  = $this->_scopeConfig->getValue('trans_email/ident_support/name', $storeScope);

        $transport = $this->_transportBuilder
            ->setTemplateIdentifier($this->_scopeConfig->getValue('blog/reminder/template', $storeScope))
            ->setTemplateOptions(
                [
                    'area' => \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                ]
            )
            ->setTemplateVars(['data' => $postObject])
            ->setFrom($sender)
            ->addTo($email)
            ->getTransport()
            ->sendMessage();
    }
}