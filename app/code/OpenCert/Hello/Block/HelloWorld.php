<?php
namespace OpenCert\Hello\Block;
//use OpenCert\Hello\Controller\Index\Index;
class Helloworld extends \Magento\Framework\View\Element\Template
{

	protected $_registry;
	protected $_catalogSession;
    protected $_productCollectionFactory;
    protected $_catalogProductVisibility;
    protected $_categoryFactory;


	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Product\Visibility $catalogProductVisibility,
        //CookieManagerInterface $cookieManager,
        array $data = []
    ) {
        $this->_registry = $registry;
        $this->_catalogSession = $catalogSession;
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->_catalogProductVisibility = $catalogProductVisibility;
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
   	}

    public function getHelloWorldTxt()
    {
        return 'Hello world!'.$this->_registry->registry('custom_var');

    }

    public function getCatalogSession() 
    {
        return $this->_catalogSession;
    }

    public function recentProduct()
    {
        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $collection = $this->_productCollectionFactory->create();
        $collection->setVisibility($this->_catalogProductVisibility->getVisibleInCatalogIds());

        $collection->addAttributeToSort('created_at', 'asc')
            ->addAttributeToSelect('*')
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getCurrentPage());
        return $collection;
    }

    public function getCategory($categoryId)
    {
        $this->_category = $this->_categoryFactory->create();
        $this->_category->load($categoryId);
        
        return $this->_category;
    }

}