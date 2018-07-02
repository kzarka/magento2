<?php 

namespace Task4\ObserverLogs\Observer;

use Magento\Framework\Event\ObserverInterface;

class LogsAction implements ObserverInterface
{
	/**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $_logger;

    public function __construct(
        //\Magento\Framework\App\Action\Context $context,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_logger = $logger;
        //parent::__construct($context);
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
   {
       $request = $observer->getEvent()->getControllerAction()->getRequest(); 
       $actionName = $request->getFullActionName();
       $this->_logger->addInfo($actionName);
   }

}