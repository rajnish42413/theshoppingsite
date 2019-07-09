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
    public function index()
    { 

		$data['nav'] = 'home';
		$row = FrontPageSetting ::where('page_type','home')->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banners = Banner::where('section_name','home_slider')->orderBy('id','asc')->limit(4)->get();
		$deals = Product::where('is_deal_of_the_day',1)->where('status',1)->orderBy('updated_at','desc')->limit(8)->get();
		$top_products = Product::where('is_top_product',1)->where('status',1)->orderBy('updated_at','desc')->limit(8)->get();
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
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Search Products";
		$data['meta_keywords'] = config('app.name')." Search Products";
		$data['meta_description'] = config('app.name')." Search Products";	

        return view('search_products/grid_list',['data'=>$data,'categories'=>$categories,'products'=>$products,'brands'=>$brands]);		
	}
	
	//search_by_brands
	
	public function product_detail(Request $request,$slug){
		
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Product Detail";
		$data['meta_keywords'] = config('app.name')." Product Detail";
		$data['meta_description'] = config('app.name')." Product Detail";
		$data['parent_category'] = "-";	
		$data['category'] = "-";
		$data['cat_breadcrumb']	= '';
		$product = array();
		$categories = array();
		if($slug != ''){

			$product = Product::select(DB::raw("products.*"))->where('products.slug',$slug)->where('products.status',1)->first();
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
		
		$parent_cat_id = $request->input('parent_cat_id');
		$brands_array = $request->input('brands');
		
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
			echo view('search_products/ajax_grid_list',['products'=>$results])->render();				
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
		$results = Brand::select(DB::raw("brands.*"))->Join('products',function ($join){$join->on('products.brand_id','=','brands.id'); });
		
		if($level == 1){
			$results = $results->where('products.catID1',$parent_id);
		}elseif($level == 2){
			$results = $results->where('products.catID2',$parent_id);
		}elseif($level == 3){
			$results = $results->where('products.catID3',$parent_id);
		}elseif($level == 4){
			$results = $results->where('products.catID4',$parent_id);
		}
		
		$results = $results->groupBy('brands.id');
		$results = $results->orderBy('brands.name','asc');
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
		$my_cat_id = '';
		
		if($request->isMethod('get') && $request->input('keyword') !=''){
			$keyword = array();
			$data['keyword_array'] = $keyword = $this->getParts($request->input('keyword')); 

			$data['keyword'] =  $request->input('keyword'); //string
			$data['search_category'] = $scat =  $request->input('cat'); //string slug
			
			$cat_value = Category::where('status',1)->where('categories.slug',$scat)->first();
			
			if($cat_value && $cat_value->count() > 0){	
				$my_cat_id = $cat_value->categoryId;
			}		
			
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
						
			$results = Product::select(DB::raw("products.*,merchants.image as merchant_image"))->leftJoin('merchants',function ($join){$join->on('products.merchant_id','=','merchants.id'); })->where('products.status',1);
			
			if($my_cat_id!=''){
					$results = $results->where('products.catID1',$my_cat_id);
				}
			
			if($keyword){
				$results = $results->where(function ($query) use($keyword) {
					for($s = 0; $s < count($keyword); $s++){
						//$query->orWhere('categories.categoryName','like',"%$keyword[$s]%");
						$query->orWhere('products.title','like',"%$keyword[$s]%");
					}      
				});
			}		
			
/* 			$orderByRowCase = '';
			if($keyword){
				$orderByRowCase .= ' CASE ';
				$r=1;
				for($s = 0; $s < count($keyword); $s++){
					$orderByRowCase .= ' WHEN `products`.`title` LIKE "%'.$keyword[$s].'%" then '.$r.' ';
					$r++;
				}
				$orderByRowCase .= ' END'; 
			} 
			
			if($orderByRowCase!=''){
				$results = $results->orderByRaw($orderByRowCase);
			} */
			
			$results = $results->groupBy('products.itemId');
			$results = $results->orderBy('products.current_price','asc');
			$results = $results->limit(10);
			$results = $results->get();
			
			$data['min_price'] = $this->getMinPriceByProductName($keyword);
			$data['max_price'] = $this->getMaxPriceByProductName($keyword);

			if($my_cat_id != ''){
				$categories = Category::where('status',1)->where('parentId',$my_cat_id)->get();
			}
			
			if($results && $results->count() > 0){
				$cat_ids = array();
				$brand_ids = array();
				foreach($results as $row){
					$cat_ids[] = $row->parentCategoryId;
					$brand_ids[] = $row->brand_id;
				}
				
				if($scat == ''){
					if($cat_ids){ 
						$cat_ids = array_values(array_unique($cat_ids)); 
						$categories = Category::whereIn('parentId',$cat_ids)->get();		
					}
				}
				
				if($brand_ids){ 
					$brand_ids = array_values(array_unique($brand_ids));
					$brands = Brand::whereIn('id',$brand_ids)->get();
				}		
			}			

			$data['nav'] = 'terms';
			$data['meta_title'] = config('app.name')." :: Search Products";
			$data['meta_keywords'] = config('app.name')." Search Products";
			$data['meta_description'] = config('app.name')." Search Products";	
			
			return view('search_products/grid_list_search',['data'=>$data,'categories'=>$categories,'products'=>$results,'brands'=>$brands]);		
				
		}else{
			return redirect($base_url);
		}
		
	}


	public function get_products_search_ajax(Request $request){
	
		$keyword = array();
		$my_cat_id = '';
		$data['keyword_array'] = $keyword = $this->getParts($request->input('keyword')); //array
		$data['keyword'] =  $request->input('keyword'); //string
		$data['search_category'] =  $scat = $request->input('cat'); //string
		$cat_value = Category::where('status',1)->where('categories.slug',$scat)->first();
		
		if($cat_value && $cat_value->count() > 0){	
			$my_cat_id = $cat_value->categoryId;
		}		
		$sorting_name = 'products.current_price';
		$sorting_p = 'asc';	
		$brands_array = array();
		
		$parent_cat_id = $request->input('parent_cat_id');
		$brands_array = $request->input('brands');
		
		//echo '<pre>'; print_r($brands_array); die;
		$cat_id = $request->input('cat_id');
		$pro_name = trim($request->input('pro_name'));
		$start_price = $request->input('dpriceMin');
		$end_price = $request->input('dpriceMax');
		$showing_result = $request->input('showing_result');
		$offset_val = $request->input('offset_val');
		$sorting_type = $request->input('sorting_type');
	
		$results = array();
		$results = Product::select(DB::raw("products.*,merchants.image as merchant_image"))->leftJoin('merchants',function ($join){$join->on('products.merchant_id','=','merchants.id'); })->where('products.status',1);
		if($my_cat_id != ''){
			$results = $results->where('products.catID1',$my_cat_id);
		}
				
		if($keyword){
			$results = $results->where(function ($query) use($keyword) {
				for($s = 0; $s < count($keyword); $s++){
					//$query->orWhere('categories.categoryName','like',"%$keyword[$s]%");
					$query->orWhere('products.title','like',"%$keyword[$s]%");
				}      
			});
		}	

		if($start_price!='' && $end_price!=''){
			$results = $results->where('products.current_price','>=',$start_price);
			$results = $results->where('products.current_price','<=',$end_price);
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
		
		//$results = $results->groupBy('products.itemId');
		$results = $results->orderBy($sorting_name,$sorting_p);
		if($offset_val!='' && $offset_val >= 10){
			$results = $results->offset($offset_val);
		}				
		$results = $results->limit($showing_result);
		 $results = $results->get();

		if($results && $results->count() > 0){			
		$count = $results->count();
			$output =  view('search_products/ajax_grid_list_search',['products'=>$results,'data'=>$data])->render();
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

}
