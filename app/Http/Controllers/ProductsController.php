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
        //echo '<pre>';print_r($srch);die;

        $qry = Product::select(DB::raw("products.*, categories.categoryName as catName1, c2.categoryName as catName2, c3.categoryName as catName3, c4.categoryName as catName4, categories.categoryId as catID1, c2.categoryId as catID2, c3.categoryId as catID3, c4.categoryId as catID4,merchants.name as merchant_name"))->leftJoin('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->leftJoin('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); })->leftJoin('categories as c3',function ($join){$join->on('c3.categoryId','=','products.catID3'); })->leftJoin('categories as c4',function ($join){$join->on('c4.categoryId','=','products.catID4'); })->leftJoin('merchants',function ($join){$join->on('merchants.id','=','products.merchant_id'); });
        //$qry = Product::select(DB::raw("products.*"));
	
		//$qry->where('categories.status',1);
		//$qry->where('c2.status',1);
		
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
		
		$qry->groupBy('products.id');
        
		if($order[0] == 'list_create'){
			$order[0] = 'products.created_at';
		}
		else if($order[0] == 'listId'){
			$order[0] = 'products.id';
		}
		else if($order[0] == 'id'){
			$order[0] = 'products.id';
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
			$result = Product::where('id',$id)->first();
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
			Product::where('id',$id)->update($input);	
		}else{
			$id = Product::create($input)->id;				
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
	
	public function importProcess(Request $request){
	
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
			$products = Product :: where('parentCategoryId',$parentCategoryId)->where('categoryId',$categoryId)->where('status',1)->orderBy('id','asc')->get(); //
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
		
					$brand = Brand::where('id',$row->brand_id)->first();
					if($brand && $brand->count() > 0){
						$brand_name = $brand->name;
					}else{
						$brand_name = '';
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
			Product::whereIn('id',$deleteIds)->delete();
			echo 'success';
		}
    }	
	
	public function status_update(Request $request) {
		
		if($request->isMethod('post')){
            $req = $request->all();
			$statusId = $req['id'];
			$status = $req['value'];
			Product::where('id',$statusId)->update(array('status'=>$status));
			echo 'success';
		}
    }
	
	public function status_multiple_update(Request $request) {
		
        if ($request->isMethod('post'))
        {
            $req    = $request->all();

			$statusIds = explode(' ,',$req['ids']);
			$status = $req['status'];
			Product::whereIn('id',$statusIds)->update(array('status'=>$status));
			echo 'success';
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
