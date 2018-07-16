<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class CommentList extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{
	protected $_commentCollectionFactory;

	protected $_request;

	protected $_resultJsonFactory;

	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		\OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
		\Magento\Framework\App\RequestInterface $request,
		array $data = []
	)
	{
		$this->_commentCollectionFactory = $commentCollectionFactory;
		$this->_resultJsonFactory = $resultJsonFactory;
		$this->_request = $request;
		parent::__construct($context, $data);
	}

	protected function _prepareLayout()
	{
	    parent::_prepareLayout();

	    if ($this->getComments()) {
	        $pager = $this->getLayout()->createBlock(
	            'Magento\Theme\Block\Html\Pager',
	            'blog.comment.pager'
	        )
	        ->setAvailableLimit(array(5=>5,10=>10,15=>15))
	        ->setShowPerPage(true)
	        ->setShowAmounts(false)
	        ->setCollection(
	            $this->getComments()
	        );
	        $this->setChild('pager', $pager);
	        $this->getComments()->load();
	    }
	    return $this;
	}

	public function getPagerHtml()
	{
	    return $this->getChildHtml('pager');
	}

	public function getPostId()
	{
		return $this->_request->getParam('post_id', false);
	}

	public function getComments()
	{
		$post_id = $this->getPostId();
		$page = $this->_request->getParam('page', false);
		if(!$this->hasData("cmt")) {
			$comments = $this->_commentCollectionFactory
				->create()
				->addFieldToFilter('post_id', $post_id)
				->addFieldToFilter('is_active', 1)
				->addOrder(
					CommentInterface::CREATION_TIME,
					CommentCollection::SORT_ORDER_DESC
				)
        		->setCurPage($page);
			$this->setData("cmt",$comments);
		}
		return $this->getData("cmt");
	}

	public function getIdentities()
    {
        $identities = [];
		foreach ($this->getComments() as $comment) {
			//$identities = array_merge($identities, $comment->getIdentities());
			$identities = array_merge($identities, $comment->getIdentities());
		}
		$identities[] = \OpenTechiz\Blog\Model\Comment::CACHE_COMMENT_POST_TAG.'_'.$this->getPostId();
		return $identities;
    }

}