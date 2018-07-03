<?php
namespace Task4\ProductFactoryTest\Block;
class Product extends \Magento\Framework\View\Element\Template
{
	private $_productFactory; 

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
	    \Magento\Catalog\Model\ProductFactory $productFactory,
	    array $data = []
	) 
	{
	    $this->_productFactory = $productFactory;
	    parent::__construct($context, $data);
	}

	public function loadMyProduct($sku)
	{
		$product = $this->_productFactory->create();
		$product->load($product->getIdBySku($sku));
	    return $product;
	}
}