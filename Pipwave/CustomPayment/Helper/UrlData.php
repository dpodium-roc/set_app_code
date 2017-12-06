<?php
namespace Pipwave\CustomPayment\Helper;

//constant url
class UrlData {
    //url to fire api [get  from Pipwave]
    const URL = 'https://api.Pipwave.com/payment';
    const URL_TEST = 'https://staging-api.Pipwave.com/payment';

    //url to render sdk [get from Pipwave]
    const RENDER_URL = 'https://secure.Pipwave.com/sdk/';
    const RENDER_URL_TEST = 'https://staging-checkout.Pipwave.com/sdk/';

    //url for loading image [get from Pipwave]
    const LOADING_IMAGE_URL = 'https://secure.Pipwave.com/images/loading.gif';
    const LOADING_IMAGE_URL_TEST = 'https://staging-checkout.Pipwave.com/images/loading.gif';

    //url for controller [get from magento]
    const SUCCESS_URL = 'checkout/onepage/success';
    const FAIL_URL = 'checkout/onepage/failure';
    const NOTIFICATION_URL = 'notification/notification/index';
}