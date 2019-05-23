<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

use \Hkonnet\LaravelEbay\EbayServices;
use \DTS\eBaySDK\Finding\Types;
use GuzzleHttp\Client;
use App\Product;
use App\Category;
use App\Brand;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

//@@@@@@@@@@@@@@@@@@@@@@ SANDBOX API @@@@@@@@@@@@@@@@@@@@@@@@@@@@//
	
    function byKeyword(Request $request) {
        $search = $request->input('search_value');
        $ebay_service = new EbayServices();
        $service = $ebay_service->createFinding();

        // Assign the keywords.
        $request = new Types\FindItemsByKeywordsRequest();
		//echo '<pre>'; print_r($request);die;
        $request->keywords =  $search;

        // Ask for the first 25 items.
        $request->paginationInput = new Types\PaginationInput();
        $request->paginationInput->entriesPerPage = 25;
        $request->paginationInput->pageNumber = 1;

        // Ask for the results to be sorted from high to low price.
        $request->sortOrder = 'CurrentPriceLowest';

        $response = $service->findItemsByKeywords($request);
		//echo '<pre>'; print_r($response);die;
		//echo $json = json_encode($response.true);die;
        // Output the response from the API.
        if ($response->ack !== 'Success') {
            echo 'no data found';
        } else {
            $products = $response->searchResult->item;
			
			if($products){
				foreach($products as $product){

					$check = array();					
					$check = Product::where('itemId',$product->itemId)->first(); 

					$input['itemId'] =  $product->itemId;
					$input['title'] =  $product->title;
					$input['globalId'] =  $product->globalId;
					
					$input['categoryId'] =  $product->primaryCategory->categoryId;
				
					
					$input['galleryURL'] =  $product->galleryURL;
					$input['viewItemURL'] =  $product->viewItemURL;
					
					$input['payment_method_ids'] =  '';
					
					$input['autoPay'] =  $product->autoPay;
					$input['postalCode'] =  $product->postalCode;
					$input['location'] =  $product->location;
					$input['country'] =  $product->country;
					
					$input['shippingInfo'] =  json_encode($product->shippingInfo);
					
					$input['current_price'] =  $product->sellingStatus->currentPrice->value;
					$input['current_price_currency'] =  $product->sellingStatus->currentPrice->currencyId;
					$input['converted_current_price'] =  $product->sellingStatus->convertedCurrentPrice->value;
					$input['converted_current_price_currency'] =  $product->sellingStatus->convertedCurrentPrice->currencyId;					
					$input['sellingState'] =  $product->sellingStatus->sellingState;
					$input['selling_time_left'] =  $product->sellingStatus->timeLeft;
					
					$input['listingInfo'] =  json_encode($product->listingInfo);
					
					$input['returnsAccepted'] =  $product->returnsAccepted;
					$input['return_condition'] =  json_encode($product->condition);
					
					$input['isMultiVariationListing'] =  $product->isMultiVariationListing;
					$input['topRatedListing'] =  $product->topRatedListing;	
					$input['updated_at'] =  date('Y-m-d H:i:s');					
					
					if($check && $check->count() > 0){
						$input['updated_at'] =  date('Y-m-d H:i:s');
						Product::where('itemId',$product->itemId)->update($input);	
					}else{
						$input['created_at'] =  date('Y-m-d H:i:s');
						Product::create($input)->id;	
					}
								
				}
				echo 'success';
			}

			//
           // return  compact('products');

        }
    }
	
    function getCategory(Request $request) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_SANDBOX_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_SANDBOX_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_SANDBOX_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetCategories',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                 <CategorySiteID>0</CategorySiteID>
                <DetailLevel>ReturnAll</DetailLevel>
                <ViewAllNodes>True</ViewAllNodes>
                <LevelLimit>2</LevelLimit>
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**HSTVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ajAZaAqQudj6x9nY+seQ**dNwEAA**AAMAAA**JmZomuhignjYHcDjY1NQcKgk4opikLEgwNIhdz7re+HC13f/7sU+O5vhMSjDzinVII9bKB9EWaIyr5acL54JgZg+MqltQu2WwjEPh8qXwvacJKubQfBhFCxbzVFmFsT74wzH4PRWDvZJhFjRlGZt9/+Hx2niyi9wjXg3JzbHacv54TGkRFIAqMRiCuf5tqb1hqKxDz4//4rym93AxAtSFehRXC74xiZ+KNzBMvFDisIEKmSIHfgFgxEBupgQxIXuAS3LPcZyyObHuZEJMIhvg+wflfsORQhmhkTL/DsiiyZCOQW+pQsYHKFKhA9oLclN99YvfUcqAHuw/GR+M0Tmn/ATE59m2stKa7PixEsbza3J2mxrZsHXVhKpJODt6RRLLE42AReCCaqEXhqAbsrgoezLB5zMi/J1GiGusvaLxvbUh9gg8S/wYkzE+TVgTKO5Ps7eQT1LXScrjeZ/2u5VqPAzaOWUtKW0etacZU5i+1uovvjOgaqdmNy3c357JPCxRoP20ZTj7y94jWLhGAQV0X3n+4qEJDxLP+AVOb9k/8d9pcxMwgXV4DkmzOyoS94QpP5c00oa6DwIhshnkrFKkm1DF7BJv2svCtmhDTB1o6GXJRJODbLPy8rlx6lkPcg2x1JyOl7K6Ho5LxUcTUjbo9q/shp7q2YMb25YfZwMAvnYSTM3M7TWA01ZZ8Ix8U7oW1490QPh7rliSJ1PI+tQ5B9pJGFkni/piM5HzLM50pqWqcCz7Q0GKeH0v8Rtc4QS</eBayAuthToken>
                 </RequesterCredentials>
                 </GetCategoriesRequest>';
        $response = $client->request('POST', 'https://api.sandbox.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $categories = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($categories);die;
        if ($categories->Ack == 'Success'){
            foreach($categories->CategoryArray->Category as $category){
				$input['categoryId'] = (string)$category->CategoryID;
				$input['categoryName'] = (string)$category->CategoryName;
				$p_id = (string)$category->CategoryParentID;
				if($input['categoryId'] == $p_id){
					$input['parentId'] = '0';
				}else{
					$input['parentId'] = $p_id;
				}
				$input['slug'] = $this->slugify($input['categoryName']);
				$input['updated_at'] =  date('Y-m-d H:i:s');
				
				
				//echo '<pre>'; print_r($input); echo '</pre>';
 				$cat_check = array();					
				$cat_check = Category::where('categoryId',$input['categoryId'])->first();
				
				if($cat_check && $cat_check->count() > 0){
					
					Category::where('categoryId',$input['categoryId'])->update($input);	
											
				}else{
					$input['created_at'] =  date('Y-m-d H:i:s');
					Category::create($input)->id;	
				} 				
					
            }
			echo 'success';
        }
    }	
	
    function getProductsByCategory(Request $request,$cat_id) {
		if($cat_id == ''){
			echo 'error. category not found';
			exit;
		}
		$search = array();
        $search[] = $cat_id; //parent category id
		$parent_id = $cat_id;
		//echo $search;die;
        $ebay_service = new EbayServices();
		
        $service = $ebay_service->createFinding();
		
        // Assign the keywords.
        $request = new Types\FindItemsByCategoryRequest();
		
        $request->categoryId =  $search;

        // Ask for the first 25 items.
        //$request->paginationInput = new Types\PaginationInput();
        //$request->paginationInput->entriesPerPage = 25;
        //$request->paginationInput->pageNumber = 1;

        // Ask for the results to be sorted from high to low price.
        $request->sortOrder = 'CurrentPriceLowest';
		//echo '<pre>'; print_r($request);die;
        $response = $service->findItemsByCategory($request);
		
		//echo $json = json_encode($response.true);die;
        // Output the response from the API.
        if ($response->ack !== 'Success') {
            echo 'no data found';
        } else {
            $products = $response->searchResult->item;
			//echo '<pre>'; print_r($products);die;
 			if($products){
				foreach($products as $product){

					$check = array();					
					$check = Product::where('itemId',$product->itemId)->first(); 

					$input['itemId'] =  $product->itemId;
					$input['title'] =  $product->title;
					$input['globalId'] =  $product->globalId;
					
					$input['categoryId'] =  $product->primaryCategory->categoryId;
					
					// Category Check
					$cat_check  = array();
					$cat_check  = Category::where('categoryId',$input['categoryId'])->first();
					if($cat_check && $cat_check->count() > 0){
						//nothing
					}else{
						$cdata['categoryId'] = $input['categoryId'];
						$cdata['parentId'] = $parent_id;
						$cdata['categoryName'] = $product->primaryCategory->categoryName;
						$cdata['slug'] = $this->slugify($cdata['categoryName']);
						$cdata['created_at'] = date('Y-m-d H:i:s');
						$cdata['updated_at'] = date('Y-m-d H:i:s');
						Category::create($cdata)->id;
					}
					
					
					$input['parentCategoryId'] =  $parent_id;
					$input['galleryURL'] =  $product->galleryURL;
					$input['viewItemURL'] =  $product->viewItemURL;					
					$input['payment_method_ids'] =  $product->paymentMethod[0];					
					$input['autoPay'] =  $product->autoPay;
					$input['postalCode'] =  $product->postalCode;
					$input['location'] =  $product->location;
					$input['country'] =  $product->country;
					$input['shippingInfo'] =  json_encode($product->shippingInfo);
					$input['current_price'] =  $product->sellingStatus->currentPrice->value;
					$input['current_price_currency'] =  $product->sellingStatus->currentPrice->currencyId;
					$input['converted_current_price'] =  $product->sellingStatus->convertedCurrentPrice->value;
					$input['converted_current_price_currency'] =  $product->sellingStatus->convertedCurrentPrice->currencyId;					
					$input['sellingState'] =  $product->sellingStatus->sellingState;
					$input['selling_time_left'] =  $product->sellingStatus->timeLeft;
					$input['listingInfo'] =  json_encode($product->listingInfo);
					$input['returnsAccepted'] =  $product->returnsAccepted;
					$input['return_condition'] =  json_encode($product->condition);
					$input['isMultiVariationListing'] =  $product->isMultiVariationListing;
					$input['topRatedListing'] =  $product->topRatedListing;	
					$input['updated_at'] =  date('Y-m-d H:i:s');
										
					$item_detail = array();
					$item_detail = $this->getSingleItem($input['itemId']); //API CALL
					
					if($item_detail){
						$input['PaymentMethods'] =  $item_detail['PaymentMethods'];	//string
						$input['Quantity'] = $item_detail['Quantity']; //string						
						$input['Description'] = $item_detail['Description']; //string
						$input['Seller'] = $item_detail['Seller']; //json
						$input['PictureDetails'] = $item_detail['PictureDetails']; //json
						$input['ItemSpecifics'] = $item_detail['ItemSpecifics']; //json
						$input['SellingStatus'] = $item_detail['SellingStatus']; //json
						$input['ShippingDetails'] = $item_detail['ShippingDetails']; //json
						$input['Variations'] = $item_detail['Variations']; //json
						if($item_detail['Brand'] != ''){
							$input3['name'] = $item_detail['Brand'];
							$input3['slug'] = $this->slugify($item_detail['Brand']);
							$input3['updated_at'] =  date('Y-m-d H:i:s');
							
							$brand_check = Brand::where('slug',$input3['slug'])->first();
							
							if($brand_check && $brand_check->count() > 0){
								
							    Brand::where('id',$brand_check['id'])->update($input3);	
								$input['brand_id'] = $brand_check['id'];
							}else{
								$input['created_at'] =  date('Y-m-d H:i:s');
								$input['brand_id'] = Brand::create($input3)->id;
							}
						}
					}
					
					
 					if($check && $check->count() > 0){
						
						Product::where('itemId',$product->itemId)->update($input);	
					}else{
						$input['created_at'] =  date('Y-m-d H:i:s');
						Product::create($input)->id;	
					} 
								
				}
				
				echo 'success';
			} 

        }
    }	
	
	
    function getSingleItem($item_id) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_SANDBOX_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_SANDBOX_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_SANDBOX_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetItem',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				 <DetailLevel>ReturnAll</DetailLevel>
				 <ItemID>'.$item_id.'</ItemID>
				 <IncludeItemSpecifics>true</IncludeItemSpecifics>			 
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**6XbBXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ajAZaApgSdj6x9nY+seQ**dNwEAA**AAMAAA**Km/jO8yBBu4IUNMSiSxd4rV5g75TwO7eJXdY4FRr7JyOiiYmAKXMRTrFvj2cS0gJAwpLvVJqNrLU71krD/clfDO63yRmnaepNDkhklE9EPipJjaBOWEBoy3uu/xZ/mIVVcXIXYc5vqvtZ9tgGpLiOE89UuBcOsi+JFmC/SLzx9FQISmep1a5rG/rYNuj1zZtTkOW7lc4s5inO7/1UN8UtBoWPX+INrq4tE4cvOC+X2uOdZvSuqzQJwaG+72R+A1pz4EqYJGx3efPslLTRSj3niZvpqyUlMjLM8vtiAb/s1DdxN1Dv78nrUXkPDwj6VNqKdDaiDtmKjmwepLelHskDTrFeQLTE/0NvZuYsK4v/VwdCXhfguvEOaSLGJJmr9LgUD9GxOxuxtYlyFjiuCSh4bIj3CRY7wvk/J9oAubfvtBopeJGbiPxbCtAy/f0bFVyxigFATE5ja27X/2+EAHjl5AhU/IW8i81+SHJxFDdW3gT9zeZe2zBFXO3UW0tcwMYOm0h57k3lp61ZJaiGLT12Mi340i0UOadyOipfYQi1P54nzZgSEN9tNg0LH/a4k7zOdAXZFL9dTiBrgZdMBqQmbTImKgHqSLIVCGPlQ2j7FCLuCh9HM8K9xYPreYQ+WMfUyjT9+FCQHE6AvAZclFnrb8gC2qeBjCrOKjOB/xzH0SMphxagf1drFC/zrI8ZzMNNGSdAfwDT6Axv0tYlJDXhlZQmbNvs5a3ZAMBrLixy/O4OUZTdh1foOmfvck8s1z/</eBayAuthToken>
                 </RequesterCredentials>
                 </GetItemRequest>';
        $response = $client->request('POST', 'https://api.sandbox.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $results = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($results); echo '</pre>';
		//return $results;
 		$detail = array();
        if ($results->Ack == 'Success'){
			$item = $results->Item;
			
			$detail['Quantity'] = (string)$item->Quantity;
			$detail['Seller'] = json_encode((array)$item->Seller); //for json
			$detail['PictureDetails'] = json_encode((array)$item->PictureDetails); //for json
			//$detail['ItemSpecifics'] = $item->ItemSpecifics->NameValueList[1]->value; //for json
			$ItemSpecifics = (array)$item->ItemSpecifics;
			//echo '<pre>';print_r($ItemSpecifics);die;
			$detail['Brand'] = '';
			foreach($ItemSpecifics as $is){
				if(isset($is[1]) && isset($is[1]->Name)){
					$s_name = (string)$is[1]->Name;
					if($s_name == 'Brand'){
						$detail['Brand']  =  (string)$is[1]->Value;//Brand Name Value
					}					
				}			
			}
			
			//die(' rk');
			return $detail;
        } 
    }
	
	//OTHER METHOD NOT USED
	public function getItem($item_id){
		
		$response = array();
		$results = array();
		$header = array(
			"Content-type: application/json",
			"Authorization: Bearer v^1.1#i^1#f^0#I^3#r^0#p^1#t^H4sIAAAAAAAAAOVYbWwURRjutddCKaX8QDBGzblgwkd2b3bv9nq3ckeuLaWH0BbuKF+SOrc71y692113Zm0PDNaaQICk/jCKgDFAghJRUDQ0EIghiGBUfli+IsSYYEwTE4nRKBJinL0r5VpJOUrBJt6fzc688877PO/z7rw3oLOkdPbGuo1/ljvGFe7qBJ2FDgdfBkpLiudMKip8rLgA5Bg4dnXO6HR2FfXNxTCVNKSlCBu6hpGrI5XUsJQZDDKWqUk6xCqWNJhCWCKyFA0vXiQJHJAMUye6rCcZV6QmyPAi4D1en9creISADyE6qt3yGdODjD8BRMSLfigAwQ8VD53H2EIRDROokSAjAD7AApHlQQz4JMEjCSLnrwysYlxNyMSqrlETDjChTLhSZq2ZE+vwoUKMkUmoEyYUCddGG8KRmvn1sbnuHF+hfh6iBBILD36r1hXkaoJJCw2/Dc5YS1FLlhHGjDuU3WGwUyl8K5gRhJ+hGvkVwesXlIQHyQklEB8VKmt1MwXJ8HHYI6rCJjKmEtKIStJ3Y5SyEV+LZNL/Vk9dRGpc9mOJBZNqQkVmkJlfFV4ZbmxkQmthmkIwIBtHyWQ7TCtstGoFC+KyFyiCX2R9CegBogz6N8p666d5yE7VuqaoNmnYVa+TKkSjRkO54XO4oUYNWoMZThA7olw7/wCH/Co7qdksWqRVs/OKUpQIV+b17hkYWE2IqcYtggY8DJ3IUBRkoGGoCjN0MqPFfvl04CDTSoghud3t7e1cu4fTzRa3AADvXrF4UVRuRSnIUFu71rP26t0XsGoGikzLmNpLJG3QWDqoVmkAWgsT8vB+0X8rC4PDCg0d/ddADmb34IoYrQqBPo8chwFBDgDo81d6R6NCQv0iddtxoDhMsylotiFiJKGMWJnqzEohU1Ukj5gQPP4EYhVfIMF6A4kEGxcVH8snEAIIxeNywP9/KpR8pR6VdQM16klVTo+K4EdP7KbSCE2SrrLS9D1KCaePfLV/R6jYhvoAQdq1PgKgtg9MnUBD5WyFc7KecuuQftrsoeZM1K58jNxxK821WAgTGoVCT5e8F6lUIhwtFCX/JdkypADyX0JbF8WSyYg2ytQ7R5lUW1oJvqc9O0ZACqZy45J6i4qJKmPOsBT9vqQXNoxIKmURGE+iyOicLP/RqXJHeCrtu8YUJprTbHJVJdswcZkMc/hFmTMR1i2T9opcg90/xPQ2pNGvMTH1ZBKZTXxeTNi1Plyyx1iO7/HgGpkKRq9rGkvalpMqlVDzWEP2UDKqQjK2UPOiWOn1BbxAvC9c1ZmcxtL5tQPOV3ofHsI6HROkPIAe3z34xiFUkPnxXY7joMtxpNDhAJWA5eeAWSVFy5xFExlMmwIOQ02J6x2cChMcPXo1+ofaRFwbShtQNQtLHOp35+TrOXcdu9aARwduO0qL+LKcqw/w+O2ZYr5iWjkfACIPgE/wCOIqMP32rJOf6pwy7/zHr1d/Mf+Ht3qKfM5jT5w42nwxAsoHjByO4gJnl6MgUPzaVz9uMr7Gdbu3bllXGtP23nyv5bNfponLAjP2H4j1/XTu+BsT69bvju6MnD51cN/Th+c9O/Nm35czGuveXX8FXl59fMHCC+t2HDlzSOpIMR9un6k079izfFvJjrbfl/f0KJcu1NaefHPfS9MPHoUbD50fP5dMblUnTz+weeHOS93dV9YcOD01Nn571Wrt2lORphqy8mRvzQunn/dsqXj5E/A+++qpw98cvHD9ye6KnyfUX67+tGLJfv81/PbUyLq+DWRJme/M3huHzv61/diG3uc+L0/fWHpuCldWkpj0SOqdy5vrxs1esW3PR8EFv876oPy3LT1ne1+boPr2Wt9vcknxq1e3ek5c/OPbZ/7uzqbxHz1CCxSFEgAA"
		);
		  
		$url = "https://api.sandbox.ebay.com/buy/browse/v1/item/v1|$item_id|0";
		
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);		
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		
		curl_setopt($curl, CURLOPT_POST, false);
		 
		if(curl_exec($curl) === false){
			//echo 'error hai';die;
			echo $err = 'Curl error: ' . curl_error($curl);die;
			curl_close($curl);
			//return $err;
			return false;
		}else{
			echo 'yes';die;
			$response = curl_exec($curl); 
			
			
			curl_close($curl);
			echo '<pre>';print_r($response);die;
		}
	}
	
	
