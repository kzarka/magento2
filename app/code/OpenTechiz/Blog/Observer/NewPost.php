<?php 

namespace OpenTechiz\Blog\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Indexer\CacheContext;
use Magento\Framework\Event\ManagerInterface as EventManager;

class NewPost implements ObserverInterface
{
    protected $_cacheContext;

    protected $_eventManager;
 
    public function __construct(
        CacheContext $cacheContext,
        EventManager $eventManager
    )
    {
        $this->_cacheContext = $cacheContext;
        $this->_eventManager = $eventManager;
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        $post = $observer->getData('post');
        $original = $post->getOrigData();
        // if not new post then return
        if(!$post->isObjectNew()) return;
        $status = $post->isActive();

        if($status != 1) return;

        // clean cache
        $this->_cacheContext->registerEntities(\OpenTechiz\Blog\Model\Post::CACHE_TAG, ['list']);
        $this->_eventManager->dispatch('clean_cache_by_tags', ['object' => $this->_cacheContext]);
    }
}