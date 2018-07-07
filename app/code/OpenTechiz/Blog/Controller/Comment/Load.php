<?php
namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
use OpenTechiz\Blog\Api\Data\CommentInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class Load extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;

    protected $_commentCollectionFactory;

    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory $commentCollectionFactory,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_commentCollectionFactory = $commentCollectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $postData = (array) $this->getRequest()->getPostValue();
        $post_id = $postData['post_id'];

        $jsonResultResponse = $this->_resultJsonFactory->create();
        $comments = $this->_commentCollectionFactory
            ->create()
            ->addFilter('post_id', $post_id)
            ->addFilter('is_active', 1)
            ->addOrder(
                CommentInterface::CREATION_TIME,
                CommentCollection::SORT_ORDER_DESC
            )->toArray();
        $jsonResultResponse->setData($comments);
        return $jsonResultResponse;
    }
}