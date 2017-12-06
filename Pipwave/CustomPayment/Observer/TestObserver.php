<?php
namespace Pipwave\CustomPayment\Observer;

use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use \Magento\Framework\Controller\ResultFactory;

use \Pipwave\CustomPayment\Block\InformationNeeded as Information;

/**
 * Class TestObserver
 */
class TestObserver implements ObserverInterface
{

    protected $_responseFactory;
    protected $_url;
    
    protected $iinformation;
    
     public function __construct(
        \Magento\Framework\App\ResponseFactory $responseFactory,
        \Magento\Framework\UrlInterface $url,
        Information $information
    ) {
        $this->_responseFactory = $responseFactory;
        $this->_url = $url;
        $this->iinformation = $information;
    }
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /*
        $event = $observer->getEvent();
        $CustomRedirectionUrl = $this->_url->getUrl('Pipwave/CustomPayment/Controller/Index/Index');
        $this->_responseFactory->create()->setRedirect($CustomRedirectionUrl)->sendResponse();
        return $this;
        
        */
        $information = $this->iinformation;
        $information->getManager();
        
        $information->setDData();
        $this->data = $information->getDData();
        
        //var_dump($this->data);
        
        $information->setSignatureParam();
        $information->insertSignature();
        
        $this->data = $information->getDData();
        //echo '<br>data with signature';
        //var_dump($this->data);
        
        $this->url = $information->getUrl();
        //echo '<br>var dump url';
        //var_dump($this->url);
        
        //echo 'i used the sendRequest() here and get this';
        $information->sendRequest();
        
        //from sendRequest()
        $temp = $information->getResponse();
        
    }
}