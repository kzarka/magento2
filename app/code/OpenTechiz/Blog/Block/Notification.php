<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class Notification extends \Magento\Framework\View\Element\Template
{
	protected $_request;

	protected $_customerSession;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\Magento\Customer\Model\Session $customerSession,
		\Magento\Framework\App\RequestInterface $request,
		array $data = []
	)
	{
		$this->_request = $request;
		$this->_customerSession = $customerSession;
		parent::__construct($context, $data);
	}

	public function getSeenUrl()
	{
		return '/magento2/blog/notification/seen';
	}
	public function isLoggedIn()
	{
		return $this->_customerSession->isLoggedIn();
	}

}