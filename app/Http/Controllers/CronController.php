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
use App\EbayCronCategory;
use App\ApiSetting;
use App\Mail\ApiError;
use Mail;

class CronController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	private $APP_ID;
	private $DEV_ID;
	private $CERT_ID;
	private $TOKEN;
	
    public function __construct()
    {
        //$this->middleware('auth');
		$api_setting = ApiSetting::where('api_name','ebay')->first();
		if($api_setting && $api_setting->count() > 0 && $api_setting->mode == 'production'){
			$this->APP_ID = $api_setting->app_id;
			$this->DEV_ID = $api_setting->developer_id;
			$this->CERT_ID = $api_setting->certificate_id;
			$this->TOKEN = $api_setting->token;
		}else{
			$this->APP_ID = env('EBAY_PROD_APP_ID');
			$this->DEV_ID = env('EBAY_PROD_DEV_ID');
			$this->CERT_ID = env('EBAY_PROD_CERT_ID');
			$this->TOKEN = 'AgAAAA**AQAAAA**aAAAAA**uSDuXA**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6ANl4ahCpaKpQudj6x9nY+seQ**qQIGAA**AAMAAA**bViF7OtDG4VsXsrjZO/RqmSCF7p7uxhPJpL/bP10WAYuTRR4om+3bK5xbpycDdqFPx7WNAZrG/wP9yofjM2Gy0M3pjqqZLCW/jgrUyxk65Tmu/MHhvqYHtGiQCefiQJChOuZN5IDszlAlWN4U8CWUlMEQ6/r9jufz+lUImry1/YJilUew4gaMd972AFcQhqrDcBTSh8GUyPpUn7LmUoALT/YDTfAnidYzBZE6HHT1S9IAnQ/3dCdVEDHrDpVazVg6miMFngYDeDLmiwq1VWhBs2T3jGpEvGX5JaFDepvejvDhYM/x3XfhMr7ka7dTLF58fNOrbonIo9Yy9HX/qJS/Kdgq8dtbNgVznupoOaC+OE9+MyXww5CI8frTyIJWpY2Bfjvv6dV8LUWySWxVtWmgQlo0MXM9CRZALlOF9c4glzqmUjQVU6LIzNZCkBm2biMRE/tcORaJs7c/UCs0ff4eObs6a3U5YsgaBgOk88Fk5nfIWT90OVeQ4O5Z8aDUw63f9Ffa6PwTOxcCXMiboqrkK/paSekGdBooJCJPDMKIxy0jj2TQemSnHaznJN884LMUvbRl9iNyxgG+E8IT+ulyhwhulblBzy3PDRwMV7LSwPXqTCpfWV3PayOBK2z3N0TEeVemJe9CBGINKf9etW5U5XGsAqehMh4zwAPd1XXI0z2FygADztRa2NtXP7oZ2nThooJLdApD/2VOp7bwe/R4pF7LbyiFXYKQxABQWt/aW82tjgF/BogAO82hPTN0VMF';			
		}
			
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


//@@@@@@@@@@@@@@@@@@@@@@@@ LIVE API @@@@@@@@@@@@@@@@@@@@@@@@@@	

    function getCategory_live(Request $request) {
        $headers =  array(
            'cache-control' => 'no-cache',
            'X-EBAY-API-COMPATIBILITY-LEVEL' => '861',
            'X-EBAY-API-SITEID' => '0',
            'X-EBAY-API-DEV-NAME' => $this->DEV_ID,
            'X-EBAY-API-CERT-NAME' => $this->CERT_ID,
            'X-EBAY-API-APP-NAME' => $this->APP_ID,
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
                 <eBayAuthToken>'.$this->TOKEN.'</eBayAuthToken>
                 </RequesterCredentials>
                 </GetCategoriesRequest>';
        $response = $client->request('POST', 'https://api.ebay.com/ws/api.dll', [
            'body' => $body
        ]);

        $categories = simplexml_load_string($response->getBody(),'SimpleXMLElement',LIBXML_NOCDATA);
		echo '<Pre>'; print_r($categories);die;
		$x=0;
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
				
				$input['slug'] = $this->check_slug($input['slug']);
				
				$input['updated_at'] =  date('Y-m-d H:i:s');
				
				
				//echo '<pre>'; print_r($input); echo '</pre>';
 				$cat_check = array();					
				$cat_check = Category::where('categoryId',$input['categoryId'])->first();
				
				if($cat_check && $cat_check->count() > 0){
					Category::on('mysql2')->where('categoryId',$input['categoryId'])->update($input);		
				}else{
					$input['created_at'] =  date('Y-m-d H:i:s');
					Category::create($input)->id;	
				} 					

			$x++;		
            }
			
			$all_categories = Category::orderBy('id','asc')->get();
			if($all_categories && $all_categories->count() > 0){
				foreach($all_categories as $cat){
					$row_id = $cat->id;
					
					if($cat->parentId == 0){
						$level_input = array('catLevel'=>1);
					}else{
						$level2 = Category::where('categoryId',$cat->parentId)->first();
						if($level2->parentId == 0){
							$level_input = array('catLevel'=>2);
						}else{
							$level3 = Category::where('categoryId',$level2->parentId)->first();
							if($level3->parentId == 0){
								$level_input = array('catLevel'=>3);
							}else{
								$level4 = Category::where('categoryId',$level2->parentId)->first();
								if($level4->parentId == 0){
									$level_input = array('catLevel'=>4);
								}else{
									$level_input = array('catLevel'=>4);
								}
							}
						}
					}
					Category::where('id',$row_id)->update($level_input);				
					
				}
			}
			echo 'success';
        }
    }

    function getProductsByCategory_live(Request $request,$cat_id) { 
		//not used
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
	//	echo '<pre>'; print_r($request);die;
        $response = $service->findItemsByCategory($request);
		//echo $json = json_encode($response.true);die;
        // Output the response from the API.
        if ($response->ack !== 'Success') {
            Mail::send($response);
			exit;
        } else {
            $products = $response->searchResult->item;
			echo '<pre>'; print_r($products);die;
 			if($products){
				foreach($products as $product){

					$check = array();					
					$check = Product::where('itemId',$product->itemId)->first(); 

					$input['itemId'] =  $product->itemId;
					$input['title'] =  $product->title;
					
					$slug = $this->slugify($product->title);
					$slug = $this->check_slug_product($slug);
					
					$input['slug'] = $slug;
					
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
						
					echo '<Pre>'; print_r($input); echo '</pre>';
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

							$input['brand_id'] = $item_detail['Brand'];
							
						}
					}
					
 					if($check && $check->count() > 0){
						Product::on('mysql2')->where('itemId',$product->itemId)->update($input);	
					}else{
						$input['created_at'] =  date('Y-m-d H:i:s');
						Product::on('mysql2')->create($input)->id;	
					}  	
				}
				
				$ebay_cat = array('status'=>1,'updated_at'=>date('Y-m-d H:i:s'));
				
				EbayCronCategory::where('status',0)->where('categoryId',$cat_id)->update($ebay_cat);
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
            'X-EBAY-API-DEV-NAME' => $this->DEV_ID,
            'X-EBAY-API-CERT-NAME' => $this->CERT_ID,
            'X-EBAY-API-APP-NAME' => $this->APP_ID,
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
                 <eBayAuthToken>'.$this->TOKEN.'</eBayAuthToken>
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
			
			$pic_array = array();
			$gallery_images = '';
			$product_image = '';
			
			$pic_det = (array)$item->PictureDetails;
			//echo '<pre>';print_r($pic_det);die;
			if($pic_det && isset($pic_det['PhotoDisplay']) && $pic_det['PhotoDisplay'] == 'PicturePack' && isset($pic_det['PictureURL'])){
				$pic_detail = $pic_det['PictureURL'];
				//echo '<pre>';print_r($pic_detail);die;
				if(is_array($pic_detail)){
					$pic_array = $pic_detail;
					if($pic_array){
						$product_image = $pic_array[0];
						$gallery_images = implode(',',$pic_array);
					}
				}else{
					$product_image = $pic_detail;
					$gallery_images = $product_image;
				}
				
			}
	
			$detail['product_image'] = $product_image; //string;
			$detail['gallery_images'] = $gallery_images; //string;
			$detail['ItemSpecifics'] = json_encode((array)$item->ItemSpecifics);
			$detail['SellingStatus'] = json_encode((array)$item->SellingStatus);
			$detail['ShippingDetails'] = json_encode((array)$item->ShippingDetails);
			if(isset($item->Variations)){
				$detail['Variations'] = json_encode((array)$item->Variations);
			}else{
				$detail['Variations'] = '';
			}
			if(isset($item->ProductListingDetails) && isset($item->ProductListingDetails->BrandMPN) && isset($item->ProductListingDetails->BrandMPN->Brand)){
				$brand =$item->ProductListingDetails->BrandMPN->Brand;
				//echo '<pre>';print_R((string)$brand);die;
				$detail['Brand'] = (string)$brand;
			}else{
				$detail['Brand'] = '';
			}
			//echo '<pre>';print_R($detail);die;
			return $detail;
        }else{
			Mail::send(new ApiError($results));
			echo 'Ebay API Error Occured.';
			exit;
		} 
    }
	
	public static function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'utf-8//TRANSLIT', $text);

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

	
	function check_slug($slug){
		$rand = time().rand(10,99);
		$slug_check = Category::on('mysql2')->where('slug',$slug)->first();
		if($slug_check && $slug_check->count() > 0){
			$slug = $slug_check->slug.'-'.$rand;
			return $slug;
		}
		return $slug;
	}
	
	function check_slug_product($slug){
		$rand = time().rand(10,99);
		$slug_check = Product::on('mysql2')->where('slug',$slug)->first();
		if($slug_check && $slug_check->count() > 0){
			$slug = $slug_check->slug.'-'.$rand;
			return $slug;
		}
		return $slug;
	}	
	
	public function create_product_slug(){
		$products = Product::on('mysql2')->where('status',1)->where('slug','')->orderBy('updated_at','desc')->get();
		if($products && $products->count() > 0){
			foreach($products as $p){
				if($p->title !=''){
					$slug = $this->slugify($p->title);
					$slug = $this->check_slug_product($slug);
					$input = array('slug'=>$slug);
					//echo '<pre>'; print_r($input);die;
					Product::on('mysql2')->where('itemId',$p->itemId)->update($input);
				}
			}
		}
	}	
	
	public function get_item_by_id($pid){
		

		$search = array();
		$search[] = $pid; //parent category id
		
		$ebay_service = new EbayServices();
		
		$service = $ebay_service->createFinding();
		
		// Assign the keywords.
		$request = new Types\FindItemsByProductRequest();
		
		$request->productId->type =  'ReferenceID';
		$request->productId =  '53039031';

		// Ask for the first 25 items.
	//	$request->paginationInput = new Types\PaginationInput();
	//	$request->paginationInput->entriesPerPage = 1;
	//	$request->paginationInput->pageNumber = 100;

		// Ask for the results to be sorted from high to low price.
		//$request->sortOrder = 'CurrentPriceLowest';
	
		$response = $service->findItemsByProduct($request);
	//echo '<pre>';print_r($response);die;
	}
