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
			$category = trim($row[2]);	// category
			$title = trim($row[3]);	// title			
			$price = trim($row[4]);	// price
			$currency = trim($row[5]);	// currency
			$brand = trim($row[6]);	// brand
			$item_url = trim($row[7]);	// item_url
			$quantity = trim($row[8]);	// quantity
			$description = trim($row[9]);	// description
			$product_image = trim($row[10]);	// product_image
			$gallery_images_str = trim($row[11]);	// gallery_images
			
			if($category!=''){
				$category_array = explode('>',$category);
			}
			//echo '<pre>';print_r($category_array);die;
			if($category_array){
				$x=1;
				$lastElement = end($category_array);	
				//echo $lastElement;die;
				foreach($category_array as $cat){
					$cat = trim($cat);//remove space
					//echo $cat;die;
					$cat_slug = $this->slugify($cat);
					//echo $cat_slug;die;
/* 					$cat_check = array();					
					$cat_check = Category::where('slug',$cat_slug)->first();
					if($cat_check && $cat_check->count() > 0){
						//echo '<pre>';print_r($cat_check);die;
						$catId = $cat_check->categoryId;
						echo 'rk'.$parentId = $cat_check->parentCategoryId;	die;					
						if($x == 1){
							$catID1 = $cat_check->categoryId;
						}
						if($x == 2){
							$catID2 = $cat_check->categoryId;
						}
						if($x == 3){
							$catID3 = $cat_check->categoryId;
						}
						if($x == 4){
							$catID4 = $cat_check->categoryId;
						}
					}else{ */
						$cinput = array();
						$cr = rand(111,999).rand(11111111,99999999).rand(111,999); //total 14 characters.
						$cinput['categoryId'] = $cr;
						//echo $parentId;die;
						$cinput['parentId'] = $parentId;
						$cinput['slug'] = $cat_slug;
						$cinput['catLevel'] = $x;
						$cinput['categoryName'] = $cat;
						$cinput['created_at'] =  date('Y-m-d H:i:s');
						$cinput['updated_at'] =  date('Y-m-d H:i:s');
						//echo '<pre>';print_R($cinput);die;
						$id = Category::create($cinput)->id;
						if($cat == $lastElement){
							$catId = $cinput['categoryId'];
						}else{
							$catId = $cinput['categoryId'];
							$parentId = $cinput['categoryId'];		
						}
						
						if($x == 1){
							$catID1 = $cinput['categoryId'];
						}
						if($x == 2){
							$catID2 = $cinput['categoryId'];
						}
						if($x == 3){
							$catID3 = $cinput['categoryId'];
						}
						if($x == 4){
							$catID4 = $cinput['categoryId'];
						}						
					//}
					$x++;
				}
			}
			
/* 			echo 'categoryId = '.$catId;
			echo '<br>';
			echo 'parentId = '.$parentId; 
			die; */
			$pslug = $this->slugify($title);
			$pslug = $this->check_slug_product($pslug);
			
			if($gallery_images_str !=''){
				$gi_arr = array();
				$gi_arr = explode(',',$gallery_images_str);
				if($gi_arr){
					$gallery_images_json = json_encode($gi_arr,true);
				}
			}
			
			$brand_id = 0;
			if($brand !=''){
				$input2 = array(
					'name' => $brand,
					'slug' => $this->slugify($brand),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$brand_check = Brand::where('slug',$input2['slug'])->first();
				if($brand_check && $brand_check->count() > 0){
					$brand_id = $brand_check->id;
					Brand::where('id',$brand_id)->update($input2);
				}else{
					$input2['updated_at'] = date('Y-m-d H:i:s');
					$brand_id = Brand::create($input2)->id;
				}
			}

			$merchant_id = 2; //default for amazon
 			if($merchant !=''){
				$input2 = array(
					'name' => $merchant,
					'slug' => $this->slugify($merchant),
					'updated_at' => date('Y-m-d H:i:s'),
				);
				$merchant_check = Merchant::where('slug',$input2['slug'])->first();
				if($merchant_check && $merchant_check->count() > 0){
					$merchant_id = $merchant_check->id;
					Merchant::where('id',$merchant_id)->update($input2);
				}else{
					$input2['updated_at'] = date('Y-m-d H:i:s');
					$merchant_id = Merchant::create($input2)->id;
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
				Product::where('itemId',$itemId)->update($uinput);
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
             '3' => function($attribute, $value, $onFailure) {
				 if($value != 'title'){
					  if ($value == '') {
						   $onFailure($attribute.' '.$value.' is required.');
					  }						 
				}
              },
             '4' => function($attribute, $value, $onFailure) {
				 if($value != 'price'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!is_numeric($value)) {
						   $onFailure($attribute.' value must be a number.');
					  }
				}
              },
             '7' => function($attribute, $value, $onFailure) {
				 if($value != 'item_url'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!filter_var($value, FILTER_VALIDATE_URL)) {
						   $onFailure($attribute.' value must be a valid url.');
					  }
				}
              },
             '8' => function($attribute, $value, $onFailure) {
				 if($value != 'quantity'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }						 
					  if (!is_numeric($value)) {
						   $onFailure($attribute.' value must be a number.');
					  }
				}
              },
             '10' => function($attribute, $value, $onFailure) {
				 if($value != 'product_image'){
					  if ($value == '') {
						   $onFailure($attribute.' value is required.');
					  }			
					  if (!filter_var($value, FILTER_VALIDATE_URL)) {
						   $onFailure($attribute.' value must be a valid image address.');
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
        return 500;
    }
	
    public function chunkSize(): int
    {
        return 500;
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
	
	function check_slug_product($slug){
		$rand = time().rand(10,99);
		$slug_check = Product::where('slug',$slug)->first();
		if($slug_check && $slug_check->count() > 0){
			$slug = $slug_check->slug.'-'.$rand;
			return $slug;
		}
		return $slug;
	}	
}
