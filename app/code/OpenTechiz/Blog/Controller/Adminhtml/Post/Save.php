<?php
namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action;
use OpenTechiz\Blog\Model\Post;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    
    const ADMIN_RESOURCE = 'OpenTechiz_Blog::post';    

    protected $_postFactory;

    protected $_backendSession;

    public function __construct(
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \Magento\Backend\Model\Session $backendSession,
        Action\Context $context
    )
    {
        $this->_postFactory = $postFactory;
        $this->_backendSession = $backendSession;
        parent::__construct($context);
    }
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::save');
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
            $model = $this->_postFactory->create();
            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                $model->load($id);
            }
            $model->setTitle($data['title']);
            $model->setContent($data['content']);
            $model->setUrlKey($data['url_key']);
            $model->setIsActive($data['is_active']);
            $this->_eventManager->dispatch(
                'blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Post.'));
                $this->_backendSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the post.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
