<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class TestComment extends \Magento\Framework\View\Element\Template
{
	protected $_commentCollectionFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
		array $data = []
	)
	{
		$this->_commentCollectionFactory = $commentCollectionFactory;
		parent::__construct($context, $data);
	}

	public function getComments()
	{
		if(!$this->hasData("cmt")) {
			$comments = $this->_commentCollectionFactory
				->create()
				->addOrder(
					CommentInterface::CREATION_TIME,
					CommentCollection::SORT_ORDER_DESC
				);
			$this->setData("cmt",$comments);
		}
		return $this->getData("cmt");
	}

}