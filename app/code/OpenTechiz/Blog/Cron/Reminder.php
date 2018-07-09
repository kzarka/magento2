<?php
namespace OpenTechiz\Blog\Cron;

class Reminder {
    protected $_sendEmail;

    protected $_commentCollectionFactory;

    public function __construct(
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
        
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail
    ) 
    {
        $this->_commentCollectionFactory = $commentCollectionFactory;
        $this->_sendEmail = $sendEmail;
    }

    public function execute() {
        $to = date("Y-m-d h:i:s"); // current date
        $from = strtotime('-1 day', strtotime($to));
        $from = date('Y-m-d h:i:s', $from); // 1 days before

        $comments = $this->_commentCollectionFactory
                ->create()
                ->addFieldToFilter('is_active', 0)
                ->addFieldToFilter('creation_time', ["lteq" => $from]);

        $commentCount = $comments->count();
        $this->_sendEmail->reminderEmail($commentCount);
    }

}