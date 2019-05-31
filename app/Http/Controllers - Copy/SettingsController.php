<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\Setting;
use App\SocialSetting;
use App\ApiSetting;
use Mail;



class SettingsController extends Controller
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
	
    public function add()
    { 
		$data['nav'] = 'menu_setting';
		$data['sub_nav'] = 'menu_setting_add';
		$data['title'] = 'Setting';
		$data['sub_title'] = 'Update';
		$data['link'] = '';		
		$site = array();		
		$social_links = array();
		$api_setting = array();
		$site = Setting::limit(1)->first();
		$social_links = SocialSetting::orderBy('id','asc')->get();
		$api_setting = ApiSetting::where('api_name','ebay')->first();
	
		return view('admin.setting.add',['data'=>$data,'site'=>$site,'social_links'=>$social_links,'api_setting'=>$api_setting]);
    }	
	
	public function save_data(Request $request){
		
		$validator = $request->validate([
             'title' => 'required',			 		 		 		 		 
             'description' => 'required',			 		 
		], 
			$messages = [
			'title.required' => 'Title is required',
			'description.required' => 'Description is required',
		]);		

		$req   = $request->all();
		$id = $req['id'];
		$description = $req['description'];
		$title = $req['title'];
		$google_analytics = $req['google_analytics'];
		$pre_fileName   ='';
		if(isset($req['file'])){	
			$file=$request->file('file');
			$name=$file->getClientOriginalName();
			$ext=$file->getClientOriginalExtension();
			$pre_fileName= 'logo'.time().rand().'.'.$ext;
			$file->move('assets/images/',$pre_fileName);
		}elseif($req['file_name'] != ''){
			$pre_fileName = $req['file_name'];
		}else{
			$m = json_encode(array('file'=>'Logo is required.')); 
			echo ($m."|0");	
			exit;
		}
		
		$input=array(
			'description'=> $description,
			'title'=> $title,
			'google_analytics'=> $google_analytics,
			'logo'=> $pre_fileName,
			'updated_at' => date('Y-m-d H:i:s'),
		);
			Setting::where('id',$id)->update($input);	

		echo '|success';				
    }

	public function save_data2(Request $request){

		$req   = $request->all();
		$id = $req['id'];
		$display_name = $req['display_name'];
		$value = $req['value'];
		$status = $req['status'];
		$social_icon = $req['social_icon'];
		if($value && $display_name && $status && $social_icon){
			for($i=0;$i<count($value);$i++){
				if($display_name[$i] !='' && $value[$i] != '' && $social_icon[$i] != ''){
					$input=array(
						'display_name'=> $display_name[$i],
						'value'=> $value[$i],
						'status'=> $status[$i],
						'social_icon'=> $social_icon[$i],
						'updated_at' => date('Y-m-d H:i:s'),
					);
					if($id[$i] != ''){
						SocialSetting::where('id',$id[$i])->update($input);
					}else{
						$input['created_at'] = date('Y-m-d H:i:s');
						SocialSetting::create($input)->id;
					}					
				}
			
			}
		}				

		echo '|success';				
    }
	
	public function save_data3(Request $request){
		
		$validator = $request->validate([
             'app_id' => 'required',			 		 		 		 		 
             'developer_id' => 'required',			 		 
             'certificate_id' => 'required',			 		 
             'token' => 'required',			 		 
             'api_name' => 'required',
             'mode' => 'required',
		], 
			$messages = [
			'app_id.required' => 'App ID is required',
			'developer_id.required' => 'Dev ID is required',
			'certificate_id.required' => 'Cert ID is required',
			'token.required' => 'Token is required',
			'api_name.required' => 'API is required',
			'mode.required' => 'Mode is required',
		]);		

		$req   = $request->all();
		$id = $req['id'];
		$app_id = $req['app_id'];
		$developer_id = $req['developer_id'];
		$certificate_id = $req['certificate_id'];
		$token = $req['token'];
		$api_name = $req['api_name'];
		$mode = $req['mode'];
		
		$input=array(
			'api_name'=> $api_name,
			'mode'=> $mode,
			'app_id'=> $app_id,
			'developer_id'=> $developer_id,
			'certificate_id'=> $certificate_id,
			'token'=> $token,
			'updated_at' => date('Y-m-d H:i:s'),
		);
		//echo '<pre>';print_r($input);die;
			ApiSetting::where('id',$id)->update($input);	

		echo '|success';				
    }
	
	public function social_link_delete(Request $request) {

		$deleteId = $request->input('id');
		SocialSetting::where('id',$deleteId)->delete();
		echo 'success';
    }		
}
