<?php 

namespace Task4\ObserverDiscount\Observer;

use Magento\Framework\Event\ObserverInterface;

class Discount implements ObserverInterface
{

    protected $_customerSession;

    protected $_checkoutSession;
 
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Framework\Registry $registry)
    {
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        //parent::__construct($context);
    }

    public function execute(\Magento\Framework\Event\Observer $observer) {
        if ($this->_customerSession->isLoggedIn()) {
            $couponCode = "DISCOUNT50";
            $this->_checkoutSession->getQuote()->setCouponCode($couponCode)
                ->collectTotals()
                ->save();

            return $this;
        }
    }
}