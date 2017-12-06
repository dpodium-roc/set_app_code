<?php
namespace Pipwave\CustomPayment\Controller\Notification;

//Pipwave send information to this (notification url)
class Index extends \Magento\Framework\App\Action\Action
{
    protected $checkout;
    protected $order;
    protected $information;
    protected $info;
    protected $pipwaveIntegration;
    protected $NotificationInformationFactoryDB;
    protected $NotificationInformationFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Checkout\Model\Session $checkout,
        \Magento\Sales\Model\Order $order,
        //this infomationNeeded is to give Pipwave
        \Pipwave\CustomPayment\Block\InformationNeeded $information,
        //this info is info received from Pipwave
        \Pipwave\CustomPayment\Block\Adminhtml\Order\View\Info $info,
        \Pipwave\CustomPayment\Model\PipwaveIntegration $pipwaveIntegration,
        \Pipwave\CustomPayment\Model\ResourceModel\NotificationInformationFactory $NotificationInformationFactoryDB,
        \Pipwave\CustomPayment\Model\NotificationInformationFactory $NotificationInformationFactory
    ) {
        parent::__construct($context);
        $this->checkout = $checkout;
        $this->order = $order;
        $this->information = $information;
        $this->info = $info;
        $this->pipwaveIntegration = $pipwaveIntegration;
        $this->NotificationInformationFactoryDB = $NotificationInformationFactoryDB;
        $this->NotificationInformationFactory = $NotificationInformationFactory;
    }

    public function execute()
    {
        header('HTTP/1.1 200 OK');
        echo "OK";
        //IPN from Pipwave
        $post_data = json_decode(file_get_contents('php://input'), true);

        $this->info->setDData($post_data);
        $signature = $this->info->getSignature();
        $signatureParam = $this->info->get_signatureParam();
        $newSignature = $this->pipwaveIntegration->generatePwSignature($signatureParam);

        //DO NOT DELETE
        //check signature and newSignature
        $this->info->compareSignature($signature, $newSignature);

        $order_number = $post_data['txn_id'];
        //get order using increment id
        $order = $this->order->loadByIncrementId($order_number);
        $transaction_status = $this->info->getTransactionStatus();
        $refund = $this->info->getRefund();
        $txn_sub_status = $this->info->getTransactionSubStatus();
        
        //testing status other than 10
        //$transaction_status = 2;
        
        //modify transaction status
        $order = $this->information->processNotification($transaction_status, $order, $refund, $txn_sub_status);

        $rule_action = $this->info->getPipwaveScore();
        $pipwave_score = $this->info->getRuleAction();
        $message = $this->info->getMessage();

        //add to comment (view in admin interface, order>information>scroll down)
        $order->addStatusHistoryComment('Rule Action: ' . $rule_action)->setIsCustomerNotified(false);
        if ($pipwave_score != '') {
            $order->addStatusHistoryComment('Pipwave Score: ' . $pipwave_score)->setIsCustomerNotified(false);
        }
        if ($message != '') {
            $order->addStatusHistoryComment('message from Pipwave: ' . $message)->setIsCustomerNotified(false);
        }
        $order->save();

        //get data for database
        $data = $this->info->getDData();

        //set and save into database
        $NotificationInformationModel = $this->NotificationInformationFactory->create();

        $NotificationInformationModel->setData($data);
        $NotificationInformationDB = $this->NotificationInformationFactoryDB->create()->save($NotificationInformationModel);
    }
    
}