<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use ZipArchive;
use PharData;

use App\Merchant;
use App\User;
use App\Category;
use App\Product;
use App\Brand;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use App\Imports\ProductsImport;
//use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;
use Mail;
require realpath('excel-export/vendor/autoload.php') ;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;	
	
class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
		
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

 
    public function index()
    { 
		$data['nav'] = 'menu_products';
		$data['sub_nav'] = 'menu_products_list';
		$data['title'] = 'Products';
		$data['sub_title'] = 'List';
		$data['link'] = 'products-add';
		$categories = Category::where('parentId',0)->where('status',1)->orderBy('id','asc')->get();
		
		$merchants = Merchant::where('status',1)->orderBy('id','asc')->get();
		return view('admin.products.list',['categories'=>$categories,'merchants'=>$merchants,'data'=>$data]);
    }
	
	
    public function ajax_list(Request $req){
		//echo 'yes';die;
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
       
	    $order[0] = 'products.updated_at';
	    $order[1] = 'desc';

        $qry = Product::select(DB::raw("products.itemId, products.title, products.current_price, products.current_price_currency,  products.status, products.viewItemURL as viewItemURL, categories.categoryName as catName1, c2.categoryName as catName2, products.catID3 as catName3, products.catID4 as catName4, categories.categoryId as catID1, c2.categoryId as catID2, merchants.name as merchant_name"))->leftJoin('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->leftJoin('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); })->leftJoin('merchants',function ($join){$join->on('merchants.id','=','products.merchant_id'); });
		
        if(isset($srch['title']))
        {
            $qry->where('products.title','like',"%" .$srch['title']. "%");
        }
		
        if(isset($srch['merchant_name']))
        {
            $qry->where('products.merchant_id',$srch['merchant_name']);
        }
		
        if(isset($srch['catName1']))
        {
            $qry->where('products.catID2',$srch['catName1']);
        }
		
        if(isset($srch['catName2']))
        {
            $qry->where('products.catID1',$srch['catName2']);
        }
		
        if(isset($srch['catName3']))
        {
            $qry->where('products.catID3',$srch['catName3']);
        }
		
        if(isset($srch['catName4']))
        {
            $qry->where('products.catID4',$srch['catName4']);
        }		
		
        
		if($order[0] == 'list_create'){
			$order[0] = 'products.created_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'products.itemId';
		}
		else if($order[0] == 'id'){
			$order[0] = 'products.itemId';
		}					
		
		$qry->orderByRaw("$order[0] $order[1]");	
		 
		//echo $qry->toSql();die;
        $data['results'] = [];
        $results = $qry->paginate($length);
        
        foreach($results as $rec){
            $data['results'][] = $rec;
        }
		//echo '<Pre>';print_r($data['results']);die;
        $total = count($data['results']);
        return $this->responseDTJson($req->draw,$results->total(), $results->total(), $data['results']);    
    }
	
    public function add($id="")
    { 
		$data['nav'] = 'menu_products';
		$data['sub_nav'] = 'menu_products_add';
		$data['title'] = 'Product';
		$data['sub_title'] = 'Add';
		$data['link'] = 'products-list';
		$categories = array();
		$categories = Category::get();
		$row = array();
		$result = array();
		if($id!=""){
			$result = Product::where('itemId',$id)->first();
			if($result){
				$row = $result;
				$data['sub_title'] = 'Edit';
			}
		}
		
		return view('admin.products.add',['row'=>$row,'data'=>$data,'categories'=>$categories]);
    }	
	
	public function save_data(Request $request){
		
		$validator = $request->validate([
             'is_deal_of_the_day' => 'required',			 
             'is_top_product' => 'required',			 		 		 		 		 
			], 
			$messages = [
			'is_deal_of_the_day.required' => 'Deal of the day is required',
			'is_top_product.required' => 'Top Product is required',
		]);		
			
		$req   = $request->all();
		$id = $req['id'];

		$input=array(
			'is_deal_of_the_day'=> $req['is_deal_of_the_day'],
			'is_top_product' => $req['is_top_product'],
			'status' => $req['status'],
		);
		if($id!=''){
			Product::on('mysql2')->where('itemId',$id)->update($input);	
		}else{
			$id = Product::on('mysql2')->create($input)->itemId;				
		}	

		echo "|success";
    }
	
	
    public function import()
    { 
		$data['nav'] = 'menu_products';
		$data['sub_nav'] = 'menu_products_import';
		$data['title'] = 'Product';
		$data['sub_title'] = 'Import';
		$data['link'] = 'products-list';
		
		return view('admin.products.import',['data'=>$data]);
    }
	
	public function faseImportProcess(Request $request){
			Product::on('mysql2')->truncate();
		if (Input::hasFile('file')){
			
			$file = request()->file('file');
			$ext =  $file->getClientOriginalExtension();
			$temp =$file->getPathName();
			$zipName = $file->getClientOriginalName();
		
			if($ext == 'csv' || $ext == 'xlsx'){	
				$users = (new FastExcel)->import($file, function ($line) {
					//echo '<pre>';print_R($line);die;
					$catId = 0;	
					$parentId = 0;	
					$catID1 = 0;
					$catID2 = 0;
					$catID3 = 0;
					$catID4 = 0;
					$category_array = array();
					$gallery_images_json = '';
					$itemId = trim($line['item_id']);	// itemId
					$merchant = trim($line['merchant']);	// merchant
					$categoryId = trim($line['category_id']);	// category_id optional

					$category =trim($line['category']);	// category names in order, separated by ' > ' 
					$title = trim($line['title']);	// title			
					$price = trim($line['price']);	// price
					$currency = trim($line['currency']);	// currency
					$brand = trim($line['brand']);	// brand
					$item_url = trim($line['item_url']);	// item_url
					$quantity = trim($line['quantity']);	// quantity
					$description = trim($line['description']);	// description
					$product_image = trim($line['product_image']);	// product_image
					$gallery_images_str = trim($line['gallery_images']);	// gallery_images
					$cat_check = array();
			
					if($product_image != '#'){
				$merchant_id = 0; //default
				/*
				if($merchant !=''){
					$input2 = array(
						'name' => $merchant,
						'slug' => $this->slugify($merchant),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$merchant_check = Merchant::where('slug',$input2['slug'])->first();
					if($merchant_check && $merchant_check->count() > 0){
						$merchant_id = $merchant_check->id;
						//Merchant::on('mysql2')->where('id',$merchant_id)->update($input2);
					}else{
						$input2['updated_at'] = date('Y-m-d H:i:s');
						$merchant_id = Merchant::on('mysql2')->create($input2)->id;
					}
					
				}
				*/
				$brand_id = '';
				/*
				if($brand !=''){
					$input3 = array(
						'name' => $brand,
						'slug' => $this->slugify($brand),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$brand_check = Brand::where('slug',$input3['slug'])->first();
					if($brand_check && $brand_check->count() > 0){
						$brand_id = $brand_check->id;
						Brand::on('mysql2')->where('id',$brand_id)->update($input3);
					}else{
						$input3['updated_at'] = date('Y-m-d H:i:s');
						$brand_id = Brand::on('mysql2')->create($input3)->id;
					}
				}
				*/				
				/*
				$cat_check = Category::->where('categoryId',$categoryId)->first();
				
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
							Category::on('mysql2')->create($cinput);	//create new category							
						}
						
						$catID1 = $parentId;
						$catID2 = $cinput['categoryId'];
						$catID3 = 0;
						$catID4 = 0;

					}
 
				}
				*/
				$pslug='';
				//$pslug = $this->slugify($title);
				//$pslug = $this->check_slug_product($pslug);
				
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
					Product::on('mysql2')->where('itemId',$itemId)->update($uinput);
				}else{
					$input = array(
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
					);	
					Product::on('mysql2')->create($input);				
				}

			} 
				}); ECHO 'SUCCESS';
	
				/*Excel::import(new ProductsImport,$file);
				$pre_fileName= time().rand().'.'.$ext;
				$file->move('csv',$pre_fileName);
				
				echo '|success';*/
			}
		}
	}
	
	
	
	
	public function check_slug_product($slug){
		$rand = time().rand(10,99);
		$slug_check = Product::where('slug',$slug)->first();
		if($slug_check && $slug_check->count() > 0){
			$slug = $slug_check->slug.'-'.$rand;
			return $slug;
		}
		return $slug;
	}

	public function getParentId($categoryId){
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
	
	public function getCatLevel($catID1,$catID2,$catID3,$catID4){
		
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
	public function get_total_insert_data(Request $request){
		$p_count = Product::count();
		$totalWidth = 97152;
		$percent = ($p_count*100/$totalWidth);
		echo $percent_friendly = number_format($percent, 2 ) . '%';
	}
	
	public function importProcess(Request $request){
	//Product::truncate();
		if (Input::hasFile('file')){
			
			$file = request()->file('file');
			$ext =  $file->getClientOriginalExtension();
			$temp =$file->getPathName();
			$zipName = $file->getClientOriginalName();		
			
			if($ext == 'csv' || $ext == 'xlsx'){				//CSV or Excel
				Excel::import(new ProductsImport,$file);
				$pre_fileName= time().rand().'.'.$ext;
				$file->move('csv',$pre_fileName);
				
				echo '|success';
				
			}elseif($ext == 'zip'){								// Zip file of CSV or Excel
				
				$zipFolder = $this->slugify($zipName);
				$zip = new ZipArchive;
				if ($zip->open($temp)) {
					$newZipFolder = 'csv/'.$zipFolder;
					if (!file_exists($newZipFolder)) {
						mkdir($newZipFolder, 0777, true);
					}					
					$zip->extractTo($newZipFolder.'/'); //extract zip files to folder
					for($i = 0; $i < $zip->numFiles; $i++) {
						$stat = $zip->statIndex($i);
						$csvFile =$stat['name'];
						$cext = pathinfo($csvFile, PATHINFO_EXTENSION);
						$csvFilePath = realpath($newZipFolder.'/'.$csvFile);				
						if($cext == 'csv' || $cext == 'xlsx'){
							Excel::import(new ProductsImport,$csvFilePath);					
						}else{
							//Delete new folder. 
							$this->deleteDir($newZipFolder);							
							echo '|zip_error';
							exit;
						}
					}
					
					$zip->close();
				}
				echo '|success';	
				
			}elseif($ext == 'gz'){								// gZip file of CSV or Excel
				$zipFolder = $this->slugify($zipName);
				$newZipFolder = 'csv/'.$zipFolder;
				if(!file_exists($newZipFolder)) {
					mkdir($newZipFolder, 0777, true);
				}
				try{				
					$phar = new PharData($temp);
					$phar->extractTo($newZipFolder.'/'); //extract gz files to folder
					foreach($phar as $ph){
						$csvFile =  $ph->getFileName();
						$cext = pathinfo($csvFile, PATHINFO_EXTENSION);
						$csvFilePath = realpath($newZipFolder.'/'.$csvFile);
						if($cext == 'csv' || $cext == 'xlsx'){
							Excel::import(new ProductsImport,$csvFilePath);					
						}else{
							//Delete new folder. 
							$this->deleteDir($newZipFolder);
							echo '|gz_error';
							exit;
						}	
					}
					
					echo '|success';	
				}catch (Exception $e) {
					echo '|gz_error2';
				}				
			}else{
				echo '|error';
			}
	
				
		}
		
	 }
	
	public function excel_genrate(Request $request){
		
		if($request->input('parent_id')!== NULL && $request->input('parent_id') != '' && $request->input('cat_id') !== NULL && $request->input('cat_id') != ''){
			$categoryId = $request->input('cat_id');
			$parentCategoryId = $request->input('parent_id');
			$products = Product::where('parentCategoryId',$parentCategoryId)->where('categoryId',$categoryId)->where('status',1)->orderBy('updated_at','desc')->get(); //
			if($products && $products->count() > 0){
				
				$spreadsheet = new Spreadsheet();
				$sheet = $spreadsheet->getActiveSheet();
				$spreadsheet->getActiveSheet()->getDefaultRowDimension()->setRowHeight(16); 
				$sheet->setCellValue('A1', 'item_id');
				$sheet->setCellValue('B1', 'category');
				$sheet->setCellValue('C1', 'parent_category');
				$sheet->setCellValue('D1', 'title');
				$sheet->setCellValue('E1', 'price');
				$sheet->setCellValue('F1', 'currency');
				$sheet->setCellValue('G1', 'brand');
				$sheet->setCellValue('H1', 'item_url');
				$sheet->setCellValue('I1', 'payment_method');
				$sheet->setCellValue('J1', 'quantity');
				$sheet->setCellValue('K1', 'description');
				
				$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(12);			
				$spreadsheet->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);		
				
				$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(100);
				$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(50);
				$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(20);
				$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(100);
				
				$c= 2;
				foreach($products as $row){
		
					
					if($row->brand_id == 0 || $row->brand_id == ''){
						$brand_name = '';
					}else{
						$brand_name = $row->brand_id;
					}
					
					if($row->description != ''){
						if($row->description != strip_tags($row->description)) {
							$description = '';
						}else{
							$description = $row->description;
						}						
					}else{
						$description = '';
					}

					$sheet->setCellValue('A'.$c, $row->itemId);
					$sheet->setCellValue('B'.$c, $row->categoryId);
					$sheet->setCellValue('C'.$c, $row->parentCategoryId);
					$sheet->setCellValue('D'.$c, $row->title);
					$sheet->setCellValue('E'.$c, $row->current_price);
					$sheet->setCellValue('F'.$c, $row->current_price_currency);	
					$sheet->setCellValue('G'.$c, $brand_name);	
					$sheet->setCellValue('H'.$c, $row->viewItemURL);	
					$sheet->setCellValue('I'.$c, $row->PaymentMethods);	
					$sheet->setCellValue('J'.$c, $row->Quantity);	
					$sheet->setCellValue('K'.$c, $description);	
					
				$c++;					
				}
				$styleArray = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['argb' => '00000000'],
						],
					],
				];

				$spreadsheet->getActiveSheet()->getStyle('A1:K'.$c)->applyFromArray($styleArray);
				
				//echo '<pre>'; print_r($spreadsheet); die;
				$filename = 'PRD'.time().rand(111,999).".xlsx";
				//$filename = 'PRD'.time().rand(111,999).".csv";
				$writer = new Xlsx($spreadsheet);
				//echo '<pre>'; print_r($writer); die;
				header('Content-Type: application/vnd.ms-excel');
				//header('Content-Type: application/csv');
				header('Content-Disposition: attachment; filename='.$filename);
				$writer->save("php://output");				
				
			}else{
				echo 'No Data Found';
				echo "<script>window.close();</script>";
			}
		}
	}
	
	
	
	public function delete_data(Request $request) {
		
        if ($request->isMethod('post')){
            $req    = $request->all();
			$deleteIds = explode(',',$req['ids']);
			Product::on('mysql2')->whereIn('itemId',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
	public function status_update(Request $request) {
		
		if($request->isMethod('post')){
            $req = $request->all();
			$statusId = $req['id'];
			$status = $req['value'];
			Product::on('mysql2')->where('itemId',$statusId)->update(array('status'=>$status));
			echo 'success';
		}
    }
	
	public function status_multiple_update(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();

			$statusIds = explode(' ,',$req['ids']);
			$status = $req['status'];
			Product::on('mysql2')->whereIn('itemId',$statusIds)->update(array('status'=>$status));
			echo 'success';
		}
    }	

	public static function slugify($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  //$text = iconv('utf-8', 'utf-8//TRANSLIT', $text);

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
	
	public function deleteDir($dirPath) { 
	//Delete all non-csv & non-xlsx files in the folder, but not delete the folder.
		if (! is_dir($dirPath)) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file)) {
				self::deleteDir($file);
			} else {
				$cext = pathinfo($file, PATHINFO_EXTENSION);
				if($cext == 'csv' || $cext == 'xlsx'){
					//nothing
				}else{
					unlink($file);
				}
				
			}
		}
		//rmdir($dirPath);
	}	
	
}
