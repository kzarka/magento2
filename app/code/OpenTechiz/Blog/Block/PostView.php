<?php
namespace OpenTechiz\Blog\Block;
class PostView extends \Magento\Framework\View\Element\Template implements
    \Magento\Framework\DataObject\IdentityInterface
{
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \OpenTechiz\Blog\Model\Post $post,
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_post = $post;
        $this->_postFactory = $postFactory;
    }

    public function _prepareLayout()
    {
       //set page title
        $post = $this->getPost();

       $this->pageConfig->getTitle()->set(__($post->getTitle()));

       return parent::_prepareLayout();
    }

    public function getPost()
    {
        if (!$this->hasData('post')) {
            if ($this->getPostId()) {
                $post = $this->_postFactory->create();
            } else {
                $post = $this->_post;
            }
            $this->setData('post', $post);
        }
        return $this->getData('post');
    }

    public function getIdentities()
    {
        return [\OpenTechiz\Blog\Model\Post::CACHE_TAG . '_' . $this->getPost()->getId()];
    }
}