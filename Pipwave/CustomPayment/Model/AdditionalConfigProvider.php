<?php
namespace Pipwave\CustomPayment\Model;

use \Pipwave\CustomPayment\Block\InformationNeeded as Information;

class AdditionalConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    protected $information;
    
    public function __construct(
            Information $information
        ) {
            $this->information = $information;
        }

    function getConfig()
    {

        $config =
        [
            'payment' => 
            [
                'Pipwave' =>
                [
                    //this need changes if possible.
                    //set $image_url = *something*
                    //then use magento framework to get url
                    //set $image_url into 'pipwaveImageSrc'
                    'pipwaveImageSrc' => 'https://www.Pipwave.com/wp-content/themes/zerif-lite-child/images/logo_bnw.png'
                ]
            ]
        ];
        
        return $config;
    }
}