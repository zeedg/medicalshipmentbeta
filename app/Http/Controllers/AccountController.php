<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller{
	
	public function index(Request $request){
		
		if(session()->get('user_id')){

			return view('frontwebsite.account');
		
		} else {
			return redirect()->to('login_user');
		}
			
	}
	
	function billing(){
		
		if(session()->get('user_id')){

			return view('frontwebsite.billing');
		
		} else {
			return redirect()->to('login_user');
		}
		
	}
	
}
