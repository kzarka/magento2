<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
class Save extends \Magento\Backend\App\Action
{
    protected $_commentFactory;

    protected $_backendSession;

    public function __construct(
        \OpenTechiz\Blog\Model\CommentFactory $commentFactory,
        \Magento\Backend\Model\Session $backendSession,
        Action\Context $context
    )
    {
        $this->_commentFactory = $commentFactory;
        $this->_backendSession = $backendSession;
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::save_comment');
    }
    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \OpenTechiz\Blog\Model\Comment $model */
            $model = $this->_commentFactory->create();
            $id = $this->getRequest()->getParam('comment_id');
            if ($id) {
                $model->load($id);
            }
            $model->setData($data);
            $this->_eventManager->dispatch(
                'blog_comment_prepare_save',
                ['comment' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Comment.'));
                $this->_backendSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['comment_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the comment.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['comment_id' => $this->getRequest()->getParam('comment_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}