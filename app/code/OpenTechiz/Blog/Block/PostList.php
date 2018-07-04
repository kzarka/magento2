<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class PostList extends \Magento\Framework\View\Element\Template
{
	protected $_postCollectionFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory $postCollectionFactory,
		array $data = []
	)
	{
		$this->_postCollectionFactory = $postCollectionFactory;
		parent::__construct($context, $data);
	}

	public function getPosts()
	{
		if(!$this->hasData("posts")) {
			$posts = $this->_postCollectionFactory
				->create()
				->addFilter('is_active', 1)
				->addOrder(
					PostInterface::CREATION_TIME,
					PostCollection::SORT_ORDER_DESC
				);
			$this->setData("posts",$posts);
		}
		return $this->getData("posts");
	}

}