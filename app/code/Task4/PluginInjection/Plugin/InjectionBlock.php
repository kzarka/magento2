<?php
namespace Task4\PluginInjection\Plugin;
use Magento\Theme\Block\Html\Footer;
class InjectionBlock
{
    protected $_customerSession;
    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->_customerSession = $customerSession;
    }
    public function beforeToHtml(Footer $subject)
    {
        if ($subject->getNameInLayout() !== 'absolute_footer') {
            return;
        }
        $subject->setTemplate('Task4_PluginInjection::absolute_footer.phtml');
        $subject->assign('customer', $this->_customerSession->getCustomer());
    }
}