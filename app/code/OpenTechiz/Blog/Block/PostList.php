<?php
namespace OpenTechiz\Blog\Block;
use OpenTechiz\Blog\Api\Data\PostInterface;
use OpenTechiz\Blog\Model\ResourceModel\Post\Collection as PostCollection;

class PostList extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
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

	protected function _prepareLayout()
	{
	    parent::_prepareLayout();
	    $this->pageConfig->getTitle()->set(__('Blog Post'));


	    if ($this->getPosts()) {
	        $pager = $this->getLayout()->createBlock(
	            'Magento\Theme\Block\Html\Pager',
	            'blog.post.pager'
	        )
	        ->setAvailableLimit(array(5=>5,10=>10,15=>15))
	        ->setShowPerPage(true)
	        ->setShowAmounts(false)
	        ->setCollection(
	            $this->getPosts()
	        );
	        $this->setChild('pager', $pager);
	        $this->getPosts()->load();
	    }
	    return $this;
	}

	public function getPagerHtml()
	{
	    return $this->getChildHtml('pager');
	}

	public function getPosts()
	{
		//get values of current page
        $page=($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
    	//get values of current limit
        $pageSize=($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 1;
		if(!$this->hasData("posts")) {
			$posts = $this->_postCollectionFactory
				->create()
				->addFieldToFilter('is_active', 1)
				->addOrder(
					PostInterface::CREATION_TIME,
					PostCollection::SORT_ORDER_DESC
				)
				->setPageSize($pageSize)
        		->setCurPage($page);
			$this->setData("posts",$posts);
		}
		return $this->getData("posts");
	}

	public function getIdentities()
	{
		$identities = [];
		$posts = $this->getPosts();
		foreach ($posts as $post) {
			$identities = array_merge($identities, $post->getIdentities());
		}
		$identities[] = \OpenTechiz\Blog\Model\Post::CACHE_TAG . '_' . 'list';
		return $identities;
	}
}