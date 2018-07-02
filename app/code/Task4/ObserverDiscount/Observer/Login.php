<?php 

namespace Task4\ObserverDiscount\Observer;

use Magento\Framework\Event\ObserverInterface;

class Login implements ObserverInterface
{

	protected $_catalogSession;

	protected $_checkoutSession;
 
    public function __construct( 
        \Magento\Catalog\Model\Session $catalogSession,
        \Magento\Checkout\Model\Session $checkoutSession)
    {
        $this->_catalogSession = $catalogSession;
        $this->_checkoutSession = $checkoutSession;
    }
    public function execute(\Magento\Framework\Event\Observer $observer)
   {
   		$couponCode = "DISCOUNT50";
        $customer = $observer->getEvent()->getCustomer();
        $this->_registry->register('user_name', $customer->getName());
        $quote = $observer->getEvent()->getQuote();
        $quote->setCouponCode($couponCode)
            ->save();

        return $this;
   }

}