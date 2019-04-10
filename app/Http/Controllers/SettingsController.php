<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use Illuminate\Support\Facades\Input;
use Hash;

class SettingsController extends Controller{
	//
	public function index(){
		//
	}
	
	public function addadminuser(){
		//
	}
	
	public function store(Request $request){
		//	
	}
	
	public function show($id){
		//
	}
	
	public function edit(Request $request, $id){}
	
	public function showsettings($id){
		//$settings = DB::select('select * from settings where id = ?', [$id]);
		$sql = 'select * from settings where id = '. $id;
		$arrData = json_decode(json_encode(DB::select($sql)), TRUE);
		
		return view('settings_update', ['arrData' => $arrData]);
	}
	
	public function editsettings(Request $request){
		
		$slugs = explode ("/", request()->fullUrl());
 		$id = $slugs [(count ($slugs) - 1)];
		
		$site_email = $request->input('site_email');
		$payment_email = $request->input('payment_email');
		$site_phone1 = $request->input('site_phone1');
		$site_phone2 = $request->input('site_phone2');
		$site_address1 = $request->input('site_address1');
		$site_address2 = $request->input('site_address2');
		$free_ship_limit = $request->input('free_ship_limit');
		$ups_accessnumber = $request->input('ups_accessnumber');
		$ups_username = $request->input('ups_username');
		$ups_password = $request->input('ups_password');
		$ups_shippernumber = $request->input('ups_shippernumber');
		$facebook = $request->input('facebook');
		$google = $request->input('google');
		$twitter = $request->input('twitter');
		$inn = $request->input('inn');
		$id = $request->input('id');
		
		/*validation */
		$validator = Validator::make([
		 
		 'site_email'  => $site_email,
		 'payment_email'  => $payment_email,
		 'site_phone1'   => $site_phone1,
		 'site_phone2'  => $site_phone2,
		 'site_address1'    => $site_address1,
		 'site_address2' => $site_address2,
		 'free_ship_limit'  => $free_ship_limit,
		 'ups_accessnumber'  => $ups_accessnumber,
		 'ups_username'  => $ups_username,
		 'ups_password'  => $ups_password,
		 'ups_shippernumber'  => $ups_shippernumber,
		 'facebook'  => $facebook,
		 'google'  => $google,
		 'twitter'  => $twitter,
		 'inn'  => $inn
		
		], [
		 
		 'site_email'  => 'required',
		 'payment_email'  => 'required',
		 'site_phone1'   => 'required',
		 'site_phone2'  => 'required',
		 'site_address1' => 'required',
		 'site_address2' => 'required',
		 'free_ship_limit' => 'required',
		 'ups_accessnumber' => 'required',
		 'ups_username' => 'required',
		 'ups_password' => 'required',
		 'ups_shippernumber' => 'required',
		 'facebook' => 'required',
		 'google' => 'required',
		 'twitter' => 'required',
		 'inn' => 'required'
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator) ->withInput();
		
		DB::update('update settings set site_email = ?, payment_email = ?, site_phone1 = ?, site_phone2 = ?, site_address1 = ?, site_address2 = ?, free_ship_limit = ?, ups_accessnumber = ?, ups_username = ?, ups_password = ?, ups_shippernumber = ?, facebook = ?, google = ?, twitter = ?, inn = ? where id = ?', [$site_email, $payment_email, $site_phone1, $site_phone2, $site_address1, $site_address2, $free_ship_limit, $ups_accessnumber, $ups_username, $ups_password, $ups_shippernumber, $facebook, $google, $twitter, $inn, $id]);
		return redirect()->to('settingsshow/'.$id);
	}
	
	public function destroy($id){
		//
	}
	
	public function filter(Request $request){
		//	
	}
	
}
