<?php
namespace OpenTechiz\Blog\Controller\Notification;
use \Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\Data\NotificationInterface;
use OpenTechiz\Blog\Model\ResourceModel\Notification\Collection as NotificationCollection;

class Seen extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    protected $_notificationCollectionFactory;

    protected $_customerSession;

    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Notification\CollectionFactory $notificationCollectionFactory,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_notificationCollectionFactory = $notificationCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {

        if(!$this->_customerSession->isLoggedIn()) return false;
        $user_id = $this->_customerSession->getCustomer()->getId();
        
        $totalUnreadNotifications = $this->_notificationCollectionFactory
            ->create()
            ->addFieldToFilter('is_viewed', 0)
            ->addFieldToFilter('user_id', $user_id);

        foreach ($totalUnreadNotifications as $notification) {
            if(!$notification->isViewed())
            {
                $notification->isViewed(1);
                $notification->save();
            }
        }
        $jsonResultResponse = $this->_resultJsonFactory->create();
        return $jsonResultResponse->setData('success');
    }
}