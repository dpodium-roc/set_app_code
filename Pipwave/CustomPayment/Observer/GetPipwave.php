<?php
namespace Pipwave\CustomPayment\Observer;

use \Magento\Framework\Event\Observer;

class GetPipwave implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $text='hi i am here';
        return $text;
    }
}