<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

use \Hkonnet\LaravelEbay\EbayServices;
use \DTS\eBaySDK\Finding\Types;

use App\Brand;
use App\Product;
use App\Category;
use App\Banner;
use App\FrontPageSetting;
use App\FaqData;
use App\ContactInfo;
use App\Setting;
use App\Merchant;

use App\Contracts\EnquiryServiceContract;
use App\Mail\EnquiryNew;
use Mail;

class HomeController extends Controller
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
	public function index(){ 
		$deals=$top_products=$top_categories=array();
		$data['nav'] = 'home';
		$row = FrontPageSetting ::where('page_type','home')->first();
		
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		
		$banners = Banner::where('section_name','home_slider')->orderBy('id','asc')->limit(4)->get();
		
		$deals = Product::where('is_deal_of_the_day',1)->where('status',1)->distinct('itemId')->limit(8)->get();
		
		$top_products = Product::where('is_top_product',1)->where('status',1)->distinct('itemId')->limit(8)->get();
		
		$top_categories = Category::where('is_top_category',1)->where('status',1)->orderBy('id','asc')->limit(8)->get();

		return view('home',['data'=>$data,'banners'=>$banners,'deals'=>$deals,'top_categories'=>$top_categories,'top_products'=>$top_products]);
	}
	
	public function about(){
		$data['nav'] = 'about-us';
		$row = FrontPageSetting ::where('page_type','about')->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','about')->orderBy('id','asc')->limit(1)->first();
        return view('about',['data'=>$data,'row'=>$row,'banner'=>$banner]);
    }
	
	public function faq(){
		$data['nav'] = 'faq';
		$row = FrontPageSetting ::where('page_type','faq')->first();
		$faqs = FaqData ::where('status',1)->orderBy('id','asc')->get();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','faq')->orderBy('id','asc')->limit(1)->first();
        return view('faq',['data'=>$data,'row'=>$row,'faqs'=>$faqs,'banner'=>$banner]);
    }
	
	public function contact(Request $req,EnquiryServiceContract $esc){

		$data['success'] = array();
		$data['errors'] = array();		
        if($req->isMethod('post')){
		
            $input['name'] = trim($req->name);
            $input['email'] = trim($req->email);
            $input['subject'] = trim($req->subject);
            $input['message'] = trim($req->message);
			$input['contact_no'] = $req->contact_no;
            $data = $esc->saveInfo($input);
	
            if($data['obj']){
                Mail::send(new EnquiryNew($data['obj']));
            }
        }
		
		$data['nav'] = 'contact';
		$row = FrontPageSetting ::where('page_type','contact')->first();
		$contact_info = ContactInfo ::limit(1)->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','contact')->orderBy('id','asc')->limit(1)->first();	
        return view('contact',['data'=>$data,'row'=>$row,'contact_info'=>$contact_info,'banner'=>$banner,'success'=>$data['success'],'error'=>$data['errors']]);
    }

	public function terms(){
		$data['nav'] = 'terms';
		$row = FrontPageSetting ::where('page_type','terms')->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','terms')->orderBy('id','asc')->limit(1)->first();
        return view('terms',['data'=>$data,'row'=>$row,'banner'=>$banner]);
    }

	public function privacy_policy(){
		$data['nav'] = 'privacy-policy';
		$row = FrontPageSetting ::where('page_type','privacy_policy')->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','privacy_policy')->orderBy('id','asc')->limit(1)->first();	
		return view('privacy_policy',['data'=>$data,'row'=>$row,'banner'=>$banner]);
    }
	
	public function all_categories(){
		$settings = Setting::limit(1)->first();
		$data['nav'] = 'all_categories';
		if($settings && $settings->count() > 0){
			$data['meta_title'] = $settings->title." :: All Categories";
		}else{
			$data['meta_title'] = env('app_name')." :: All Categories";
		}
		
		$data['meta_keywords']= "All Categories";
		$data['meta_description'] = "All Categories";;		
		$cat_data = array();
		$categories_list = Category :: where('parentId',0)->where('status',1)->get();
		$categories = Category :: where('parentId',0)->where('status',1)->limit(1)->get();
 		if($categories && $categories->count() > 0){
			$i=0;
			foreach($categories as $cat){
						$cat_data[$i]['parent_cat_name'] = $cat->categoryName;
						$cat_data[$i]['parent_cat_id'] = $cat->categoryId;				
						$cat_data[$i]['parent_cat_slug'] = $cat->slug;				
						$cat_data[$i]['parent_image'] = $cat->image;				
				$sub_categories = Category :: where('parentId',$cat->categoryId)->where('status',1)->get();
				$cat_data[$i]['sub_categories'] = array();
				if($sub_categories && $sub_categories->count() > 0){
					$j=0;
					foreach($sub_categories as $ch){
						$cat_data[$i]['sub_categories'][$j]['child_cat_id'] = $ch->categoryId;
						$cat_data[$i]['sub_categories'][$j]['child_cat_name'] = $ch->categoryName;
						$cat_data[$i]['sub_categories'][$j]['child_cat_slug'] = $ch->slug;
						if($ch->image != ''){
							$cat_data[$i]['sub_categories'][$j]['child_cat_image'] = $ch->image;
						}else{
							$cat_data[$i]['sub_categories'][$j]['child_cat_image'] = 'no_image.png';
						}
						
						$child_categories = Category :: where('parentId',$ch->categoryId)->where('status',1)->get();
						
						$cat_data[$i]['sub_categories'][$j]['child_categories'] = array();
						if($child_categories && $child_categories->count() > 0){
							$k=0;
							foreach($child_categories as $cc){
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_id'] = $cc->categoryId;
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_name'] = $cc->categoryName;
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_slug'] = $cc->slug;
								$k++;
							}
						}
						
						$j++;
					}
					$i++;
				}
			}
		} 
		//echo '<pre>';print_r($cat_data);die;
		return view('all_categories',['data'=>$data,'cat_data'=>$cat_data,'categories_list'=>$categories_list]);
	}
	
	public function get_all_categories_ajax(Request $request){
		$cat_id = $request->input('cat_id');
		$cat_data = array();
		$categories = Category :: where('categoryId',$cat_id)->where('parentId',0)->where('status',1)->limit(1)->get();
 		if($categories && $categories->count() > 0){
			$i=0;
			foreach($categories as $cat){
						$cat_data[$i]['parent_cat_name'] = $cat->categoryName;
						$cat_data[$i]['parent_cat_id'] = $cat->categoryId;				
						$cat_data[$i]['parent_cat_slug'] = $cat->slug;				
						$cat_data[$i]['parent_image'] = $cat->image;				
				$sub_categories = Category :: where('parentId',$cat->categoryId)->where('status',1)->get();
				$cat_data[$i]['sub_categories'] = array();
				if($sub_categories && $sub_categories->count() > 0){
					$j=0;
					foreach($sub_categories as $ch){
						$cat_data[$i]['sub_categories'][$j]['child_cat_id'] = $ch->categoryId;
						$cat_data[$i]['sub_categories'][$j]['child_cat_name'] = $ch->categoryName;
						$cat_data[$i]['sub_categories'][$j]['child_cat_slug'] = $ch->slug;
						if($ch->image != ''){
							$cat_data[$i]['sub_categories'][$j]['child_cat_image'] = $ch->image;
						}else{
							$cat_data[$i]['sub_categories'][$j]['child_cat_image'] = 'no_image.png';
						}
						
						$child_categories = Category :: where('parentId',$ch->categoryId)->where('status',1)->get();
						
						$cat_data[$i]['sub_categories'][$j]['child_categories'] = array();
						if($child_categories && $child_categories->count() > 0){
							$k=0;
							foreach($child_categories as $cc){
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_id'] = $cc->categoryId;
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_name'] = $cc->categoryName;
								$cat_data[$i]['sub_categories'][$j]['child_categories'][$k]['cc_cat_slug'] = $cc->slug;
								$k++;
							}
						}
						
						$j++;
					}
					$i++;
				}
			}
		} 
		
		return view('all_categories_ajax',['cat_data'=>$cat_data])->render();
	}
	
	public function search_list(Request $request,$slug, $brand=''){
		$data['Lp'] =  $request->input('Lp');
		$starttime = $data['starttime'] = microtime(true); // Top of page
		$data['search_value'] =  $request->input('search');
		$categories = array();
		$products = array();
		$brands = array();
		$data['cat_breadcrumb'] = '';
		$data['parent_category'] = '';	
		$data['category'] = '';
		$data['parent_cat_id'] = '0';	
		$data['cat_id'] = '0';	
		$data['parent_cat_slug'] = '';	
		$data['cat_slug'] = '';			
		$data['min_price']	= '';
		$data['max_price'] = '';
		$data['brand_id'] = '';

				
		if($slug != ''){
			
			$res = Category::where('slug',$slug)->where('status',1)->first();	

					
			if($res && $res->count() > 0){
				$data['cat_breadcrumb'] = $this->getCatBredcrumb($res);
		
				if($res->parentId == '0'){ // parent
					$data['parent_category'] = $res->categoryName;
					$data['parent_cat_id'] = $res->categoryId;
					$data['parent_cat_slug'] = $res->slug;
					$data['cat_id'] = '0';
					
					$categories = $this->get_categories($res->categoryId);
					
					$products = $this->get_products_by_id($res->categoryId, $data['brand_id'], $res->catLevel);	
				
					$brands = $this->get_brands_by_parent($res->categoryId,$res->catLevel);	
					
				
					$data['min_price'] = $this->getMinPriceByParentCat($res->categoryId, $res->catLevel);
					
					$data['max_price'] = $this->getMaxPriceByParentCat($res->categoryId, $res->catLevel);				
				
				}else{
						
					$res2 = Category::where('categoryId',$res->parentId)->where('status',1)->first();
					
					if($res2 && $res2->count() > 0){
						$data['parent_category'] = $res2->categoryName;
						$data['category'] = $res->categoryName;
						$data['parent_cat_id'] = '0';
						$data['cat_id'] = $res->categoryId;						
						$data['cat_slug'] = $res2->slug;	
						$categories = $this->get_categories($res->categoryId);

						$products = $this->get_products_by_id($res->categoryId, $data['brand_id'], $res->catLevel);
							
						$brands = $this->get_brands_by_cat($res->categoryId,$res->catLevel);
							
						$data['min_price'] = $this->getMinPriceByCat($res->categoryId, $res->catLevel);
						
						$data['max_price'] = $this->getMaxPriceByCat($res->categoryId, $res->catLevel);	
					
					}
				}				
			}
		}
		$data['nav'] = 'products-by-category';
		$data['meta_title'] = config('app.name')." :: Search Products";
		$data['meta_keywords'] = config('app.name')." Search Products";
		$data['meta_description'] = config('app.name')." Search Products";	

        return view('search_products/grid_list',['data'=>$data,'categories'=>$categories,'products'=>$products,'brands'=>$brands,'category_data'=>$res]);		
	}
	
	//search_by_brands
	
	public function product_detail(Request $request,$slug){
		
		$data['keyword_k'] = '';
		$data['keyword_c'] = '';
		
		if($request->input('k')){
			$data['keyword_k'] = rawurldecode($request->input('k'));
		}elseif($request->input('c')){
			$data['keyword_c'] = rawurldecode($request->input('c'));
		}
		 
		$data['nav'] = 'product-detail';
		$data['meta_title'] = config('app.name')." :: Product Detail";
		$data['meta_keywords'] = config('app.name')." Product Detail";
		$data['meta_description'] = config('app.name')." Product Detail";
		$data['parent_category'] = "-";	
		$data['category'] = "-";
		$data['cat_breadcrumb']	= '';
		$product = array();
		$categories = array();
		if($slug != ''){

			$product = Product::select(DB::raw("products.*"))->where('products.slug',$slug)->where('products.status',1)->first($product);
			
			if($product && $product->count() > 0){
				
				$category = Category::where('categoryId',$product->categoryId)->first();
				if($category && $category->count() > 0){
					
					$data['category'] = $category->categoryName;	
					$data['cat_breadcrumb'] = $this->getCatBredcrumb($category);
				}else{
					$data['category'] = '';
				}
				$parent_category = Category::where('categoryId',$product->parentCategoryId)->first();
				if($parent_category && $parent_category->count() > 0){
					$data['parent_category'] = $parent_category->categoryName;	
				}else{
					$data['parent_category'] = '';
				}				
				
				$merchant = Merchant::where('id',$product->merchant_id)->first();
				
				return view('search_products/detail',['data'=>$data,'product'=>$product,'merchant'=>$merchant]);				
			}else{ 
			return redirect(env('APP_URL'));
		}
		}else{ 
			return redirect(env('APP_URL'));
		}
		
        		
	}	
	
	public function get_categories($parent_id=""){
		
		$categories = array();
		if($parent_id == ""){
			$parent_id = '0';
		}
		$results = Category::orderBy('id','asc');
		if($parent_id!= '0'){
			$results = $results->where('parentId',$parent_id)->where('status',1);
		}		
		$results = $results->get();
		if($results->count() > 0){
			$categories = $results;
		}
		return $categories;
	}
	public function get_products_by_id($id="",$brand_id="", $level=""){
		
		$products = array();
		if($id == ""){
			$id = '0';
		}
		$showing_result = 10;
		$results = Product::select(DB::raw("products.*,merchants.image as merchant_image"))->leftJoin('merchants',function ($join){$join->on('products.merchant_id','=','merchants.id'); })->where('products.status',1);
		
		if($level == 1){
			$results = $results->where('products.catID1',$id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$id);
		}
		
		if($brand_id!= ''){
			$results = $results->where('products.brand_id',$brand_id);
		}		
		$results = $results->groupBy('products.itemId');
		$results = $results->orderBy('products.current_price','asc');
		$results = $results->limit($showing_result);
		$results = $results->get();
		//echo $results;die;
		if($results->count() > 0){
			$products = $results;
		}
		
		return $products;
	}

	public function get_products_ajax(Request $request){
		$sorting_name = 'products.current_price';
		$sorting_p = 'asc';	
		$brands_array = array();
		$data['Lp'] = '';
		
		$parent_cat_id = $request->input('parent_cat_id');
		$brands_array = $request->input('brands');
		
		$data['Lp'] = $request->input('Lp');
		
		//echo '<pre>'; print_r($brands_array); die;
		$cat_id = $request->input('cat_id');
		$pro_name = trim($request->input('pro_name'));
		$start_price = $request->input('dpriceMin');
		$end_price = $request->input('dpriceMax');
		$offset_val = $request->input('offset_val');
		$showing_result = $request->input('showing_result');
		$sorting_type = $request->input('sorting_type');
	
		$results = array();
		
		if($parent_cat_id != '0'){
			$cat_check = Category::where('categoryId',$parent_cat_id)->first();
			$level = $cat_check->catLevel;
			
			$results = Product::select(DB::raw("products.*,merchants.image as merchant_image"))->leftJoin('merchants',function ($join){$join->on('products.merchant_id','=','merchants.id'); })->where('products.status',1);

			if($level == 1){
				$results = $results->where('products.catID1',$parent_cat_id);
			}elseif($level == 2){
				$results = $results->where('products.catID2',$parent_cat_id);
			}elseif($level == 3){
				$results = $results->where('products.catID3',$parent_cat_id);
			}elseif($level == 4){
				$results = $results->where('products.catID4',$parent_cat_id);
			}
		
		}else{
			$cat_check = Category::where('categoryId',$cat_id)->first();
			$level = $cat_check->catLevel;
			
			$results = Product::select(DB::raw("products.*,merchants.image as merchant_image"))->leftJoin('merchants',function ($join){$join->on('products.merchant_id','=','merchants.id'); })->where('products.status',1);

			if($level == 1){
				$results = $results->where('products.catID1',$cat_id);
			}elseif($level == 2){
				$results = $results->where('products.catID2',$cat_id);
			}elseif($level == 3){
				$results = $results->where('products.catID3',$cat_id);
			}elseif($level == 4){
				$results = $results->where('products.catID4',$cat_id);
			}
		}	

		if($start_price!='' && $end_price!=''){
			$results = $results->where('products.current_price','>=',$start_price);
			$results = $results->where('products.current_price','<',$end_price);
		}
		
		if($pro_name !=''){
			$results = $results->where('products.title','like',"%" .$pro_name. "%");
		}
		
		if($brands_array){
			$results = $results->whereIn('products.brand_id', $brands_array);
		}
		if($sorting_type == '1'){
			$sorting_name = 'products.current_price';
			$sorting_p = 'asc';
		}elseif($sorting_type == '2'){
			$sorting_name = 'products.current_price';
			$sorting_p = 'desc';
		}elseif($sorting_type == '3'){
			$sorting_name = 'products.itemId';
			$sorting_p = 'desc';
		}
		$results = $results->groupBy('products.itemId');
		$results = $results->orderBy($sorting_name,$sorting_p);
		if($offset_val!='' && $offset_val >= 10){
			$results = $results->offset($offset_val);
		}		
		$results = $results->limit($showing_result);
		$results = $results->get();
		//echo $results;die;
		if($results && $results->count() > 0){			
			echo view('search_products/ajax_grid_list',['products'=>$results,'data'=>$data])->render();				
		}else{
			echo '0';
		} 		
	}	
	
	public function getMaxPriceByParentCat($parent_id, $level=""){
		$results = Product::select(DB::raw("CEIL(MAX(current_price)) as price"));
		
		if($level == 1){
			$results = $results->where('products.catID1',$parent_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$parent_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$parent_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$parent_id);
		}
				
		$results = $results->first();
		
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}		
			
	}
	
	public function getMinPriceByParentCat($parent_id, $level=""){
		$results = Product::select(DB::raw("FLOOR(MIN(current_price)) as price"));
		if($level == 1){
			$results = $results->where('products.catID1',$parent_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$parent_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$parent_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$parent_id);
		}
				
		$results = $results->first();
		
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}
	}	
	
	public function getMaxPriceByCat($cat_id, $level=""){
		$results = Product::select(DB::raw("CEIL(MAX(current_price)) as price"));
		
		if($level == 1){
			$results = $results->where('products.catID1',$cat_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$cat_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$cat_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$cat_id);
		}	
		
		$results = $results->first();
		
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}		
			
	}
	
	public function getMinPriceByCat($cat_id, $level=""){
		$results = Product::select(DB::raw("FLOOR(MIN(current_price)) as price"));
		
		if($level == 1){
			$results = $results->where('products.catID1',$cat_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$cat_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$cat_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$cat_id);
		}	
		
		$results = $results->first();
		
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}
	}		


	public function get_brands_by_parent($parent_id="", $level=""){
		$brands = array();
		if($parent_id == ""){
			$parent_id = '0';
		}
		$results = Product::select(DB::raw("products.brand_id"));
		
		if($level == 1){
			$results = $results->where('products.catID1',$parent_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$parent_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$parent_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$parent_id);
		}
		
		$results = $results->groupBy('products.brand_id');
		$results = $results->orderBy('products.brand_id','asc');
		$results = $results->get();
		if($results->count() > 0){
			$brands = $results;
		}
		
		return $brands;
	}	

	public function get_brands_by_cat($cat_id="", $level=""){
		$brands = array();
		$results = Brand::select(DB::raw("brands.id,brands.slug,brands.name"))->Join('products',function ($join){$join->on('products.brand_id','=','brands.id'); });
		
		if($level == 1){
			$results = $results->where('products.catID1',$cat_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$cat_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$cat_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$cat_id);
		}
		$results = $results->groupBy('brands.id');
		$results = $results->orderBy('brands.name','asc');
		$results = $results->get();
		if($results->count() > 0){
			$brands = $results;
		}
		
		return $brands;
	}	
	
	public function search_data(Request $request){ //get form submit
	 
		$base_url= env('APP_URL');
		$data['search_category'] = '';
		$data['categoryId'] = '';
		$data['parentCategoryId'] = '';
		$data['brand_id'] = '';
		$data['from'] = 0;
		$data['size'] = 10;
		$data['min_price'] = '';
		$data['max_price'] = '';
		$data['sorting_type'] = 0;
		$data['Lp'] = '';
		
		if($request->isMethod('get') && $request->input('keyword') !=''){
			$keyword = array();
			
			$data['keyword'] =  $request->input('keyword'); //string
			$scat =  $request->input('cat'); //string slug
			$data['Lp'] =  $request->input('Lp'); //Lp
			
			$cat_value = Category::where('status',1)->where('categories.slug',$scat)->first();
			
			if($cat_value && $cat_value->count() > 0){	
				$data['categoryId'] = $cat_value->categoryId;
			}
			
			$merchant_ids = array();
			$merchantData = array();
			$cat_ids = array();
			$categories = array();
			$products = array();
			$brands = array();
			
			$res = $this->getSearchData($data);

			if($res['success'] == true){
				$results = $res['data'];
				//echo '<pre>';print_r($results);die;
				foreach($results as $row){
					if($row['_source']['merchant_id'] != ''){
						$merchant_ids[] = $row['_source']['merchant_id'];
					}
					if($row['_source']['categoryid'] != ''){
						$cat_ids[] = $row['_source']['categoryid'];
					}
					if($row['_source']['brand_id'] != ''){
						$brands[] = $row['_source']['brand_id'];
					}
				}
			}else{
				$results = array();
			}
			
			if($merchant_ids){
				$merchant_ids = array_values(array_unique($merchant_ids));
				$merchant_data = Merchant::whereIn('id',$merchant_ids)->get();
				if($merchant_data && $merchant_data->count() > 0){
					foreach($merchant_data as $mdata){
						$merchantData[$mdata->id] = $mdata->image;
					}
				}
			}
						
			if($scat == ''){
				if($cat_ids){ 
					$cat_ids = array_values(array_unique($cat_ids)); 
					//echo '<pre>';print_r($cat_ids);die;
					$categories = Category::whereIn('categoryId',$cat_ids)->get();		
				}
			}
			//echo '<pre>';print_r($categories);die;
			if($brands){ 
				$brands = array_values(array_unique($brands));
				
			}		
				
			$data['cat_breadcrumb'] = '';
			$data['parent_category'] = '';	
			$data['category'] = '';
			$data['parent_cat_id'] = '0';	
			$data['cat_id'] = '0';	
			$data['parent_cat_slug'] = '';	
			$data['cat_slug'] = '';			
			$data['min_price']	= '';
			$data['max_price'] = '';
			$data['brand_id'] = '';
		
			$data['nav'] = 'products-by-search';
			$data['meta_title'] = config('app.name')." :: Search Products";
			$data['meta_keywords'] = config('app.name')." Search Products";
			$data['meta_description'] = config('app.name')." Search Products";	
			
			return view('search_products/grid_list_search',['data'=>$data,'categories'=>$categories,'products'=>$results,'brands'=>$brands,'merchantData'=>$merchantData]);		
				
		}else{
			return redirect($base_url);
		}
		
	}


	public function get_products_search_ajax(Request $request){
	

		$data['categoryId'] =   '';
		$data['brand_id'] =   '';
		$data['parentCategoryId'] =   '';
		$data['Lp'] = '';
		$data['keyword'] =  $request->input('keyword'); //string
		$data['Lp'] =  $request->input('Lp'); //Lp
		$scat = $request->input('cat'); //string
		$cat_value = Category::where('status',1)->where('categories.slug',$scat)->first();
		
		if($cat_value && $cat_value->count() > 0){	
			$data['categoryId']  = $cat_value->categoryId;
		}		
		$sorting_name = 'current_price';
		$sorting_p = 'asc';	
		$brands_array = array();
		
		$parent_cat_id = $request->input('parent_cat_id');
		$brands_array = $request->input('brands');
		
		//echo '<pre>'; print_r($brands_array); die;
		$cat_id = $request->input('cat_id');
		$pro_name = trim($request->input('pro_name'));
		$data['min_price'] = $start_price = $request->input('dpriceMin');
		$data['max_price'] = $end_price = $request->input('dpriceMax');
		$data['size'] = $showing_result = $request->input('showing_result');
		$data['from'] = $offset_val = $request->input('offset_val');
		$data['sorting_type'] = $sorting_type = $request->input('sorting_type');
	
		$results = array();
		$merchant_ids = array();
		$merchantData = array();
			
		$res = $this->getSearchData($data);
		if($res['success'] == true){
			$results = $res['data'];
			//echo '<pre>';print_r($results);die;
			foreach($results as $row){
				$merchant_ids[] = $row['_source']['merchant_id'];
			}
		}	
		
		if($merchant_ids){
			$merchant_ids = array_values(array_unique($merchant_ids));
			$merchant_data = Merchant::whereIn('id',$merchant_ids)->get();
			if($merchant_data && $merchant_data->count() > 0){
				foreach($merchant_data as $mdata){
					$merchantData[$mdata->id] = $mdata->image;
				}
			}
		}

		if($results){			
		$count = count($results);
			$output =  view('search_products/ajax_grid_list_search',['products'=>$results,'data'=>$data,'merchantData'=>$merchantData])->render();
			echo $count.'|'.$output;
		}else{
			$output = '0|';
			echo $output;
		} 		
	}
	
	
	public function search_form(Request $request){ //multiple suggestions
		$base_url= env('APP_URL');
		$output = '';
		if($request->isMethod('post')){

			if($request->input('keyword') != ''){
				
				$str = $keyword = $this->getParts($request->input('keyword'));
				
				$products = Product::select(DB::raw('products.title AS name, products.itemId AS pid, "product" AS type, "none" AS custom'))->where('products.status',1);
				

				if($keyword){
					$products = $products->where(function ($query3) use($keyword) {
						for($s = 0; $s < count($keyword); $s++){
							$query3->orWhere('products.title','like',"%$keyword[$s]%");
						}      
					});
				}				
				
				
				$products = $products->groupBy('products.itemId'); 
				$products = $products->limit(16); 
				$results = $products->get(); 
				
				//$results = $products->union($first)->union($second)->toSql(); 
				//echo $results;die;
				$base_url= env('APP_URL');
				
				if($results && $results->count() > 0){
					$output .= '<div class="row"><div class="col-md-9">Search Suggestions:</div><div class="col-md-3"><button onclick="close_search()" class="btn btn-default btn-xs">Hide</button></div>';
					
					$output .= '<div class="row">';
					$i=1;
					$keyword_array = array();
					//echo '<pre>'; print_r($results);die;
					foreach($results as $row){
						
						$str = $row->name;
						
						//$k_val= $this->getSpecialParts($str);
						
						array_push($keyword_array,$str);
					}
					//echo '<pre>';print_R($keyword_array);die;
					if($keyword_array){
						$keyword_array = $this->array_flatten($keyword_array);
						$keyword_array = array_values(array_unique($keyword_array));
						if(count($keyword_array) > 12){
							$keyword_array = array_slice($keyword_array,0,12);
						}
						foreach($keyword_array as $ka){
							$title = (strlen($ka) > 26) ? substr($ka,0,23).'...' : $ka;
							
							$url = $base_url.'search?keyword='.urlencode($ka);
							$output .= '<div class="col-md-6"><a class="btn-link" href="'.$url.'" title="'.$ka.'">'.$title.'</a></div>';
						}
					}					
				}		
			}
		}
		echo $output;
	}
	
	
	
