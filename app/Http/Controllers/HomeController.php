<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;

use \Hkonnet\LaravelEbay\EbayServices;
use \DTS\eBaySDK\Finding\Types;

use App\Product;
use App\Category;
use App\Banner;
use App\FrontPageSetting;
use App\FaqData;

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
	
	public function contact(){
		$data['nav'] = 'contact';
		$row = FrontPageSetting ::where('page_type','contact')->first();
		$data['meta_title'] = $row->page_title;
		$data['meta_keywords']= $row->meta_keywords;
		$data['meta_description'] = $row->meta_description;
		$banner = Banner::where('section_name','contact')->orderBy('id','asc')->limit(1)->first();	
        return view('contact',['data'=>$data,'row'=>$row,'banner'=>$banner]);
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
		$banner = Banner::where('section_name','privacy_policy')->orderBy('id','asc')->limit(1)->first();	return view('privacy_policy',['data'=>$data,'row'=>$row,'banner'=>$banner]);
    }
	
	
	
	public function search_list(Request $request, $slug){
		$categories = array();
		$products = array();
		$data['parent_category'] = '';	
		$data['category'] = '';	
		
		if($slug != ''){
			$res = Category::where('slug',$slug)->first();
			if($res && $res->count() > 0){
				if($res->parentId == '0'){ // parent
					$data['parent_category'] = $res->categoryName;
					$categories = $this->get_categories($res->categoryId);
					$products = $this->get_products_by_parent($res->categoryId);			
				}else{
					$res2 = Category::where('categoryId',$res->parentId)->first();
					if($res2 && $res2->count() > 0){
						$data['parent_category'] = $res2->categoryName;
						$data['category'] = $res->categoryName;
						$categories = $this->get_categories($res->parentId);
						$products = $this->get_products_by_cat($res->categoryId);							
					}
				}				
			}
		}
		
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Search Products";
		$data['meta_keywords'] = config('app.name')." Search Products";
		$data['meta_description'] = config('app.name')." Search Products";	
		
        return view('search_products/list',['data'=>$data,'categories'=>$categories,'products'=>$products]);		
	}
	
	
	public function product_detail(Request $request,$id){

		$data['parent_category'] = "-";	
		$data['category'] = "-";	
		$product = array();
		$categories = array();
		if($id != ''){

			$product = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); })->where('products.itemId',$id)->first();
					
			if($product){
				$data['parent_category'] = $product->parentCategoryName;	
				$data['category'] = $product->categoryName;
				$categories = $this->get_categories($product->parentCategoryId);
			}
		}
		
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Product Detail";
		$data['meta_keywords'] = config('app.name')." Product Detail";
		$data['meta_description'] = config('app.name')." Product Detail";	
        return view('search_products/detail',['data'=>$data,'categories'=>$categories,'product'=>$product]);		
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
		$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($parent_id!= '0'){
			$results = $results->where('products.parentCategoryId',$parent_id);
		}		
		//offset(0)->limit(10)->
		$results = $results->orderBy('products.current_price','asc');
		$results = $results->get();
		if($results->count() > 0){
			$products = $results;
		}
		
		return $products;
	}	

	public function get_products_by_cat($cat_id=""){
		$products = array();

		$results = Product::select(DB::raw("products.*, categories.categoryName as categoryName, c2.categoryName as parentCategoryName"))->Join('categories',function ($join){$join->on('categories.categoryId','=','products.categoryId'); })->Join('categories as c2',function ($join){$join->on('c2.categoryId','=','products.parentCategoryId'); });
		
		if($cat_id!= '0'){
			$results = $results->where('products.CategoryId',$cat_id);
		}		
		//offset(0)->limit(10)->
		$results = $results->orderBy('products.current_price','asc');
		$results = $results->get();
		if($results->count() > 0){
			$products = $results;
		}
		
		return $products;
	}
	
}
