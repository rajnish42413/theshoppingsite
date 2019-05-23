<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Auth;
use DB;
use Session;
use App\User;
use App\CurrencyCodes;
use App\CartData;
use App\CartItems;
use App\RoomBasisCodes;
use App\TravelBookingDetails;
use App\Contracts\HotelApiServiceContract;

class DashboardController extends Controller
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
    public function index(){
		$data['nav'] = 'menu_dashboard';
		$data['sub_nav'] = '';
		$data['title'] = 'Dashboard';
		$data['sub_title'] = '';
		$data['link'] = 'admin';		
        return view('dashboard.index',['data'=>$data]);
    }
	
    public function profile(){
		if(Auth::check() && Auth::user()->role_id == 2){
			$data['nav'] = 'menu_user_profile';
			$data['sub_nav'] = '';
			$data['title'] = 'My Profile';
			$data['sub_title'] = '';
			$data['link'] = 'dashboard';
			$row = User::where('id',Auth::user()->id)->first();	
			$data['meta_title']="Nytstay ::".$row->name;
			//$data['meta_keywords']="Nytstay Checkout";
			//$data['meta_desicription']="Nytstay Checkout";				
				
			return view('dashboard.profile',['data'=>$data,'row'=>$row]);			
		}else{
			return redirect('home');
		}
    }

	public function profile_update(Request $request){
		$validator = Validator::make($request->all(), [
             'name' => 'required',			 
             'email' => 'required|email',			 
             'phone' => 'required',			 
             'address' => 'required',			 
			], 
			$messages = [
			'name.required' => 'Name is required',
			'email.required' => 'Email is required',
			'email.email' => 'Email is not valid',
			'phone.required' => 'Phone is required',
			'address.required' => 'Address is required',
		])->validate();	

        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			$req   = $request->all();
			$id = Auth::user()->id;

			$input=array(
				'name'=> $req['name'],
				'email' => trim($req['email']),
				'phone' => trim($req['phone']),
				'address' => trim($req['address']),
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if($id!=''){
				User::where('id',$id)->update($input);	
			}	
			echo '|success';			
		}			
    }	
	
    public function change_password(){
		if(Auth::check() && Auth::user()->role_id == 2){
			$data['nav'] = 'menu_user_change_password';
			$data['sub_nav'] = '';
			$data['title'] = 'Change Password';
			$data['sub_title'] = '';
			$data['link'] = 'dashboard';	
			$data['meta_title']="Nytstay :: Change Password";
			$row = User::where('id',Auth::user()->id)->first();		
			return view('dashboard.change_password',['data'=>$data,'row'=>$row]);			
		}else{
			return redirect('home');
		}
    }

	
	public function password_update(Request $request){

		$validator = Validator::make($request->all(), [
             'old_password' => 'required',			 		 
             'password' => 'required|confirmed',			 
			], 
			$messages = [
			'old_password.required' => 'old password is required.',
			'password.required' => 'new password is required.',
			'password_confirmation.confirmed' => 'confirm password does not match.',
		])->validate();	
        if (isset($validator) && $validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }else{
			
			$req   = $request->all();
			$id = Auth::user()->id;

			$opass= $req['old_password'];
			$npass= $req['password'];
			$oPassword = Hash::make($opass);
			$user = User::find(auth()->user()->id);
			if(!Hash::check($opass, $user->password)){
				echo 'old_pass_error';
			}else{
				$nPassword = Hash::make($npass);
				User::where('id',Auth::user()->id)->update(array('password'=>$nPassword,'updated_at' => date('Y-m-d H:i:s')));
				echo 'success';
				
			}	
		}
    }	

	public function image_update(Request $request){
		if ($request->isMethod('post')){
			$req   = $request->all();
			$id = Auth::user()->id;
			$pre_fileName   ='';
			if(isset($req['file'])){	
				$file=$request->file('file');
				$name=$file->getClientOriginalName();
				$ext=$file->getClientOriginalExtension();
				$pre_fileName= time().rand().'.'.$ext;
				$file->move('user_profile_files',$pre_fileName);

			}elseif($req['file_name'] != ''){
				$pre_fileName = $req['file_name'];
			}
			
			$input=array(
				'image'=> $pre_fileName,
				'updated_at' => date('Y-m-d H:i:s'),
			);
			if($id!=''){
				User::where('id',$id)->update($input);	
			}	
			echo '|success';				
        }
    }

    public function booking(){
		if(Auth::check() && Auth::user()->role_id == 2){
			$data['nav'] = 'menu_user_booking';
			$data['sub_nav'] = 'menu_user_booking_upcoming';
			$data['title'] = 'Upcoming Booking';
			$data['sub_title'] = '';
			$data['link'] = 'dashboard';
			$data['meta_title']="Nytstay :: Upcoming Booking";			
			$data['booking_status'] = 0;	
			return view('dashboard.booking',['data'=>$data,]);			
		}else{
			return redirect('home');
		}

    }

    public function booking_detail($cid,HotelApiServiceContract $hasc){
		$cart= $mydata = array();
		if(Auth::check() && Auth::user()->role_id == 2){
			$data['nav'] = 'menu_user_booking';
			$data['sub_nav'] = 'menu_user_booking_detail';
			$data['title'] = 'Upcoming Booking Detail';
			$data['meta_title']="Nytstay :: Upcoming Booking Detail";	
			$data['sub_title'] = '';
			$data['link'] = 'dashboard';	
			$cart = $mydata = array();
 			$cart = CartData::where('cart.user_id',Auth::user()->id)->where('cart.id',$cid)->where('cart.is_completed',1)
						->orderBy('cart.updated_at','desc')
						->first();
			if($cart && $cart->count() > 0){
				$cart_order_status= '';
				if($cart['order_status'] == '1'){
					$cart_order_status = '<span class="label label-danger">Payment Failed</span>';
				}elseif($cart['order_status'] == '2'){
					$cart_order_status = '<span class="label label-danger">Order Cancelled</span>';
				}elseif($cart['order_status'] == '3'){
					$cart_order_status = '<span class="label label-danger">Order Confirmed</span>';
				}elseif($cart['order_status'] == '0'){
					$cart_order_status = '<span class="label label-warning">Pending</span>';
				}
				$data['sub_title'] = ' '.$cart_order_status;				
				$cart_data = CartItems::where('cart_id',$cid)->orderBy('id','asc')->get();	
				if($cart_data && $cart_data->count() > 0){
					$i =  0;
					foreach($cart_data as $row){
						$mydata[$i]['id'] = $row['id'];
						$mydata[$i]['item_service_type'] = $row['item_service_type'];
						$mydata[$i]['total_price'] = $row['total_price'];
						$currency_detail = $hasc->get_currencyDetail($row['currency_code']);
						$currency_id = 2;
						if(Auth::check()){
							$currency_id = Auth::user()->currency_id;
						}
						$currency_detail = $hasc->get_currencyDetailById($currency_id); 	
						$mydata[$i]['currency_code'] = $currency_detail->symbol;
						
						if($row['item_service_type'] == '1'){
							$mydata[$i]['city_id'] = $row['city_id'];
							$mydata[$i]['city_name'] = $row['city_name'];
							$mydata[$i]['country_id'] = $row['country_id'];
							$mydata[$i]['country_name'] = $row['country_name'];
							$mydata[$i]['hotel_code'] = $row['hotel_code'];
							$mydata[$i]['hotel_search_code'] = $row['hotel_search_code'];
							$mydata[$i]['hotel_offer_code'] = $row['hotel_offer_code'];
							$mydata[$i]['hotel_offer_no'] = $row['hotel_offer_no'];
							$mydata[$i]['hotel_name'] = $row['hotel_name'];
							$mydata[$i]['item_name_heading'] = $row['hotel_name'].', '.$row['city_name'];
							$mydata[$i]['thumbnail'] = env('APP_URL')."assets/img/hotel-default.png";
							if($row['Thumbnail']!=''){
								$file_headers = get_headers($row['Thumbnail']);
								if($file_headers[0] == 'HTTP/1.1 200 OK'){
									$mydata[$i]['thumbnail'] = $row['Thumbnail'];
								} 	
							}							
							$mydata[$i]['quantity'] = $row['quantity'];
							$mydata[$i]['room_basis_code'] = $row['room_basis_code'];
							$room_basis_name = '';
							$room_basis_detail = RoomBasisCodes::where('code',trim($row['room_basis_code']))->first();
							if($room_basis_detail){
								$room_basis_name = $room_basis_detail->description;
							}						
							$mydata[$i]['room_basis_name'] = $room_basis_name;
							$mydata[$i]['offer_remark'] = $row['offer_remark'];
							$mydata[$i]['rooms'] = $row['rooms'];
							$mydata[$i]['adults'] = $row['adults'];
							$mydata[$i]['children'] = $row['children'];
							$mydata[$i]['details'] = $row['offer_remark'];							
						}else{
							$travel_booking_details = TravelBookingDetails::where('cart_items_id',$row['id'])->first();
							if($travel_booking_details && $travel_booking_details->count() > 0){
								$ditem = $travel_booking_details;							
								$mydata[$i]['thumbnail'] = env('APP_URL')."assets/img/travel-default.png";
								$mydata[$i]['item_name_heading'] = $ditem['pickup_place_name']."(".ucfirst($ditem['pickup_type']).") - ".$ditem['dropoff_place_name']."(".ucfirst($ditem['dropoff_type']).")";
								$mydata[$i]['passenger_count'] = $ditem['passenger_count'];
								$mydata[$i]['vehicle_text'] = $ditem['vehicle_text'];
								$mydata[$i]['vehicle_id'] = $ditem['vehicle_id'];
								$mydata[$i]['duration'] = $ditem['time_duration'];
								$mydata[$i]['details'] = $ditem['item_detail'];
							}
						}
						$mydata[$i]['book_date'] = $row['book_date'];
						$mydata[$i]['go_booking_code'] = $row['go_booking_code'];
						$mydata[$i]['go_reference'] = $row['go_reference'];
						$mydata[$i]['booking_status'] = $row['booking_status'];
						$mydata[$i]['is_booked'] = $row['is_booked'];
					$i++;
					}
				}								
			}

			return view('dashboard.booking_detail',['data'=>$data,'results'=>$mydata,'cart'=>$cart]);			
		}else{
			return redirect('home');
		}
    }
    public function ajax_list(Request $req,HotelApiServiceContract $hasc,$booking_status){
        $temppage       = $this->getDTpage($req);
        $length     = $temppage[0];
        $currpage   = $temppage[1]; 

        $order      = $this->getDTsort($req);
        $srch       = $this->getDTsearch($req);
        $qry = CartData::select(DB::raw("*,cart.id as cartId,cart.updated_at as updatedAt"))
						->where('cart.user_id',Auth::user()->id)
						->where('cart.is_completed',1);
		if($booking_status == 0){
			$qry->where('cart.booking_status',0);
		}elseif($booking_status == 1){
            $qry->where(function ($query) {
                $query->where('cart.booking_status',1)
                      ->orWhere('cart.booking_status',2);
            });
		
		}
			
        if(isset($srch['filter1']))
        {
            $qry->where('cart.payment_date','like',"%" .$srch['filter1']. "%");
        }
		
		
        
				if($order[0] == 'list_create'){
					$order[0] = 'cart.updated_at';
				}
				else if($order[0] == 'listId'){
					$order[0] = 'cart.id';
				}
				else if($order[0] == 'id'){
					$order[0] = 'cart.id';
				}					
			
				$qry->orderByRaw("$order[0] $order[1]");	
		$cart = array(); 
        $data['results'] = [];
        $results = $qry->paginate($length);
		$mydata = array();
        foreach($results as $rec){
			
            $data['results'][] = $rec;
        }
		$cart = $data['results'];
			if($cart){
					$i = 0;
				foreach($cart as $row){
					$cart_data = array();
					$mydata[$i]['cartId'] = $row['cartId'];
 					$mydata[$i]['total_cart_amount'] = $row['total_cart_amount'];
					$currency_detail = $hasc->get_currencyDetail($row['currency_code']);
					$currency_id = 2;
					if(Auth::check()){
						$currency_id = Auth::user()->currency_id;
					}
					$currency_detail = $hasc->get_currencyDetailById($currency_id); 	
					$mydata[$i]['currency_code'] = $currency_detail->symbol;					
					$mydata[$i]['transaction_id'] = $row['transaction_id'];
					$mydata[$i]['payment_date'] = date('m-d-Y',strtotime($row['payment_date']));
					$mydata[$i]['order_status'] = $row['order_status'];
					
					$cart_data  = CartItems::where('cart_id',$row['cartId'])->orderBy('cart_id','asc')
									->orderBy('id','asc')
									->get();
					$item_detail =  array();
					$item_names = '';
					if($cart_data && $cart_data->count() >0){
						foreach($cart_data as $item){
							if($item['item_service_type'] == '1'){
								$item_detail[] = '<strong>Hotel Offer</strong> : '.$item['hotel_name'].' <span class="font-12">('.$item['book_date'].')</span><br>';	
							}else{
								$travel_booking_details = TravelBookingDetails::where('cart_items_id',$item->id)->first();
								if($travel_booking_details && $travel_booking_details->count() > 0){
									$ditem = $travel_booking_details;
									$item_detail[] = '<strong>Travel Offer</strong> : '.$ditem["pickup_place_name"].'('.ucfirst($ditem["pickup_type"]).') - '.$ditem["dropoff_place_name"].'('.ucfirst($ditem["pickup_type"]).') <span class="font-12">('.$item["book_date"].')</span><br> ';
								}
							}
							
						}
					}
					if(count($item_detail)>0){
						$item_detail = array_unique($item_detail);
						$item_names = implode('<br>',$item_detail);
					}
					
					$mydata[$i]['item_names'] = $item_names; 
					$i++;
				}
			}
 
        $total = count($data['results']);
        return $this->responseDTJson($req->draw,$results->total(), $results->total(), $mydata);    
    }	
	
	
    public function booking_history(HotelApiServiceContract $hasc){
		if(Auth::check() && Auth::user()->role_id == 2){
			$data['nav'] = 'menu_user_booking';
			$data['sub_nav'] = 'menu_user_booking_history';
			$data['title'] = 'Booking History';
			$data['sub_title'] = '';
			$data['link'] = 'dashboard';
			$data['meta_title']="Nytstay :: Upcoming Booking History";	
			$data['booking_status'] = 1;//for complete or canceled both.			
			return view('dashboard.booking_history',['data'=>$data]);			
		}else{
			return redirect('home');
		}

    }	
	
	public function check_booking_status(Request $request,HotelApiServiceContract $hasc){
		$req = $request->all();
		$input2['booking_code'] = $req['booking_code'];
		$response = $hasc->booking_status($input2);  //Booking Status API
		
		if($response){
			//echo '<Pre>'; print_R($response); echo '</pre>';
			if($response['data']){
				$res_data = $response['data'];
				$input3 = array();
				if($res_data['booking_data']){
					$input3['booking_status']   = $res_data['booking_data']['Status'];
					//$input3['service_type']   = $res_data['booking_data']['Service'];
				}else{
					$input3['booking_status']   = '';
				}
				
				CartItems::where('id',$req['cart_item_id'])->update($input3);								
				
				return $input3['booking_status'];
			}
		}else{
			return 'error';
		}		
	}
	
	public function cancel_booking(Request $request,HotelApiServiceContract $hasc){
		$req = $request->all();
		$input2['GoBookingCode'] = $req['booking_code'];
		
		$response = $hasc->cancel_booking($input2);  //Booking Status API
		
		if($response){
			//echo '<Pre>'; print_R($response); echo '</pre>';
			if($response['data']){
				$res_data = $response['data'];
				$input3 = array();
				$input3['booking_status'] = $res_data['BookingStatus'];
				$input3['status'] = 0;
				CartItems::where('id',$req['cart_item_id'])->update($input3);
				return $input3['booking_status'];
			}
		}else{
			return 'error';
		}		
	}

	public function voucher_detail(Request $request,HotelApiServiceContract $hasc){
		//return view('dashboard.voucher_detail_info_dummy')->render();
	
		$req = $request->all();
		$input2['booking_code'] = $req['booking_code'];
		$response = $hasc->voucher_detail($input2);  //Booking Status API
		
		if($response){
			//echo '<Pre>'; print_R($response); echo '</pre>';
			if($response['data']){
				$res_data = $response['data'];				
				
				return view('dashboard.voucher_detail_info',['row'=>$res_data])->render(); 
			}
		}else{
			return 'error';
		}		
	}	
}
