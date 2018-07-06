<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class SaveComment extends \Magento\Framework\View\Element\Template
{
	protected $_request;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Framework\App\RequestInterface $request,
		array $data = []
	)
	{
		$this->_request = $request;
		parent::__construct($context, $data);
	}

	public function getFormAction()
	{
		return '/magento2/blog/comment/save';
	}

	public function getPostID()
	{
		return $this->_request->getParam('post_id', false);
	}

}