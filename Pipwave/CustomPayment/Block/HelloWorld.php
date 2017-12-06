<?php
namespace Pipwave\CustomPayment\Block;

class HelloWorld extends \Magento\Framework\View\Element\Template
{        
    
    
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    )
    {  
        parent::__construct($context, $data);
    }
    
    public function getHelloWorld()
    {
        return 'Hello World';
    }
    
    protected $objectManager;
    public function initObjectManager()
    {
        $this->objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }
    // to getApiKey, getApiSecret, getTestMode, getProcessingFee
    // admin config data
    public function getAdminData()
    {
        return $this->objectManager->get('Pipwave\CustomPayment\Helper\Data');
    }    
    
    public function getCustomerData()
    {
        return $this->objectManager->get('Magento\Customer\Model\Session');
    }
    
    public function getUrlLink()
    {
        return $this->objectManager->get('Pipwave\CustomPayment\Model\Url');
    }
    ////////////////////////////////////////////////////////////////
    
    protected $data;
    protected $signature_param;
    protected $url;
    public function doAll()
    {
        $information = $this->objectManager->get('Pipwave\CustomPayment\Block\InformationNeeded');
        $information->getManager();
        
        $information->setDData();
        $this->data = $information->getDData();
        
        //var_dump($this->data);
        
        $information->setSignatureParam();
        $information->insertSignature();
        
        $this->data = $information->getDData();
        //echo '<br>data with signature';
        var_dump($this->data);
        
        $this->url = $information->getUrl();
        //echo '<br>var dump url';
        var_dump($this->url);
        
        //echo 'i used the sendRequest() here and get this';
        $information->sendRequest();
        
        //from sendRequest()
        $temp = $information->getResponse();
        var_dump($temp);
        
        $information->render();
        $form = $information->getResult();
        var_dump($form);
        echo $form;
        
        
    }
    
    public function sendRequest()
    {
        $information = $this->objectManager->get('Pipwave\CustomPayment\Model\PipwaveIntegration');
        $information->getManager();
        
        $agent = $ful->getAgent();
        
        return $ful->sendRequestToPw($this->data, $this->data['api_key'], $this->url, $agent);
    }
}