<?php

namespace App\Imports;

use App\Product;
use App\Brand;
use App\Merchant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

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
		if($row[0] != 'item_id'){
			$category = 0;
			$parent_category = 0;
			$gallery_images_json = '';
			$itemId = trim($row[0]);	// itemId
			$merchant = trim($row[1]);	// merchant
			$category = trim($row[2]);	// category
			$parent_category = trim($row[3]);	// parent_category
			$title = trim($row[4]);	// title
			
			$pslug = $this->slugify($title);
			$pslug = $this->check_slug_product($pslug);
				
			$price = trim($row[5]);	// price
			$currency = trim($row[6]);	// currency
			$brand = trim($row[7]);	// brand
			$item_url = trim($row[8]);	// item_url
			$quantity = trim($row[9]);	// quantity
			$description = trim($row[10]);	// description
			$product_image = trim($row[11]);	// product_image
			$gallery_images_str = trim($row[12]);	// gallery_images
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
					'categoryId'    => $category,
					'parentCategoryId'    => $parent_category,
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
					'categoryId'    => $category,
					'parentCategoryId'    => $parent_category,
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
		'4' => 'title',
		'5' => 'price',
		'8' => 'item_url',
		'9' => 'quantity',
		'11' => 'product_image',
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
