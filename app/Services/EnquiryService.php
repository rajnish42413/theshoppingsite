<?php
namespace App\Services;
use App\Enquiry;
use App\Contracts\EnquiryServiceContract;
use Illuminate\Support\Facades\Validator;

class EnquiryService implements EnquiryServiceContract
{
  
  public function getList($start,$length){
    $rescount = 0;
    $restotal = 0;
    $resArr = [];
    $currentPage = ceil(($start+1)/$length);
    $enquries = Enquiry::orderBy('updated_at', 'desc')->paginate($length,['*'],'page', $currentPage);
    $rescount = $enquries->count();
    $restotal = $enquries->total();
    $resArr = $enquries->toArray();
    return ['count' =>$rescount, 'total' => $restotal, 'data' => $resArr];
  }

  public function getInfo($id){
    return Enquiry::findOrFail($id);
  }

  public function saveInfo($input){
    $result = ['obj' => null, 'errors' => null, 'success' =>null];
    $rules=array(
      'name' => 'required',
      'email' => 'required|email',
      'message' => 'required',
      'contact_no' => 'required|numeric'
    );

    $validator = Validator::make($input, $rules);
    if ($validator->fails()){
      $result['errors'] = $validator->errors();
    }
    else{
		$result['obj'] = Enquiry::create($input);
		$result['success'] = collect(["Thanks for contacting us, we will get back to you shortly"]); 
	  
      
    }
    return $result;
  }

  public function deleteByIds($ids){
    return Enquiry::destroy($ids);
  }
}