function getSpecialParts($string){
      $stopWords = array('i','a','about','an','and','are','as','at','be','by','com','de','en','for','from','how','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','the','www','their','good','very');
 
      $string = preg_replace('/\s\s+/i', '', $string); // replace whitespace
      $string = trim($string); // trim the string
      $string = preg_replace('/[^a-zA-Z0-9 -]/', '', $string); // only take alphanumerical characters, but keep the spaces and dashes too…
      $string = strtolower($string); // make it lowercase
 
      preg_match_all('/\b.*?\b/i', $string, $matchWords);
      $matchWords = $matchWords[0];
 
      foreach ( $matchWords as $key=>$item ) {
          if ( $item == '' || in_array(strtolower($item), $stopWords) || strlen($item) <= 3 ) {
              unset($matchWords[$key]);
          }
      }   
      $wordCountArr = array();
      if ( is_array($matchWords) ) {
          foreach ( $matchWords as $key => $val ) {
              $val = strtolower($val);
              if ( isset($wordCountArr[$val]) ) {
                  $wordCountArr[$val]++;
              } else {
                  $wordCountArr[$val] = 1;
              }
          }
      }
      arsort($wordCountArr);
      $wordCountArr = array_slice($wordCountArr, 0, 10);
	  
	  $string_array = array();
	  if($wordCountArr){
		foreach($wordCountArr as $key => $value){
			$string_array[] = $key;
		}
	  }
		$arr = array();
		$str =  implode(' ',$string_array);
		$str = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
		$arr[] = $str;
		$words = explode(" ", $str);
		$count = count($words);

		//echo implode(" ", array_slice($words, 0, $count)) . "<br>"; // first request
		while (--$count) {
			$arr[] =  implode(" ", array_slice($words, 0, $count));
		}
		return $arr;
		
}	


	public function getCatBredcrumb($res){

		$output = '';
		$arr = array();
		$base_url = env('APP_URL').'category/';
		$arr[] = '<li><a href="'.$base_url.$res->slug.'">'.$res->categoryName.'</a></li>';
		
		$res2 = Category :: where('categoryId',$res->parentId)->first();
		
		if($res2 && $res2->count() > 0){
			
			$arr[] = '<li><a href="'.$base_url.$res2->slug.'">'.$res2->categoryName.'</a></li>';
			
			$res3 = Category :: where('categoryId',$res2->parentId)->first();
			if($res3 && $res3->count() > 0){
				$arr[] = '<li><a href="'.$base_url.$res3->slug.'">'.$res3->categoryName.'</a></li>';
				
				$res4 = Category :: where('categoryId',$res3->parentId)->first();
				if($res4 && $res4->count() > 0){
					$arr[] =  '<li><a href="'.$base_url.$res4->slug.'">'.$res4->categoryName.'</a></li>';
				}				
			}			
			
		}
		
		if($arr){
			$arr = array_reverse($arr);
			$output = implode(' ',$arr);
		}
		
		return $output;
	}
	
	public function getParts($str){
		$arr = array();
		$str = preg_replace("/[^A-Za-z0-9 ]/", '', $str);
		$arr[] = $str;
		$words = explode(" ", $str);
		$count = count($words);
		
		while (--$count) {
			$arr[] =  implode(" ", array_slice($words, 0, $count));
		}
		return $arr;
	}
	
	
	function array_flatten($array) { 
	  if (!is_array($array)) { 
		return FALSE; 
	  } 
	  $result = array(); 
	  foreach ($array as $key => $value) { 
		if (is_array($value)) { 
		  $result = array_merge($result, array_flatten($value)); 
		} 
		else { 
		  $result[$key] = $value; 
		} 
	  } 
	  return $result; 
	}	
	
	public function getMaxPriceByProductName($keyword){					
		$results = Product::select(DB::raw("CEIL(current_price) as price"))->where('products.status',1);
		if($keyword){
			$results = $results->where(function ($query) use($keyword) {
				for($s = 0; $s < count($keyword); $s++){
					//$query->orWhere('categories.categoryName','like',"%$keyword[$s]%");
					$query->orWhere('products.title','like',"%$keyword[$s]%");
				}      
			});
		}
		$results = $results->orderBy('products.current_price','desc')->limit(1);
		$results = $results->first();
		
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}		
	}
	
	public function getMinPriceByProductName($keyword){					
		$results = Product::select(DB::raw("FLOOR(current_price) as price"))->where('products.status',1);
		if($keyword){
			$results = $results->where(function ($query) use($keyword) {
				for($s = 0; $s < count($keyword); $s++){
					//$query->orWhere('categories.categoryName','like',"%$keyword[$s]%");
					$query->orWhere('products.title','like',"%$keyword[$s]%");
				}      
			});
		}
		$results = $results->orderBy('products.current_price','asc')->limit(1);
		$results = $results->first();
	
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return 0;
		}		
	}	


	function getSearchData($data){
		//echo '<pre>'; print_R($data);die;
		$requestArray = array();
		
		$requestArray['from'] = $data['from'];
		$requestArray['size'] = $data['size'];
		$requestArray['query'] = array();
		
		
		if($data['sorting_type'] == 1){
			$requestArray['sort'] = array('current_price'=>array('order'=>'asc'));
		}elseif($data['sorting_type'] == 2){
			$requestArray['sort'] = array('current_price'=>array('order'=>'desc'));
		}elseif($data['sorting_type'] == 3){
			$requestArray['sort'] = array('created_at'=>array('order'=>'desc'));
		}else{
			//nothing
		}
		
		$must = array();
		
		if($data['keyword'] !=''){
			$arr1 = array('match'=>array('title'=>$data['keyword']));
			array_push($must,$arr1);
		}
		if($data['categoryId'] !=''){
			$arr2 = array('match'=>array('categoryid'=>$data['categoryId']));
			array_push($must,$arr2);
		}
		if($data['brand_id'] !=''){
			$arr3 = array('match'=>array('brand_id'=>$data['brand_id']));
			array_push($must,$arr3);
		}
		if($data['parentCategoryId'] !=''){
			$arr4 = array('match'=>array('parentcategoryid'=>$data['parentCategoryId']));
			array_push($must,$arr4);
		}
		if($data['min_price'] !='' && $data['max_price'] !=''){
			$arr5 = array('range'=>array('current_price'=>array('gte'=>$data['min_price'],'lte'=>$data['max_price'],'boost'=>'2.0')));
			array_push($must,$arr5);
		}	

		$arr6 = array('match'=>array('status'=>true));
		array_push($must,$arr6);
		
		$requestArray['query']['bool']['must'] = $must;

		$requestJson = json_encode($requestArray,true);
		
		//echo $requestJson;die;
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_PORT => "9500",
		CURLOPT_URL => "http://3.130.7.225:9500/products/_search?pretty=",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $requestJson,
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"content-type: application/json",
		"postman-token: 1f45ec37-01cb-026e-1455-62b4357d18c9"
		),
		));

		$response = curl_exec($curl);
		
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			$res = "cURL Error #:" . $err;
			$output = array('success'=>false,'data'=>$res);
		} else {
			$res =  json_decode($response,true);
			//echo '<pre>';print_R($res);die;
			if($res['hits']['hits']){
				$res_data = $res['hits']['hits'];
				$output = array('success'=>true,'data'=>$res_data);
			}else{
				$error = 'No Results';
				$output = array('success'=>false,'data'=>$error);
			}
			
		}
		
		return $output;
	}
}


