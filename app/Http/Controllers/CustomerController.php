<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\customer;
use Illuminate\Support\Facades\Input;
use Hash;

class CustomerController extends Controller{
	//
	public function index(){
		//$users = DB::select('select * from customer');
		$users = customer::paginate(50);
		return view('customer', ['users' => $users]);
	}
	
	public function addcustomer(){
		return view('addcustomer');
	}
	
	public function store(Request $request){
		//print_r($request->input());
		//$result = DB::insert("insert into test(name,email) values(? ,?)",[$request->input('name'),$request->input('email')]);
		$validator = Validator::make([
		 
		 'cg_id'         => $request->input('tax_class'),
		 'user_company'  => $request->input('company_name'),
		 'user_fname'    => $request->input('contact_first_name'),
		 'user_lname'    => $request->input('contact_last_name'),
		 'user_pcompany' => $request->input('position_at_company'),
		 'user_phone'    => $request->input('phone_number'),
		 'user_email'    => $request->input('email'),
		 'user_fax'      => $request->input('fax_number'),
		 'user_facility' => $request->input('facility_type'),
		 'user_gpo'      => $request->input('gpo'),
		 'user_password' => $request->input('password'),
		 'user_status'   => $request->input('status'),
		
		], [
		 
		 'cg_id'         => 'required|max:100',
		 'user_company'  => 'required|max:100',
		 'user_fname'    => 'max:100',
		 'user_lname'    => 'max:100',
		 'user_pcompany' => 'required|max:100',
		 'user_phone'    => 'max:100',
		 'user_email'    => 'required|max:100',
		 'user_fax'      => 'max:100',
		 'user_facility' => 'required|max:100',
		 'user_gpo'      => 'required|max:100',
		 'user_password' => 'required|max:100',
		 'user_status'   => 'required|max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$result = DB::insert("insert into customer(cg_id,user_company,user_fname,user_lname,user_pcompany,user_phone,user_email,user_fax,user_facility,user_gpo,user_password,user_status,reference,user_created) values(? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,? ,?)", [$request->input('tax_class'),
		 $request->input('company_name'),
		 $request->input('contact_first_name'),
		 $request->input('contact_last_name'),
		 $request->input('position_at_company'),
		 $request->input('phone_number'),
		 $request->input('email'),
		 $request->input('fax_number'),
		 $request->input('facility_type'),
		 $request->input('gpo'),
		 $request->input('password'),
		 $request->input('status'),
		 '',
		 '2018-01-11 21:46:01']);
		
		return redirect()->to('view-customers');
	}
	
	public function show($id){
		$users = DB::select('select * from customer where user_id = ?', [$id]);
		return view('customer_update', ['users' => $users]);
	}
	
	public function edit(Request $request, $id){
		$tax_class = $request->input('tax_class');
		$company_name = $request->input('company_name');
		$contact_first_name = $request->input('contact_first_name');
		$contact_last_name = $request->input('contact_last_name');
		$position_at_company = $request->input('position_at_company');
		$phone_number = $request->input('phone_number');
		$email = $request->input('email');
		$fax_number = $request->input('fax_number');
		$facility_type = $request->input('facility_type');
		$gpo = $request->input('gpo');
		$password = $request->input('password');
		$status = $request->input('status');
		$validator = Validator::make([
		 
		 'cg_id'         => $tax_class,
		 'user_company'  => $company_name,
		 'user_fname'    => $contact_first_name,
		 'user_lname'    => $contact_last_name,
		 'user_pcompany' => $position_at_company,
		 'user_phone'    => $phone_number,
		 'user_email'    => $email,
		 'user_fax'      => $fax_number,
		 'user_facility' => $facility_type,
		 'user_gpo'      => $gpo,
		 'user_password' => $password,
		 'user_status'   => $status,
		
		], [
		 
		 'cg_id'         => 'required|max:100',
		 'user_company'  => 'required|max:100',
		 'user_fname'    => 'max:100',
		 'user_lname'    => 'max:100',
		 'user_pcompany' => 'required|max:100',
		 'user_phone'    => 'max:100',
		 'user_email'    => 'required|max:100',
		 'user_fax'      => 'max:100',
		 'user_facility' => 'required|max:100',
		 'user_gpo'      => 'required|max:100',
		 'user_password' => 'max:100',
		 'user_status'   => 'required|max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		DB::update('update customer set cg_id = ?, user_company = ?, user_fname = ?, user_lname = ?, user_pcompany = ?, user_phone = ?, user_email = ?, user_fax = ?, user_facility = ?, user_gpo = ?, user_password = ?, user_status = ?, reference = ?, user_created = ? where user_id = ?', [$tax_class, $company_name, $contact_first_name, $contact_last_name, $position_at_company, $phone_number, $email, $fax_number, $facility_type, $gpo, $password, $status, '', '2018-01-11 21:46:01', $id]);
		return redirect()->to('view-customers');
	}
	
	public function destroy($id){
		DB::table('customer')->where('user_id', '=', $id)->delete();
		return redirect()->to('view-customers');
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				$users = customer::paginate("$selected_option");
				return view('customer', ['users' => $users]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$pg = (isset($op_select)) ? $op_select : '15';
				
				$users = DB::table('user')->where('user_fname', 'like', '%'.$keyword.'%')->orWhere('user_lname', 'like', '%'.$keyword.'%')->orWhere('user_email', 'like', '%'.$keyword.'%')->orWhere('user_phone', 'like', '%'.$keyword.'%')->select('user.*')->orderBy('user_id', 'asc')->paginate("$pg");
				return view('customer', ['users' => $users]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$users = DB::table('user')->select('user.*')->orderBy('user_id', 'asc')->paginate("$pg");
				return view('customer', ['users' => $users]);
			}else if(isset($keyword) && !isset($pg)){
				$users = DB::table('user')->where('user_fname', 'like', '%'.$keyword.'%')->orWhere('user_lname', 'like', '%'.$keyword.'%')->orWhere('user_email', 'like', '%'.$keyword.'%')->orWhere('user_phone', 'like', '%'.$keyword.'%')->select('user.*')->orderBy('user_id', 'asc')->paginate(15);
				return view('customer', ['users' => $users]);
			}else if(isset($pg) && isset($keyword)){
				
				
				$users = DB::table('user')->where('user_fname', 'like', '%'.$keyword.'%')->orWhere('user_lname', 'like', '%'.$keyword.'%')->orWhere('user_email', 'like', '%'.$keyword.'%')->orWhere('user_phone', 'like', '%'.$keyword.'%')->select('user.*')->orderBy('user_id', 'asc')->paginate("$pg");
				return view('customer', ['users' => $users]);
			}else{ 
				$users = DB::table('user')->where('user_fname', 'like', '%'.$keyword.'%')->orWhere('user_lname', 'like', '%'.$keyword.'%')->orWhere('user_email', 'like', '%'.$keyword.'%')->orWhere('user_phone', 'like', '%'.$keyword.'%')->select('user.*')->orderBy('user_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10 );
				return view('customer', ['users' => $users]);
			}
		}
		// exit();
	}
	
}
