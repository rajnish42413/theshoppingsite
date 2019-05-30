<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
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
    public function index()
    {
		
		$data['nav'] = 'menu_dashboard';
		$data['sub_nav'] = '';
		$data['title'] = 'Dashboard';
		$data['sub_title'] = '';
		$data['link'] = 'admin';			
        return view('admin.dashboard',['data'=>$data]);
    }
	
	
	
}
