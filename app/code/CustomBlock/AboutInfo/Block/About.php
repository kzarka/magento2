<?php
namespace CustomBlock\AboutInfo\Block;
class About extends \Magento\Framework\View\Element\Template
{

	protected $_storeInfo;

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Store\Model\Information $storeInfo,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->_storeInfo = $storeInfo;
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
   	}

    public function getPhoneNumber()
    {
        return $this->scopeConfig->getValue(
            'general/store_information/phone',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}