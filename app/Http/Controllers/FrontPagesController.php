<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\FrontPageSetting;
use App\FaqData;
use App\ContactInfo;
use Mail;

class FrontPagesController extends Controller
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
	 
	public function home(){
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_home';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'Home';
		$data['link'] = '';
		$meta_keywords = '';
		$row = array();
		$row = FrontPageSetting::where('page_type','home')->where('status',1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
			}
		
		return view('admin.front_pages.home',['row'=>$row,'data'=>$data,'meta_keywords'=>$meta_keywords]);		
	}
	
	
    public function about()
    { 
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_about';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'About';
		$data['link'] = '';
		$meta_keywords = '';
		$row = array();
		$row = FrontPageSetting::where('page_type','about')->where('status',1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
			}
		
		return view('admin.front_pages.about',['row'=>$row,'data'=>$data,'meta_keywords'=>$meta_keywords]);
    }	
	
	
	public function faq(){
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_faq';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'FAQ';
		$data['link'] = '';
		$meta_keywords = '';
		$faqs = array();
		$row = array();
		$row = FrontPageSetting::where('page_type','faq')->where('status',1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
				$faqs = FaqData::where('status',1)->orderBy('id','asc')->get();
			}
		
		return view('admin.front_pages.faq',['row'=>$row,'data'=>$data,'meta_keywords'=>$meta_keywords,'faqs'=>$faqs]);		
	}
	
	public function delete_faq_data(Request $request){
		$req = $request->all();
		$id = $req['row_id'];
		$result = FaqData::where('id',$id)->delete();
		if($result){
			return "|success"; 
		}
	}
	
	public function terms(){
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_terms';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'Terms';
		$data['link'] = '';
		$meta_keywords = '';
		$row = array();
		$row = FrontPageSetting::where('page_type','terms')->where('status',1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
			}
		
		return view('admin.front_pages.terms',['row'=>$row,'data'=>$data,'meta_keywords'=>$meta_keywords]);		
	}

	public function privacy_policy(){
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_privacy_policy';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'Privacy Policy';
		$data['link'] = '';
		$meta_keywords = '';
		$row = array();
		$row = FrontPageSetting::where('page_type','privacy_policy')->where('status',1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
			}
		
		return view('admin.front_pages.privacy_policy',['row'=>$row,'data'=>$data,'meta_keywords'=>$meta_keywords]);		
	}	
	
	public function contact(){
		$data['nav'] = 'menu_front_pages';
		$data['sub_nav'] = 'menu_front_pages_contact';
		$data['title'] = 'Front Pages';
		$data['sub_title'] = 'Contact';
		$data['link'] = '';
		$meta_keywords = '';
		$row = array();
		$row = FrontPageSetting::where('page_type','contact')->where('status',1)->first();
		$contact_info = ContactInfo::limit(1)->first();
			if($row && $row->count() > 0){
				$meta_keywords = $this->page_meta_keywords($row->meta_keywords);
			}
		
		return view('admin.front_pages.contact',['row'=>$row,'contact_info'=>$contact_info,'data'=>$data,'meta_keywords'=>$meta_keywords]);		
	}
	
	public function save_data(Request $request){

		$validator = $request->validate([		 		 		 
             'page_title' => 'required',			 		 
             'meta_description' => 'required',			 		 	
		], 
			$messages = [
			'page_title.required' => 'Heading Title is required',
			'meta_description.required' => 'Meta Description is required',
		]);

		$req   = $request->all();
		$id = $req['id'];
		$meta_keywords = '';
		if(!empty($req['meta_keywords'])){
			$meta_keywords = implode(',',$req['meta_keywords']);
		}
		
		if($req['page_type'] == 'faq' || $req['page_type'] == 'contact' || $req['page_type'] == 'home'){
			$page_content = '';
		}else{
			$page_content = $req['page_content'];
		}			

		$input=array(
			'page_type'=>$req['page_type'],
			'page_content'=>$page_content,
			'page_title'=>trim($req['page_title']),
			'meta_keywords'=>$meta_keywords,
			'meta_description'=>trim($req['meta_description']),
			'updated_at'=>date('Y-m-d H:i:s'),
		);
		if($id!=''){
			FrontPageSetting::where('id',$id)->update($input);	
		}else{
			$input['created_at'] = date('Y-m-d H:i:s');
			$id = FrontPageSetting::create($input)->id;				
		}	
			if($req['page_type'] == 'faq'){
				
				$question = $req['question'];
				$answer = $req['answer'];
				$row_id = $req['row_id'];
				
				if(!empty($question) && !empty($answer) && !empty($row_id)){
					
					for($i=0;$i<count($row_id); $i++){
						$fdata = array(
							'question' => $question[$i],
							'answer' => $answer[$i],
							'updated_at'=>date('Y-m-d H:i:s'),							
						);
						if( $row_id[$i]!='0'){
							FaqData::where('id',$row_id[$i])->update($fdata);
							
						}else{
							$data['created_at'] = date('Y-m-d H:i:s');
							FaqData::create($fdata)->id;
						} 
					}
					
				}
			}
			
			if($req['page_type'] == 'contact'){
				$contact['contact_text'] = $req['contact_text'];
				$contact['contact_email'] = $req['contact_email'];
				$contact['contact_address'] = $req['contact_address'];
				$contact['contact_no'] = $req['contact_no'];
				$contact['google_map_src_code'] = $req['google_map_src_code'];
				$contact_id = $req['contact_id'];
				
				ContactInfo::where('id',$contact_id)->update($contact);					
			}
		echo "|success";

    }	
	
	public function page_meta_keywords($data){
		if(!empty($data)){
			$meta_keywords = explode(',',$data);
			$json_meta_keywords =  json_encode($meta_keywords);
			$json_meta_keywords = str_replace("[","",$json_meta_keywords);
			$json_meta_keywords = str_replace("]","",$json_meta_keywords);
			return $json_meta_keywords;
		}else{
			return '';
		}
		
	}	
}
