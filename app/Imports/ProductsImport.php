<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

use Auth;
use DB;
use Session;
use App\Product;
use App\Brand;
use App\Merchant;
use App\Category;

class ProductsImport implements ToModel, WithBatchInserts, WithChunkReading, WithValidation
{
	 use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {			
		//echo '<pre>';print_r($row);die;
		$catId = 0;	
		$parentId = 0;	
		$catID1 = 0;
		$catID2 = 0;
		$catID3 = 0;
		$catID4 = 0;			
 		if($row[0] != 'item_id'){
			$category_array = array();
			$gallery_images_json = '';
			$itemId = trim($row[0]);	// itemId
			$merchant = trim($row[1]);	// merchant
			$categoryId = trim($row[2]);	// category_id optional

			$category = trim($row[3]);	// category names in order, separated by ' > ' 
			$title = trim($row[4]);	// title			
			$price = trim($row[5]);	// price
			$currency = trim($row[6]);	// currency
			$brand = trim($row[7]);	// brand
			$item_url = trim($row[8]);	// item_url
			$quantity = trim($row[9]);	// quantity
			$description = trim($row[10]);	// description
			$product_image = trim($row[11]);	// product_image
			$gallery_images_str = trim($row[12]);	// gallery_images
			$cat_check = array();
			
			if($product_image != '#'){
				$merchant_id = 0; //default
				if($merchant !=''){
					$input2 = array(
						'name' => $merchant,
						'slug' => $this->slugify($merchant),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$merchant_check = Merchant::where('slug',$input2['slug'])->first();
					if($merchant_check && $merchant_check->count() > 0){
						$merchant_id = $merchant_check->id;
						//Merchant::where('id',$merchant_id)->update($input2);
					}else{
						$input2['updated_at'] = date('Y-m-d H:i:s');
						$merchant_id = Merchant::create($input2)->id;
					}
					
				}
	
				$brand_id = 0;
				
				if($brand !=''){
					$input3 = array(
						'name' => $brand,
						'slug' => $this->slugify($brand),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$brand_check = Brand::where('slug',$input3['slug'])->first();
					if($brand_check && $brand_check->count() > 0){
						$brand_id = $brand_check->id;
						Brand::where('id',$brand_id)->update($input3);
					}else{
						$input3['updated_at'] = date('Y-m-d H:i:s');
						$brand_id = Brand::create($input3)->id;
					}
				}			
				
				
				$cat_check = Category::where('categoryId',$categoryId)->first();
				
				if($categoryId !='' && $cat_check && $cat_check->count() > 0){
					$cID1 = $catId = $cat_check->categoryId;
					$cID2 = $parentId  = $cat_check->parentId;
					$cID3 = $this->getParentId($parentId);
					$cID4 = $this->getParentId($catID3);
					
					$catLevel = array();
					$catLevel = $this->getCatLevel($cID1,$cID2,$cID3,$cID4);
					if($catLevel){
						$catID1 = $catLevel['L1'];
						$catID2 = $catLevel['L2'];
						$catID3 = $catLevel['L3'];
						$catID4 = $catLevel['L4'];
					}else{
						$catID1 = $catId;
						$catID2 = $parentId;
						$catID3 = 0;
						$catID4 = 0;						
					}	
				
				}else{
					$cinput = array();
					$parentId = $other_cat_id = Category::where('is_other',1)->first()->categoryId;
					
					 if($category!=''){
						$category_array = explode('>',$category);
					}
					//echo '<pre>';print_r($category_array);die;
					$cat_count = count($category_array);
					if($category_array){
						$cat = trim(end($category_array));	
						$cat_slug = $this->slugify($cat);
							
						$cat_check2 = array();					
						$cat_check2 = Category::where('slug',$cat_slug)->where('parentId',$parentId);
						
						if($merchant_id != 0){
							$cat_check2 = $cat_check2->where('merchant_id',$merchant_id);
						}
						
						$cat_check2 = $cat_check2->first();
						
						if($cat_check2 && $cat_check2->count() > 0){
							$catId =  $cinput['categoryId'] = $cat_check2->categoryId;
						}else{
							if($categoryId != ''){
								$catId = $cinput['categoryId'] = $categoryId; 
							}else{
								$catId = $cinput['categoryId'] = rand(111,999).rand(11111111,99999999).rand(111,999);
							}
							
							$cinput['parentId'] = $parentId;
							$cinput['merchant_id'] = $merchant_id;
							$cinput['slug'] = $cat_slug;
							$cinput['catLevel'] = 2;
							$cinput['categoryName'] = $cat;
							$cinput['created_at'] =  date('Y-m-d H:i:s');
							$cinput['updated_at'] =  date('Y-m-d H:i:s');
							//echo '<pre>';print_r($cinput);die;
							Category::create($cinput);	//create new category							
						}
						
						$catID1 = $parentId;
						$catID2 = $cinput['categoryId'];
						$catID3 = 0;
						$catID4 = 0;

					}
 
				}
				
				$pslug='';
				$pslug = $this->slugify($title);
				$pslug = $pslug.'-'.$itemId;
				
				if($gallery_images_str !=''){
					$gi_arr = array();
					$gi_arr = explode(',',$gallery_images_str);
					if($gi_arr){
						$gallery_images_json = json_encode($gi_arr,true);
					}
				}
				
				$item_check = Product::where('itemId',$itemId)->get();

				if($item_check && $item_check->count() > 0){
					$uinput = array(
						'merchant_id'     => $merchant_id,				
						'title'     => $title,
						'slug'     => $pslug,
						'categoryId'    => $catId,
						'parentCategoryId'    => $parentId,
						'catID1'    => $catID1,
						'catID2'    => $catID2,
						'catID3'    => $catID3,
						'catID4'    => $catID4,					
						'viewItemURL'    => $item_url,
						'current_price'    => $price,
						'current_price_currency'    => $currency,
						'converted_current_price'    => $price,
						'converted_current_price_currency'    => $currency,					
						'brand_id'    => $brand_id,
						'product_image'    => $product_image,
						'gallery_images'    => $gallery_images_json,
						'description'    => $description,
						'updated_at'    => date('Y-m-d H:i:s')				
					);
					//Product::where('itemId',$itemId)->update($uinput);
					
					return true;
				}else{
					return new Product([
						'merchant_id' => $merchant_id,
						'itemId'     => $itemId,
						'title'     => $title,
						'slug'     => $pslug,
						'categoryId'    => $catId,
						'parentCategoryId'    => $parentId,
						'catID1'    => $catID1,
						'catID2'    => $catID2,
						'catID3'    => $catID3,
						'catID4'    => $catID4,
						'viewItemURL'    => $item_url,
						'current_price'    => $price,
						'current_price_currency'    => $currency,
						'converted_current_price'    => $price,
						'converted_current_price_currency'    => $currency,					
						'brand_id'    => $brand_id,
						'product_image'    => $product_image,
						'gallery_images'    => $gallery_images_json,
						'description'    => $description,
						'created_at'    => date('Y-m-d H:i:s'),
						'updated_at'    => date('Y-m-d H:i:s')
					]);	
				//	Product::insert($insert_data);	
					//return true;	
				}

			} 
		} 
    }
	
    public function rules(): array
    {
		$err_array = array();
		$errors = [

             '0' => function($attribute, $value, $onFailure) {
				 if($value != 'item_id'){
					  if ($value == '') {
						  $onFailure($attribute.' value is required.');
					  }					 
					  if (strlen($value) > 20) {
						   $onFailure($attribute.' value can up to 20 characters long.');
					  }
				}
              },
             '1' => function($attribute, $value, $onFailure) {
				 if($value != 'merchant'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (strlen($value) > 20) {
						   $onFailure($attribute.' value can up to 20 characters long.');
					  }
				}
              },
             '4' => function($attribute, $value, $onFailure) {
				 if($value != 'title'){
					  if ($value == '') {
						   $onFailure($attribute.' '.$value.' is required.');
					  }						 
				}
              },
             '5' => function($attribute, $value, $onFailure) {
				 if($value != 'price'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!is_numeric($value)) {
						   $onFailure($attribute.' value must be a number.');
					  }
				}
              },
             '8' => function($attribute, $value, $onFailure) {
				 if($value != 'item_url'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!filter_var($value, FILTER_VALIDATE_URL)) {
						   $onFailure($attribute.' value must be a valid url.');
					  }
				}
              },
             '9' => function($attribute, $value, $onFailure) {
				 if($value != 'quantity'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!is_numeric($value)) {
						   $onFailure($attribute.' value must be a number.');
					  }
				}
              },
              '11' => function($attribute, $value, $onFailure) {
				 if($value != 'product_image'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }	
					if($value == '#'){
						//nothing
					}else{
					  if (!filter_var($value, FILTER_VALIDATE_URL)) {
						   $onFailure($attribute.' value must be a valid image address.');
					  }						
					}

				}
              } 		  
        ];

        return $errors;
    }

	public function customValidationAttributes()
	{
		return [
		'0' => 'item_id',
		'1' => 'merchant',
		'3' => 'title',
		'4' => 'price',
		'7' => 'item_url',
		'8' => 'quantity',
		'10' => 'product_image',
		];
	}	
	
    public function batchSize(): int
    {
        return 250;
    }
	
    public function chunkSize(): int
    {
        return 250;
    }
	
	public static function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	 // $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

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
	
	function check_slug_product($slug){
		$rand = time().rand(10,99);
		$slug_check = Product::where('slug',$slug)->first();
		if($slug_check && $slug_check->count() > 0){
			$slug = $slug_check->slug.'-'.$rand;
			return $slug;
		}
		return $slug;
	}

	function getParentId($categoryId){
		if($categoryId == '' || $categoryId == 0){
			return 0;
		}else{
			$cat = Category::where('categoryId',$categoryId)->first();
			if($cat && $cat->count() > 0){
				return $cat->parentId;
			}else{
				return 0;
			}
		}
				
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
}
