<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\GoogleAnalytics;
use App\Category;
use Mail;



class GoogleAnalyticsController extends Controller
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
		$data['nav'] = 'menu_google_analytics';
		$data['sub_nav'] = 'menu_google_analytics_add';
		$data['title'] = 'Google Analytics Setting';
		$data['sub_title'] = 'Update';
		$data['link'] = 'google-analytics-list';		
		$row = array();
		$result = array();
		$result = GoogleAnalytics::limit(1)->first();
		if($result){
			$row = $result;
			$data['sub_title'] = 'Update';
		}
		
		
		return view('admin.google_analytics.add',['row'=>$row,'data'=>$data]);
    }	
	
	public function save_data(Request $request){
/* 		$validator = Validator::make($request->all(), [
             'content' => 'required',			 		 		 
             'status' => 'required',			 		 		 		  		 
			], 
			$messages = [
			'content.required' => 'Content is required',
			'status.required' => 'Staus is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{ */
			$req   = $request->all();
			$id = $req['id'];
			$content = $req['content'];
			$status = $req['status'];

			$input=array(
				'content'=> $content,
				'status'=> $status,
				'updated_at' => date('Y-m-d H:i:s'),
			);
				GoogleAnalytics::on('mysql2')->where('id',$id)->update($input);	

			echo '|success';				
        //}
    }

}
