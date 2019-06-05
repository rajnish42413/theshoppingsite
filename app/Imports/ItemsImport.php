<?php

namespace App\Imports;

use App\Item;
use App\Brand;
use App\Merchant;
use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ItemsImport implements ToModel, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
		$category = 0;
		$parent_category = 0;
		$itemId = trim($row[0]);	// itemId
		$category = trim($row[1]);	// category
		$parent_category = trim($row[2]);	// parent_category
		$title = trim($row[3]);	// title
		
		$pslug = $this->slugify($title);
		$pslug = $this->check_slug_product($pslug);
			
		$price = trim($row[4]);	// price
		$currency = trim($row[5]);	// currency
		$brand = trim($row[6]);	// brand
		$item_url = trim($row[7]);	// item_url
		$payment_method = trim($row[8]);	// payment_method
		$quantity = trim($row[9]);	// quantity
		$description = trim($row[10]);	// description
		$merchant = trim($row[11]);	// merchant
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

		$merchant_id = 1; //default for ebay
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
        return new Item([
			'merchant_id' => $merchant_id,
            'itemId'     => $itemId,
            'title'     => $title,
            'slug'     => $pslug,
            'categoryId'    => $category,
            'parentCategoryId'    => $parent_category,
            'viewItemURL'    => $item_url,
            'current_price'    => $price,
            'current_price_currency'    => $currency,
            'brand_id'    => $brand_id,
            'PaymentMethods'    => $payment_method,
            'description'    => $description,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s')
			]);
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