//@@@@@@@@@@@@@@@@@@@@@@@@ LIVE API @@@@@@@@@@@@@@@@@@@@@@@@@@	

    function getCategory_live(Request $request) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_PROD_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_PROD_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_PROD_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetCategories',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                 <CategorySiteID>0</CategorySiteID>
                <DetailLevel>ReturnAll</DetailLevel>
                <ViewAllNodes>True</ViewAllNodes>
                <LevelLimit>7</LevelLimit>
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**GiXVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANlYWhCZKGpQSdj6x9nY+seQ**o/kFAA**AAMAAA**LbVctO09rwWm0ounnTNhgG0mF4gKeXwNXlKqRLl6F+EaUtq+YF+M1H1qBNtiI8HtMcZFl+AFQNVLXmz8Bj4m03sjBevL44zptoTuEaOBvSZk8SEeD84LsdpduWmk4J9D6cDE9TlivvNm9yZMvoB1pKi4e+/7tNaH2zaDUt1YrwePWLwNMf34N1Mm+Um98LklluYVjDAnMWK7xoZVT3K7cnONQWPGQNpYwT65q1EtNTtIS2NP3t5V4LWt4Ibe1P5OcoomCJp6Fe33SYRTCYyw7fqOshRsnJmlIZvk8jGq8Jm+CeFDqKU9o6HEbc1iK3G+UTvGnpb5Qy+64/1tpc5NTGkCfiZpVvbeAIgytC1dXRnQM08bCIYYGeh3DYXwAr6VSIYXT3c6euU0n4Npjs2hgLp3NklLd0G4dPzPlDInn3loo5FiOnaa1CDCZaLNazaE9eO23qs5LlmBHI/Bx9e+tZxx78w0hotXAEAqJ54zVEbe5sm54R8qTKajbV9BTWuOXLrxG5LMyytgO0Ij6jdswuRYT6UMhhQRCcjq47ecM/18usXxR5ZF8npkdouD21oiGpIdJdlkXBiPzZqFAKRSPxUCT7vuIB1sXVT7+IbR4/UpRHDiOmDlCCMY7/PHfDx+V4LYnJp4LoDBTx+Eq7jZxNPp9BbQp37VbWyRd2OcJgzB1QfLrFRsHbBgAA7kIhRtCHsRlcuenZJ6rTdlRvKt5LcN9kexQMH5cUzgvJAd7ZQ2qsMijmNAWUtLPV3vh1NL</eBayAuthToken>
                 </RequesterCredentials>
                 </GetCategoriesRequest>';
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $categories = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		//echo '<Pre>'; print_r($categories);die;
        if ($categories->Ack == 'Success'){
            foreach($categories->CategoryArray->Category as $category){
				$input['categoryId'] = (string)$category->CategoryID;
				$input['categoryName'] = (string)$category->CategoryName;
				$p_id = (string)$category->CategoryParentID;
				if($input['categoryId'] == $p_id){
					$input['parentId'] = '0';
				}else{
					$input['parentId'] = $p_id;
				}
				$input['slug'] = $this->slugify($input['categoryName']);
				$input['updated_at'] =  date('Y-m-d H:i:s');
				
				
				//echo '<pre>'; print_r($input); echo '</pre>';
 				$cat_check = array();					
				$cat_check = Category::where('categoryId',$input['categoryId'])->first();
				
				if($cat_check && $cat_check->count() > 0){
					
					Category::where('categoryId',$input['categoryId'])->update($input);	
											
				}else{
					$input['created_at'] =  date('Y-m-d H:i:s');
					Category::create($input)->id;	
				} 				
					
            }
			echo 'success';
        }
    }

    function getProductsByCategory_live(Request $request,$cat_id) {
		if($cat_id == ''){
			echo 'error. category not found';
			exit;
		}
		$search = array();
        $search[] = $cat_id; //parent category id
		$parent_id = $cat_id;
        $ebay_service = new EbayServices();
		
        $service = $ebay_service->createFinding();
		
        // Assign the keywords.
        $request = new Types\FindItemsByCategoryRequest();
		
        $request->categoryId =  $search;

        // Ask for the first 25 items.
        $request->paginationInput = new Types\PaginationInput();
        $request->paginationInput->entriesPerPage = 100000;
        $request->paginationInput->pageNumber = 1;

        // Ask for the results to be sorted from high to low price.
        $request->sortOrder = 'CurrentPriceLowest';
		//echo '<pre>'; print_r($request);die;
        $response = $service->findItemsByCategory($request);
		
		//echo $json = json_encode($response.true);die;
        // Output the response from the API.
        if ($response->ack !== 'Success') {
            echo 'no data found';
        } else {
            $products = $response->searchResult->item;
			//echo '<pre>'; print_r($products);die;
 			if($products){
				foreach($products as $product){

					$check = array();					
					$check = Product::where('itemId',$product->itemId)->first(); 

					$input['itemId'] =  $product->itemId;
					$input['title'] =  $product->title;
					$input['globalId'] =  $product->globalId;
					
					$catID  =  $product->primaryCategory->categoryId;
					
					$input['categoryId'] = $catID;			
					
					$input['parentCategoryId'] = $this->getParentID($catID);
					
					$catID1 = $catID;
					$catID2 = $this->getParentID($catID1);
					$catID3 = $this->getParentID($catID2);
					$catID4 = $this->getParentID($catID3);
					
					$catLevel = array();
					$catLevel = $this->getCatLevel($catID1,$catID2,$catID3,$catID4);
					if($catLevel){
						$input['catID1'] = $catLevel['L1'];
						$input['catID2'] = $catLevel['L2'];
						$input['catID3'] = $catLevel['L3'];
						$input['catID4'] = $catLevel['L4'];
					}else{
						$input['catID1'] = $input['categoryId'];
						$input['catID2'] = $input['parentCategoryId'];
						$input['catID3'] = 0;
						$input['catID4'] = 0;						
					}
					
					$input['galleryURL'] =  $product->galleryURL;
					$input['viewItemURL'] =  $product->viewItemURL;									
					$input['autoPay'] =  $product->autoPay;
					$input['postalCode'] =  $product->postalCode;
					$input['location'] =  $product->location;
					$input['country'] =  $product->country;
					$input['shippingInfo'] =  json_encode($product->shippingInfo);
					$input['current_price'] =  $product->sellingStatus->currentPrice->value;
					$input['current_price_currency'] =  $product->sellingStatus->currentPrice->currencyId;
					$input['converted_current_price'] =  $product->sellingStatus->convertedCurrentPrice->value;
					$input['converted_current_price_currency'] =  $product->sellingStatus->convertedCurrentPrice->currencyId;					
					$input['sellingState'] =  $product->sellingStatus->sellingState;
					$input['selling_time_left'] =  $product->sellingStatus->timeLeft;
					$input['listingInfo'] =  json_encode($product->listingInfo);
					$input['returnsAccepted'] =  $product->returnsAccepted;
					$input['return_condition'] =  json_encode($product->condition);
					$input['isMultiVariationListing'] =  $product->isMultiVariationListing;
					$input['topRatedListing'] =  $product->topRatedListing;	
					$input['updated_at'] =  date('Y-m-d H:i:s');
						
					//echo '<Pre>'; print_r($input); echo '</pre>';
 					$item_detail = array();
					$item_detail = $this->getSingleItem_live($input['itemId']); //API CALL
					
					if($item_detail){
						$input['PaymentMethods'] =  $item_detail['PaymentMethods'];	//string
						$input['Quantity'] = $item_detail['Quantity']; //string						
						$input['Description'] = $item_detail['Description']; //string
						$input['Seller'] = $item_detail['Seller']; //json
						$input['PictureDetails'] = $item_detail['PictureDetails']; //json
						$input['ItemSpecifics'] = $item_detail['ItemSpecifics']; //json
						$input['SellingStatus'] = $item_detail['SellingStatus']; //json
						$input['ShippingDetails'] = $item_detail['ShippingDetails']; //json
						$input['Variations'] = $item_detail['Variations']; //json
												
						if($item_detail['Brand'] != ''){
							$input3['name'] = $item_detail['Brand'];
							$input3['slug'] = $this->slugify($item_detail['Brand']);
							$input3['updated_at'] =  date('Y-m-d H:i:s');
							
							$brand_check = Brand::where('slug',$input3['slug'])->first();
							
							if($brand_check && $brand_check->count() > 0){
								
							    Brand::where('id',$brand_check['id'])->update($input3);	
								$input['brand_id'] = $brand_check['id'];
							}else{
								$input3['created_at'] =  date('Y-m-d H:i:s');
								$input['brand_id'] = Brand::create($input3)->id;
							}
						}
					}
					
 					if($check && $check->count() > 0){
						Product::where('itemId',$product->itemId)->update($input);	
					}else{
						$input['created_at'] =  date('Y-m-d H:i:s');
						Product::create($input)->id;	
					}  	
				}
				//die('<br>OK');
				echo 'success';
			} 

        }
    }	
	function getParentID($catID){
		$res = 0;
		$result = Category::where('categoryId',$catID)->first();
		if($result && $result->count() > 0){
			$res = $result->parentId;		
		}
		return $res;
	}
	
	function getCatLevel($catID1,$catID2,$catID3,$catID4){
		$catLevel = array();
		
		if($catID4 != 0){
			$catLevel['L1'] = $catID4;
			$catLevel['L2'] = $catID3;
			$catLevel['L3'] = $catID2;
			$catLevel['L4'] = $catID1;
			
		}elseif($catID4 == 0 && $catID3 != 0){
			$catLevel['L1'] = $catID3;
			$catLevel['L2'] = $catID2;
			$catLevel['L3'] = $catID1;
			$catLevel['L4'] = 0;
		}elseif($catID4 == 0 && $catID3 == 0 && $catID2 != 0){
			$catLevel['L1'] = $catID2;
			$catLevel['L2'] = $catID1;
			$catLevel['L3'] = 0;
			$catLevel['L4'] = 0;
		}
		return $catLevel;
	}
    function getSingleItem_live($item_id) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_PROD_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_PROD_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_PROD_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetItem',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				 <DetailLevel>ReturnAll</DetailLevel>
				 <ItemID>'.$item_id.'</ItemID>
				 <IncludeItemSpecifics>true</IncludeItemSpecifics>			 
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**GiXVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANlYWhCZKGpQSdj6x9nY+seQ**o/kFAA**AAMAAA**LbVctO09rwWm0ounnTNhgG0mF4gKeXwNXlKqRLl6F+EaUtq+YF+M1H1qBNtiI8HtMcZFl+AFQNVLXmz8Bj4m03sjBevL44zptoTuEaOBvSZk8SEeD84LsdpduWmk4J9D6cDE9TlivvNm9yZMvoB1pKi4e+/7tNaH2zaDUt1YrwePWLwNMf34N1Mm+Um98LklluYVjDAnMWK7xoZVT3K7cnONQWPGQNpYwT65q1EtNTtIS2NP3t5V4LWt4Ibe1P5OcoomCJp6Fe33SYRTCYyw7fqOshRsnJmlIZvk8jGq8Jm+CeFDqKU9o6HEbc1iK3G+UTvGnpb5Qy+64/1tpc5NTGkCfiZpVvbeAIgytC1dXRnQM08bCIYYGeh3DYXwAr6VSIYXT3c6euU0n4Npjs2hgLp3NklLd0G4dPzPlDInn3loo5FiOnaa1CDCZaLNazaE9eO23qs5LlmBHI/Bx9e+tZxx78w0hotXAEAqJ54zVEbe5sm54R8qTKajbV9BTWuOXLrxG5LMyytgO0Ij6jdswuRYT6UMhhQRCcjq47ecM/18usXxR5ZF8npkdouD21oiGpIdJdlkXBiPzZqFAKRSPxUCT7vuIB1sXVT7+IbR4/UpRHDiOmDlCCMY7/PHfDx+V4LYnJp4LoDBTx+Eq7jZxNPp9BbQp37VbWyRd2OcJgzB1QfLrFRsHbBgAA7kIhRtCHsRlcuenZJ6rTdlRvKt5LcN9kexQMH5cUzgvJAd7ZQ2qsMijmNAWUtLPV3vh1NL</eBayAuthToken>
                 </RequesterCredentials>
                 </GetItemRequest>';
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $results = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		//echo '<Pre>'; print_r($results); echo '</pre>';die;
		//return $results;
 		$detail = array();
        if ($results->Ack == 'Success'){
			$item = $results->Item;
			
			$detail['PaymentMethods'] = (string)$item->PaymentMethods;
			$detail['Quantity'] = (string)$item->Quantity;
			$detail['Description'] = (string)$item->Description;
			$detail['Seller'] = json_encode((array)$item->Seller); //for json
			$detail['PictureDetails'] = json_encode((array)$item->PictureDetails); //for json
			$detail['ItemSpecifics'] = json_encode((array)$item->ItemSpecifics);
			$detail['SellingStatus'] = json_encode((array)$item->SellingStatus);
			$detail['ShippingDetails'] = json_encode((array)$item->ShippingDetails);
			if(isset($item->Variations)){
				$detail['Variations'] = json_encode((array)$item->Variations);
			}else{
				$detail['Variations'] = '';
			}
			if(isset($item->ProductListingDetails) && isset($item->ProductListingDetails->BrandMPN) && isset($item->ProductListingDetails->BrandMPN->Brand)){
				$detail['Brand'] = $item->ProductListingDetails->BrandMPN->Brand;
			}else{
				$detail['Brand'] = '';
			}
			
			return $detail;
        } 
    }
	
	public static function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);

	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}

    function testing_getSingleItem_live($item_id) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_PROD_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_PROD_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_PROD_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetItem',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				 <DetailLevel>ReturnAll</DetailLevel>
				 <ItemID>'.$item_id.'</ItemID>
				 <IncludeItemSpecifics>true</IncludeItemSpecifics>			 
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**GiXVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANlYWhCZKGpQSdj6x9nY+seQ**o/kFAA**AAMAAA**LbVctO09rwWm0ounnTNhgG0mF4gKeXwNXlKqRLl6F+EaUtq+YF+M1H1qBNtiI8HtMcZFl+AFQNVLXmz8Bj4m03sjBevL44zptoTuEaOBvSZk8SEeD84LsdpduWmk4J9D6cDE9TlivvNm9yZMvoB1pKi4e+/7tNaH2zaDUt1YrwePWLwNMf34N1Mm+Um98LklluYVjDAnMWK7xoZVT3K7cnONQWPGQNpYwT65q1EtNTtIS2NP3t5V4LWt4Ibe1P5OcoomCJp6Fe33SYRTCYyw7fqOshRsnJmlIZvk8jGq8Jm+CeFDqKU9o6HEbc1iK3G+UTvGnpb5Qy+64/1tpc5NTGkCfiZpVvbeAIgytC1dXRnQM08bCIYYGeh3DYXwAr6VSIYXT3c6euU0n4Npjs2hgLp3NklLd0G4dPzPlDInn3loo5FiOnaa1CDCZaLNazaE9eO23qs5LlmBHI/Bx9e+tZxx78w0hotXAEAqJ54zVEbe5sm54R8qTKajbV9BTWuOXLrxG5LMyytgO0Ij6jdswuRYT6UMhhQRCcjq47ecM/18usXxR5ZF8npkdouD21oiGpIdJdlkXBiPzZqFAKRSPxUCT7vuIB1sXVT7+IbR4/UpRHDiOmDlCCMY7/PHfDx+V4LYnJp4LoDBTx+Eq7jZxNPp9BbQp37VbWyRd2OcJgzB1QfLrFRsHbBgAA7kIhRtCHsRlcuenZJ6rTdlRvKt5LcN9kexQMH5cUzgvJAd7ZQ2qsMijmNAWUtLPV3vh1NL</eBayAuthToken>
                 </RequesterCredentials>
                 </GetItemRequest>';
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $results = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($results); echo '</pre>';die;
		//return $results;
 		$detail = array();
        if ($results->Ack == 'Success'){
			$item = $results->Item;
			
			$detail['PaymentMethods'] = (string)$item->PaymentMethods;
			$detail['Quantity'] = (string)$item->Quantity;
			$detail['Description'] = (string)$item->Description;
			$detail['Seller'] = json_encode((array)$item->Seller); //for json
			$detail['PictureDetails'] = json_encode((array)$item->PictureDetails); //for json
			$detail['ItemSpecifics'] = json_encode((array)$item->ItemSpecifics);
			$detail['SellingStatus'] = json_encode((array)$item->SellingStatus);
			$detail['ShippingDetails'] = json_encode((array)$item->ShippingDetails);
			if(isset($item->Variations)){
				$detail['Variations'] = json_encode((array)$item->Variations);
			}else{
				$detail['Variations'] = '';
			}
			if(isset($item->ProductListingDetails) && isset($item->ProductListingDetails->BrandMPN) && isset($item->ProductListingDetails->BrandMPN->Brand)){
				$detail['Brand'] = $item->ProductListingDetails->BrandMPN->Brand;
			}else{
				$detail['Brand'] = '';
			}
			
			return $detail;
        } 
    }

