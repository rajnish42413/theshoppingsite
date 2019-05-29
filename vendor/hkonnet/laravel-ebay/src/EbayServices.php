<?php

namespace Hkonnet\LaravelEbay;

use DTS\eBaySDK\Sdk;
use DB;
use App\ApiSetting;
class EbayServices
{
    private $sdk;

    function __construct()
    {
        $ebay = new Ebay();
        $config = $ebay->getConfig();
		$api_setting = ApiSetting::where('api_name','ebay')->first();
		
		if($api_setting && $api_setting->count() > 0 && $api_setting->mode == 'production'){	
		
			$config = Array(
				'credentials' => Array(
						'devId' => $api_setting->developer_id,
						'appId' => $api_setting->app_id,
						'certId' => $api_setting->certificate_id
				),
				'siteId' => 0,
				'sandbox' =>false
			);
		}	

        $this->sdk = new Sdk($config);
    }

    function __call($name, $args)
    {
        if (strpos($name, 'create') === 0) {
            $service = 'create'.substr($name, 6);
            $configuration = isset($args[0]) ? $args[0] : [];
            return $this->sdk->$service($configuration);
        }
    }

}
