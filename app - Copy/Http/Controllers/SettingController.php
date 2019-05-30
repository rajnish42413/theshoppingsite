<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use App\User;
use App\Settings;
use Mail;



class SettingController extends Controller
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
	
    public function add(){
		
		$data['nav'] = 'menu_setting';
		$data['sub_nav'] = 'menu_setting_add';
		$data['title'] = 'Setting';
		$data['link'] = '';
		$data['sub_title'] = 'Edit';
		$data['site_title'] = Settings::where('key','site.title')->first();
		$data['site_description'] = Settings::where('key','site.description')->first();
		$data['site_logo'] = Settings::where('key','site.logo')->first();
		$data['price_margin'] = Settings::where('key','site.hotel.defaultpricemargin')->first();
		return view('admin.setting.add',['data'=>$data]);
    }	
	
	public function save_data(Request $request){
		if ($request->isMethod('post')){
			$req   = $request->all();
			$site_logo  = $site_title = $site_description = $price_margin = '';	
			
			$site_title = $req['site_title'];
			$site_description = $req['site_description'];
			$price_margin = $req['price_margin'];
		
			if(isset($req['file'])){	
				$file=$request->file('file');
				$name=$file->getClientOriginalName();
				$ext=$file->getClientOriginalExtension();
				$site_logo= 'logo.'.$ext;
				$site_logo_loc = 'assets/img/';
				$file->move($site_logo_loc,$site_logo);

			}elseif($req['file_name'] != ''){
				$site_logo = $req['file_name'];
			}


			Settings::where('key','site.title')->update(array('value'=>$site_title));	
			Settings::where('key','site.description')->update(array('value'=>$site_description));	
			Settings::where('key','site.hotel.defaultpricemargin')->update(array('value'=>$price_margin));	
			Settings::where('key','site.logo')->update(array('value'=>$site_logo));	

			echo '|success';				
        }
    }
		
}
