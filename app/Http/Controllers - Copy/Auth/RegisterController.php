<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Mail;
use App\Mail\VerifyMail;
use App\VerifyUser;
use Session;
use Auth;
use Redirect;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' =>2,
            'image' =>'user.png',
        ]);

	$verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);
 
        Mail::to($user->email)->send(new VerifyMail($user));
	return $user;
    }
    
    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();		
        if(isset($verifyUser) ){
            $user = $verifyUser->user;
            if(!$user->verified) {
                $verifyUser->user->verified = 1;
		$verifyUser->user->active=1;
                $verifyUser->user->save();
                $status = "Your e-mail is successfully verified.";
            }else{
                $status = "Your e-mail is already verified.";
            }
        }else{
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
		Session::flash('message', $status); 
		Session::flash('alert-class', 'alert-success');
		Auth::login($user);
		return Redirect::to('home')->with('status', $status);
    }
	
/**
 * Show the application registration form.
 *
 * @return \Illuminate\Http\Response
 */
	public function showRegistrationForm()
	{
			
			$info = array();
			$info['meta_title']="Nytstay :: Registration";
			$info['meta_keywords']="Nytstay Registration";
			$info['meta_desicription']="Nytstay Registration";
			return view('auth.register',['info'=>$info]);
	}

	public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
		$request->session()->flash('message', 'Thank You for registration , please verify your e-mail');
		Session::flash('alert-class', 'alert-success');
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }
}
