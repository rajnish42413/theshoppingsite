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
		$data['meta_desicription']="Top Products, Recommended Products, Top Deal";
		$banners = Banner::where('section_name','home_slider')->orderBy('id','asc')->limit(4)->get();
		return view('home',['data'=>$data,'banners'=>$banners]);
    }
	
	public function about(){
		$data['nav'] = 'about-us';
		$data['meta_title'] = config('app.name')." :: About Us";
		$data['meta_keywords']= config('app.name')." About Us";
		$data['meta_desicription'] = config('app.name')." About Us";
		
        return view('about',['data'=>$data]);
    }
	
	public function faq(){
		$data['nav'] = 'faq';
		$data['meta_title'] = config('app.name')." :: FAQ";
		$data['meta_keywords'] = config('app.name')." FAQ";
		$data['meta_desicription']= config('app.name')." FAQ";
        return view('faq',['data'=>$data]);
    }
	
	public function contact(){
		$data['nav'] = 'contact';
		$data['meta_title'] = config('app.name')." :: Contact Us";
		$data['meta_keywords'] = config('app.name')." Contact Us";
		$data['meta_desicription']= config('app.name')." Contact Us";
        return view('contact',['data'=>$data]);
    }

	public function terms(){
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Terms and Conditions";
		$data['meta_keywords'] = config('app.name')." Terms and Conditions";
		$data['meta_desicription'] = config('app.name')." Terms and Conditions";	
        return view('terms',['data'=>$data]);
    }

	public function privacy_policy(){
		$data['nav'] = 'privacy-policy';
		$data['meta_title'] = config('app.name')." :: Privacy & Policy";
		$data['meta_keywords'] = config('app.name')." Privacy & Policy";
		$data['meta_desicription'] = config('app.name')." Privacy & Policy";
        return view('privacy_policy',['data'=>$data]);
    }
	
	public function search_list(Request $request){
		$categoryId = $request->input('cat');
		$data['parent_category'] = "-";	
		if($categoryId != ''){
			$parent_category = Category::where('categoryId',$categoryId)->first();
			$data['parent_category'] = $parent_category->categoryName;	
			$categories = $this->get_categories($categoryId);
			$products = $this->get_products_by_parent($categoryId);
			
		}else{
			$categories = array();
			$products = array();
		}
		
		$data['nav'] = 'terms';
		$data['meta_title'] = config('app.name')." :: Search Products";
		$data['meta_keywords'] = config('app.name')." Search Products";
		$data['meta_desicription'] = config('app.name')." Search Products";	
		
        return view('search_products/list',['data'=>$data,'categories'=>$categories,'products'=>$products]);		
	}
	
	
	public function product_detail(Request $request){
		$id = $request->input('id');
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
		$data['meta_desicription'] = config('app.name')." Product Detail";	
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
	
}
