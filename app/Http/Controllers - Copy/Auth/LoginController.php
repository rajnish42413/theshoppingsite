<?php

namespace App\Http\Controllers\Auth;
use Auth;
use DB;
use Session;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
	
    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => 1,'verified' => 1];
    }
	
	protected function authenticated(\Illuminate\Http\Request $request, $user)
    {  
        if($user->role_id == '1'){
			return redirect('/admin') ;
		}elseif($user->role_id == '2'){
			if(Session::get('guestUserId') && Session::get('guestUserId')!= 0){
				$user_id = 0;
				$guest_user_id = Session::get('guestUserId');
			}else{
				$user_id = 0;
				$guest_user_id = 0;
			}			
			return redirect('/home') ;
		}
            
    }
		
}
