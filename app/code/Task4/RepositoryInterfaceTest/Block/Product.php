<?php
namespace Task4\RepositoryInterfaceTest\Block;
class Product extends \Magento\Framework\View\Element\Template
{
	private $_productRepository; 

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
	    \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
	    array $data = []
	) 
	{
	    $this->_productRepository = $productRepository;
	    parent::__construct($context, $data);
	}

	public function loadMyProduct($sku)
	{
	    return $this->_productRepository->get($sku);
	}
}