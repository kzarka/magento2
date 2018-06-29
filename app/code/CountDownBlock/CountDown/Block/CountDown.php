<?php
namespace CountDownBlock\CountDown\Block;
class CountDown extends \Magento\Framework\View\Element\Template implements \Magento\Widget\Block\BlockInterface
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('clock.phtml');
    }
}