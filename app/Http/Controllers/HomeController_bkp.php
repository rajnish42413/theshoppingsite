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
		$data['meta_title']= config('app.name')." :: Home";
		$data['meta_keywords']="Top Products, Recommended Products, Top Deal";
		$data['meta_description']="Top Products, Recommended Products, Top Deal";
		$banners = Banner::where('section_name','home_slider')->orderBy('id','asc')->limit(4)->get();
		$deals = Product::where('is_deal_of_the_day',1)->orderBy('id','asc')->limit(8)->get();
		$top_products = Product::where('is_top_product',1)->orderBy('id','asc')->limit(8)->get();
		$top_categories = Category::where('is_top_category',1)->orderBy('id','asc')->limit(8)->get();
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
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','contact')->orderBy('id','asc')->limit(1)->first();	
        return view('contact',['data'=>$data,'row'=>$row,'banner'=>$banner,'success'=>$data['success'],'error'=>$data['errors']]);
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
		$data['nav'] = 'all_categories';
		$data['meta_title'] = env('app_name')." :: All Categories";
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
	
	public function search_list(Request $request, $slug){
		$categories = array();
		$products = array();
		$brands = array();
		$data['parent_category'] = '';	
		$data['category'] = '';
		$data['parent_cat_id'] = '0';	
		$data['cat_id'] = '0';	
		$data['parent_cat_slug'] = '';	
		$data['cat_slug'] = '';			
		$data['min_price']	= '';
		$data['max_price'] = '';
		if($slug != ''){
			$res = Category::where('slug',$slug)->first();
			if($res && $res->count() > 0){
				if($res->parentId == '0'){ // parent
					$data['parent_category'] = $res->categoryName;
					$data['parent_cat_id'] = $res->categoryId;
					$data['parent_cat_slug'] = $res->slug;
					$data['cat_id'] = '0';
					$categories = $this->get_categories($res->categoryId);
					$products = $this->get_products_by_parent($res->categoryId);	
					$brands = $this->get_brands_by_parent($res->categoryId);	
					$data['min_price'] = $this->getMinPriceByParentCat($res->categoryId);
					$data['max_price'] = $this->getMaxPriceByParentCat($res->categoryId);
				}else{
					$res2 = Category::where('categoryId',$res->parentId)->first();
					if($res2 && $res2->count() > 0){
						$data['parent_category'] = $res2->categoryName;
						$data['category'] = $res->categoryName;
						$data['parent_cat_id'] = '0';
						$data['cat_id'] = $res->categoryId;						
						$data['cat_slug'] = $res2->slug;						
						$categories = $this->get_categories($res->parentId);
						$products = $this->get_products_by_cat($res->categoryId);
						$brands = $this->get_brands_by_cat($res->categoryId);
						$data['min_price'] = $this->getMinPriceByCat($res->categoryId);
						$data['max_price'] = $this->getMaxPriceByCat($res->categoryId);						
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
	
	public function product_detail(Request $request,$id){

		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Product Detail";
		$data['meta_keywords'] = config('app.name')." Product Detail";
		$data['meta_description'] = config('app.name')." Product Detail";
		$data['parent_category'] = "-";	
		$data['category'] = "-";		
		$product = array();
		$categories = array();
		if($id != ''){

			$product = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); })->where('products.itemId',$id)->first();
					
			if($product && $product->count() > 0){
				$data['parent_category'] = $product->parentCategoryName;	
				$data['category'] = $product->categoryName;
				$categories = $this->get_categories($product->parentCategoryId);
				
				return view('search_products/detail',['data'=>$data,'categories'=>$categories,'product'=>$product]);				
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
			$results = $results->where('parentId',$parent_id);
		}		
		$results = $results->get();
		if($results->count() > 0){
			$categories = $results;
		}
		return $categories;
	}

	public function get_products_by_parent($parent_id=""){
		$products = array();
		if($parent_id == ""){
			$parent_id = '0';
		}
		$showing_result = 10;
		$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($parent_id!= '0'){
			$results = $results->where('products.parentCategoryId',$parent_id);
		}		
		//offset(0)->limit(10)->
		$results = $results->orderBy('products.current_price','asc');
		$results = $results->limit($showing_result);
		$results = $results->get();
		if($results->count() > 0){
			$products = $results;
		}
		
		return $products;
	}	

	public function get_products_by_cat($cat_id=""){
		$products = array();
		$showing_result = 10;
		$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($cat_id!= '0'){
			$results = $results->where('products.CategoryId',$cat_id);
		}		
		//offset(0)->limit(10)->
		$results = $results->orderBy('products.current_price','asc');
		$results = $results->limit($showing_result);
		$results = $results->get();
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
		$showing_result = $request->input('showing_result');
		$sorting_type = $request->input('sorting_type');
	
		$results = array();
		
		if($parent_cat_id != '0'){
			$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
			$results = $results->where('products.parentCategoryId',$parent_cat_id);			
		}else{
			$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });			
			$results = $results->where('products.CategoryId',$cat_id);
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
			$sorting_name = 'products.id';
			$sorting_p = 'desc';
		}
		
		$results = $results->orderBy($sorting_name,$sorting_p);
		$results = $results->limit($showing_result);
		$results = $results->get();
		//echo $results->toSql();die;
		if($results && $results->count() > 0){			
			echo view('search_products/ajax_grid_list',['products'=>$results])->render();				
		}else{
			echo '0';
		} 		
	}	
	
	public function getMaxPriceByParentCat($parent_id){
		$results = Product::select(DB::raw("CEIL(MAX(current_price)) as price"))->where('parentCategoryId',$parent_id)->first();
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}		
			
	}
	
	public function getMinPriceByParentCat($parent_id){
		$results = Product::select(DB::raw("FLOOR(MIN(current_price)) as price"))->where('parentCategoryId',$parent_id)->first();
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}
	}	
	
	public function getMaxPriceByCat($cat_id){
		$results = Product::select(DB::raw("CEIL(MAX(current_price)) as price"))->where('categoryId',$cat_id)->first();
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}		
			
	}
	
	public function getMinPriceByCat($cat_id){
		$results = Product::select(DB::raw("FLOOR(MIN(current_price)) as price"))->where('categoryId',$cat_id)->first();
		if($results && $results->count() > 0 && $results->price != null){
			return $results->price;
		}else{
			return '';
		}
	}		


	public function get_brands_by_parent($parent_id=""){
		$brands = array();
		if($parent_id == ""){
			$parent_id = '0';
		}
		$results = Brand::select(DB::raw("brands.*"))->Join('products',function ($join){$join->on('products.brand_id','=','brands.id'); })->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($parent_id!= '0'){
			$results = $results->where('products.parentCategoryId',$parent_id);
		}		
		$results = $results->groupBy('brands.id');
		$results = $results->orderBy('brands.name','asc');
		$results = $results->get();
		if($results->count() > 0){
			$brands = $results;
		}
		
		return $brands;
	}	

	public function get_brands_by_cat($cat_id=""){
		$brands = array();
		$results = Brand::select(DB::raw("brands.*"))->Join('products',function ($join){$join->on('products.brand_id','=','brands.id'); })->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($cat_id!= '0'){
			$results = $results->where('products.CategoryId',$cat_id);
		}		
		$results = $results->groupBy('brands.id');
		$results = $results->orderBy('brands.name','asc');
		$results = $results->get();
		if($results->count() > 0){
			$brands = $results;
		}
		
		return $brands;
	}	
	
	public function search_form(Request $request){
		
		$output = '';
		$search_value = $request->input('search_value');
		if($search_value != ''){		
 		
		$first = Category::select(DB::raw('categories.categoryName AS name, categories.slug AS pid , "category" AS type'))->where('categories.status',1)->where('categories.categoryName','like',"%$search_value%");
		$products = Product::select(DB::raw('products.title AS name, products.itemId AS pid, "product" AS type'))->where('products.status',1)->where('products.title','like',"%$search_value%");
		
		$results = $products->union($first)->limit(12)->get(); 

		
		if($results && $results->count() > 0){
			$output .= '<div class="row"><div class="col-md-9">Search Suggestions:</div><div class="col-md-3"><button onclick="close_search()" class="btn btn-default btn-xs">Hide</button></div>';
			
			$output .= '<div class="row">';
			$i=1;
			foreach($results as $row){
			//foreach start
			if($row->type == 'category'){
				$title = (strlen($row->name) > 30) ? substr($row->name,0,27).'...' : $row->name;
				$url = env('APP_URL').'category/'.$row->pid;
				$output .= '<div class="col-md-6"><a class="btn-link" href="'.$url.'">'.$title.'</a></div>';
			}elseif($row->type == 'product'){
				$title = (strlen($row->name) > 30) ? substr($row->name,0,27).'...' : $row->name;
				$url = env('APP_URL').'product/'.$row->pid;
				$output .= '<div class="col-md-6"><a class="btn-link" href="'.$url.'">'.$title.'</a></div>';
			} 

			$i++;
			//foreach end				
			}
			$output .= '</div>';
		}

			
			

			
			
		}
		echo $output;
		
	}
}
