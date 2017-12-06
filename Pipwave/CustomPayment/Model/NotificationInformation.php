<?php
namespace Pipwave\CustomPayment\Model;

class NotificationInformation extends \Magento\Framework\Model\AbstractModel
{
    public function _construct()
    {
        //parent::_construct();
        $this->_init('Pipwave\CustomPayment\Model\ResourceModel\NotificationInformation');
    }
}