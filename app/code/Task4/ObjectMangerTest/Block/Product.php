<?php
namespace Task4\ObjectManagerTest\Block;
class Product extends \Magento\Framework\View\Element\Template
{
	private $_productFactory; 

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
	    array $data = []
	) 
	{
	    parent::__construct($context, $data);
	}

	public function loadMyProduct($sku)
	{
		$objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$productRepository = $objectManager->get('\Magento\Catalog\Model\ProductRepository'); 
		$product = $productRepository->get($sku);
	    return $this->product;
	}
}