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
                 <eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**6XbBXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4ajAZaApgSdj6x9nY+seQ**dNwEAA**AAMAAA**Km/jO8yBBu4IUNMSiSxd4rV5g75TwO7eJXdY4FRr7JyOiiYmAKXMRTrFvj2cS0gJAwpLvVJqNrLU71krD/clfDO63yRmnaepNDkhklE9EPipJjaBOWEBoy3uu/xZ/mIVVcXIXYc5vqvtZ9tgGpLiOE89UuBcOsi+JFmC/SLzx9FQISmep1a5rG/rYNuj1zZtTkOW7lc4s5inO7/1UN8UtBoWPX+INrq4tE4cvOC+X2uOdZvSuqzQJwaG+72R+A1pz4EqYJGx3efPslLTRSj3niZvpqyUlMjLM8vtiAb/s1DdxN1Dv78nrUXkPDwj6VNqKdDaiDtmKjmwepLelHskDTrFeQLTE/0NvZuYsK4v/VwdCXhfguvEOaSLGJJmr9LgUD9GxOxuxtYlyFjiuCSh4bIj3CRY7wvk/J9oAubfvtBopeJGbiPxbCtAy/f0bFVyxigFATE5ja27X/2+EAHjl5AhU/IW8i81+SHJxFDdW3gT9zeZe2zBFXO3UW0tcwMYOm0h57k3lp61ZJaiGLT12Mi340i0UOadyOipfYQi1P54nzZgSEN9tNg0LH/a4k7zOdAXZFL9dTiBrgZdMBqQmbTImKgHqSLIVCGPlQ2j7FCLuCh9HM8K9xYPreYQ+WMfUyjT9+FCQHE6AvAZclFnrb8gC2qeBjCrOKjOB/xzH0SMphxagf1drFC/zrI8ZzMNNGSdAfwDT6Axv0tYlJDXhlZQmbNvs5a3ZAMBrLixy/O4OUZTdh1foOmfvck8s1z/</eBayAuthToken>
                 </RequesterCredentials>
                 </GetCategoriesRequest>';
        $response = $client->request('POST', 'https://api.sandbox.ebay.com/ws/api.dll', [
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
	
    function getProductsByCategory(Request $request) {
		$search = array();
        $search[] = $request->input('categoryId'); //parent category id
		$parent_id = $request->input('categoryId');
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
					$input['parentCategoryId'] =  $parent_id;
				
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
										
					
					$item_detail = array();
					$item_detail = $this->getSingleItem($input['itemId']); //API CALL
					
					if($item_detail){
						$input['Quantity'] = $item_detail['Quantity']; //string
						$input['Seller'] = $item_detail['Seller']; //json
						$input['PictureDetails'] = $item_detail['PictureDetails']; //json
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
	
}
