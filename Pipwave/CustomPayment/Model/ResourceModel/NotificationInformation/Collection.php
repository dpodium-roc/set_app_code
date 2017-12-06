<?php
namespace Pipwave\CustomPayment\Model\ResourceModel\NotificationInformation;
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Pipwave\CustomPayment\Model\NotificationInformation',
            'Pipwave\CustomPayment\Model\ResourceModel\NotificationInformation'
            );
    }
}