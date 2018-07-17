<?php
namespace OpenTechiz\Blog\CustomerData;
use Magento\Customer\CustomerData\SectionSourceInterface;
use OpenTechiz\Blog\Api\Data\NotificationInterface;
use OpenTechiz\Blog\Model\ResourceModel\Notification\Collection as NotificationCollection;
class LoadNotification extends \Magento\Framework\DataObject implements SectionSourceInterface
{
    protected $_notificationCollectionFactory;

    protected $_customerSession;

    public function __construct(
        \OpenTechiz\Blog\Model\ResourceModel\Notification\CollectionFactory $notificationCollectionFactory,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->_notificationCollectionFactory = $notificationCollectionFactory;
        $this->_customerSession = $customerSession;
    }
    /**
     * {@inheritdoc}
     */
    public function getSectionData()
    {
        if(!$this->_customerSession->isLoggedIn()) return [];
        $count = $this->getUnreadNotifications()->count();
        $notification = $this->getNotifications();

        return [
            'count' => $count,
            'countCaption' => $count == 1 ? __('1 unread Notifications') : __('%1 unread Notifications', $count),
            'items' => count($notification) ? $notification : [],
        ];
    }
    /**
     * @return array
     */
    protected function getUnreadNotifications()
    {
        $items = [];
        $userId = $this->getUserId();
        
        $items = $this->_notificationCollectionFactory
            ->create()
            ->addFieldToFilter('is_viewed', 0)
            ->addFieldToFilter('user_id', $userId);
        return $items;
    }
    /**
     * @return array
     */
    protected function getNotifications()
    {
        $items = [];
        $userId = $this->getUserId();
        $notifications = $this->_notificationCollectionFactory
            ->create()
            ->addFieldToFilter('user_id', $userId)
            ->addOrder(
                NotificationInterface::CREATION_TIME,
                NotificationCollection::SORT_ORDER_DESC
            );
        foreach ($notifications as $item) {
            $items[] = [
                'id' => $item->getId(),
                'content' => $item->getContent(),
                'creation_time' => $item->getCreationTime(),
                'is_viewed' => $item->isViewed()
            ];
        }
        return $items;
    }

    protected function getUserId()
    {
        return $this->_customerSession->getCustomer()->getId();
    }
}