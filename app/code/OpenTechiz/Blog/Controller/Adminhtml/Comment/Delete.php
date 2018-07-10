<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
class Delete extends \Magento\Backend\App\Action
{
    protected $_commentFactory;

    function __construct(
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory,
        \Magento\Backend\App\Action\Context $context
    )
    {
        $this->_commentFactory = $commentFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::delete_comment');
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('comment_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_commentFactory->create();
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The comment has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['comment_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a comment to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