//testing feedback
    function feedback_live($item_id) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_PROD_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_PROD_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_PROD_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'GetFeedback',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <GetFeedbackRequest xmlns="urn:ebay:apis:eBLBaseComponents">
				 <DetailLevel>ReturnAll</DetailLevel>
				 <UserID>/illinoisprecisiongroup</UserID>		 
				 <ItemID>'.$item_id.'</ItemID>	 
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**GiXVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANlYWhCZKGpQSdj6x9nY+seQ**o/kFAA**AAMAAA**LbVctO09rwWm0ounnTNhgG0mF4gKeXwNXlKqRLl6F+EaUtq+YF+M1H1qBNtiI8HtMcZFl+AFQNVLXmz8Bj4m03sjBevL44zptoTuEaOBvSZk8SEeD84LsdpduWmk4J9D6cDE9TlivvNm9yZMvoB1pKi4e+/7tNaH2zaDUt1YrwePWLwNMf34N1Mm+Um98LklluYVjDAnMWK7xoZVT3K7cnONQWPGQNpYwT65q1EtNTtIS2NP3t5V4LWt4Ibe1P5OcoomCJp6Fe33SYRTCYyw7fqOshRsnJmlIZvk8jGq8Jm+CeFDqKU9o6HEbc1iK3G+UTvGnpb5Qy+64/1tpc5NTGkCfiZpVvbeAIgytC1dXRnQM08bCIYYGeh3DYXwAr6VSIYXT3c6euU0n4Npjs2hgLp3NklLd0G4dPzPlDInn3loo5FiOnaa1CDCZaLNazaE9eO23qs5LlmBHI/Bx9e+tZxx78w0hotXAEAqJ54zVEbe5sm54R8qTKajbV9BTWuOXLrxG5LMyytgO0Ij6jdswuRYT6UMhhQRCcjq47ecM/18usXxR5ZF8npkdouD21oiGpIdJdlkXBiPzZqFAKRSPxUCT7vuIB1sXVT7+IbR4/UpRHDiOmDlCCMY7/PHfDx+V4LYnJp4LoDBTx+Eq7jZxNPp9BbQp37VbWyRd2OcJgzB1QfLrFRsHbBgAA7kIhRtCHsRlcuenZJ6rTdlRvKt5LcN9kexQMH5cUzgvJAd7ZQ2qsMijmNAWUtLPV3vh1NL</eBayAuthToken>
                 </RequesterCredentials>
                 </GetFeedbackRequest>';
				 
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $results = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($results); echo '</pre>';die;
    }	
	
	
	
    function getProducts_live(Request $request, $cat_id) {
		if($cat_id == ''){
			echo 'error. category not found';
			exit;
		}		
        $headers =  array(
            'cache-control' => 'no-cache',
           // 'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => env('EBAY_PROD_DEV_ID'),
            'X-EBAY-API-CERT-NAME' => env('EBAY_PROD_CERT_ID'),
            'X-EBAY-API-APP-NAME' => env('EBAY_PROD_APP_ID'),
            'X-EBAY-API-CALL-NAME' => 'findItemsByCategory',
            'Content-Type' => 'application/xml'
        );
        $client = new Client([ 'headers' => $headers]);
		
        $body = '<?xml version="1.0" encoding="utf-8"?>
                 <findItemsByCategoryRequest xmlns="http://www.ebay.com/marketplace/search/v1/services">
				 <categoryId>2984</categoryId>
				 <outputSelector>AspectHistogram</outputSelector>
                 <RequesterCredentials>
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**GiXVXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANlYWhCZKGpQSdj6x9nY+seQ**o/kFAA**AAMAAA**LbVctO09rwWm0ounnTNhgG0mF4gKeXwNXlKqRLl6F+EaUtq+YF+M1H1qBNtiI8HtMcZFl+AFQNVLXmz8Bj4m03sjBevL44zptoTuEaOBvSZk8SEeD84LsdpduWmk4J9D6cDE9TlivvNm9yZMvoB1pKi4e+/7tNaH2zaDUt1YrwePWLwNMf34N1Mm+Um98LklluYVjDAnMWK7xoZVT3K7cnONQWPGQNpYwT65q1EtNTtIS2NP3t5V4LWt4Ibe1P5OcoomCJp6Fe33SYRTCYyw7fqOshRsnJmlIZvk8jGq8Jm+CeFDqKU9o6HEbc1iK3G+UTvGnpb5Qy+64/1tpc5NTGkCfiZpVvbeAIgytC1dXRnQM08bCIYYGeh3DYXwAr6VSIYXT3c6euU0n4Npjs2hgLp3NklLd0G4dPzPlDInn3loo5FiOnaa1CDCZaLNazaE9eO23qs5LlmBHI/Bx9e+tZxx78w0hotXAEAqJ54zVEbe5sm54R8qTKajbV9BTWuOXLrxG5LMyytgO0Ij6jdswuRYT6UMhhQRCcjq47ecM/18usXxR5ZF8npkdouD21oiGpIdJdlkXBiPzZqFAKRSPxUCT7vuIB1sXVT7+IbR4/UpRHDiOmDlCCMY7/PHfDx+V4LYnJp4LoDBTx+Eq7jZxNPp9BbQp37VbWyRd2OcJgzB1QfLrFRsHbBgAA7kIhRtCHsRlcuenZJ6rTdlRvKt5LcN9kexQMH5cUzgvJAd7ZQ2qsMijmNAWUtLPV3vh1NL</eBayAuthToken>
                 </RequesterCredentials>
                 </findItemsByCategoryRequest>';
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);
        $products = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($products);die;
        if ($products->Ack == 'Success'){
			
		}	
	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
