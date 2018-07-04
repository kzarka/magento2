<?php
namespace OpenTechiz\Blog\Controller;

class Router implements \Magento\Framework\App\RouterInterface
{

    protected $actionFactory;

    protected $_eventManager;

    protected $_postFactory;

    public function __construct(
        \Magento\Framework\App\ActionFactory $actionFactory,
        \OsmanSorkar\Blog\Model\PostFactory $postFactory,
    ) {
        $this->actionFactory = $actionFactory;
        $this->_postFactory = $postFactory;
    }

    public function match(\Magento\Framework\App\RequestInterface $request)
    {
        $url_key = trim($request->getPathInfo(), '/blog/');
        $url_key = rtrim($url_key, '/');

        $post = $this->_postFactory->create();
        $post_id = $post->checkUrlKey($url_key);
        if (!$post_id) {
            return null;
        }
        $request->setModuleName('blog')->setControllerName('view')->setActionName('index')->setParam('post_id', $post_id);
        $request->setAlias(\Magento\Framework\Url::REWRITE_REQUEST_PATH_ALIAS, $url_key);
        return $this->actionFactory->create('Magento\Framework\App\Action\Forward');
    }
}