//Live it is working	
	public function by_category_ebay($pageNo = 1,$perPage = 100, $cat_id = 0 ){
		
	 	EbayCronCategory::on('mysql2')->where('today_date','<',date('Y-m-d'))->update(array('today_date'=>date('Y-m-d'),'status'=>0));//date checking and updating
		
		if($cat_id == 0){
			
			$ebay_category = EbayCronCategory::on('mysql2')->where('status',0)->orderBy('id','asc')->limit(1)->first();
			
		
			if($ebay_category && $ebay_category->count() > 0){
				$cat_id = $ebay_category->categoryId;
				
				$ebay_cat = array('status'=>1,'updated_at'=>date('Y-m-d H:i:s'));
				
				EbayCronCategory::on('mysql2')->where('status',0)->where('categoryId',$cat_id)->update($ebay_cat);
				
			}
	
		} 
		//$cat_id = '20081';
		$search = array();
		$cat_id = (string)$cat_id;	
		//echo $cat_id;die;		
		$search[] = $cat_id; //parent category id
		$parent_id = $cat_id;
		$ebay_service = new EbayServices();
		//echo '<pre>';print_r($ebay_service);die;
		$service = $ebay_service->createFinding();

		// Assign the keywords.
		$request = new Types\FindItemsByCategoryRequest();
		
		$request->categoryId =  $search;

		// Ask for the first 25 items.
		$request->paginationInput = new Types\PaginationInput();
		$request->paginationInput->entriesPerPage = $perPage;
		$request->paginationInput->pageNumber = $pageNo;

		// Ask for the results to be sorted from high to low price.
		$request->sortOrder = 'CurrentPriceLowest';
		//echo '<pre>';print_r($request);die;
		$response = $service->findItemsByCategory($request);
		//echo '<pre>';print_r($response);die;
		//echo $json = json_encode($response.true);die;
		// Output the response from the API.
		if($response->ack !== 'Success') {
			Mail::send(new ApiError($response));
			echo 'Ebay API Error Occured.';
			exit;
		}else{
			$pageNo = $response->paginationOutput->pageNumber;
			$totalPages = $response->paginationOutput->totalPages;
			$perPage = $response->paginationOutput->entriesPerPage;

			$products = $response->searchResult->item;
			//echo '<pre>';print_r($products);die;
			//echo '<pre>'; print_r($response->paginationOutput);echo '<hr>';
			if($products){
 				foreach($products as $product){

					$check = array();					
					$check = Product::on('mysql2')->where('itemId',$product->itemId)->first(); 
					
					if($check && $check->count() > 0){
						$exp_date = date('Y-m-d H:i:s',strtotime(' + 2 day', strtotime($check->updated_at)));
						$current_date = date('Y-m-d H:i:s');
						if($current_date < $exp_date){
							continue;
							
						}
					}

					$input['itemId'] =  $product->itemId;
					$input['title'] =  $product->title;
					
					$slug = $this->slugify($product->title);
					$slug = $this->check_slug_product($slug);
					
					$input['slug'] = $slug;
					//echo '<Pre>'; print_r($input); echo '</pre>';
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
						
					
					$item_detail = array();
					$item_detail = $this->getSingleItem_live($input['itemId']); //API CALL
					//$item_detail = $this->get_item_by_id($input['itemId']); //API CALL
					//echo '<pre>';print_r($item_detail);die;
					if($item_detail){
						$input['PaymentMethods'] =  $item_detail['PaymentMethods'];	//string
						$input['Quantity'] = $item_detail['Quantity']; //string						
						$input['Description'] = $item_detail['Description']; //string
						$input['Seller'] = $item_detail['Seller']; //json
					//	$input['PictureDetails'] = $item_detail['PictureDetails']; //json
					
						$input['product_image'] = $item_detail['product_image'];
						$input['gallery_images'] = $item_detail['gallery_images'];
						
						$input['ItemSpecifics'] = $item_detail['ItemSpecifics']; //json
						$input['SellingStatus'] = $item_detail['SellingStatus']; //json
						$input['ShippingDetails'] = $item_detail['ShippingDetails']; //json
						$input['Variations'] = $item_detail['Variations']; //json
												
						if($item_detail['Brand'] != ''){
							$input['brand_id']= $item_detail['Brand'];
						}
						//echo 'ss';die;
					}
					//echo '<pre>';print_r($input);die;
					if($check && $check->count() > 0){
						Product::on('mysql2')->where('itemId',$product->itemId)->update($input);	
					}else{
						$input['created_at'] =  date('Y-m-d H:i:s');
						Product::on('mysql2')->create($input)->itemId;
					
					}  	
				}
				 
				
				if($pageNo < $totalPages){ // && $pageNo <= 5 for 5 pages only
					$pageNo++;
					
					$this->by_category_ebay($pageNo,$perPage,$cat_id);
				}else{
					echo 'products fetched successfully';
					exit;
				}
				
				
			} 
		}
	}
	
	
}
