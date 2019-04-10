<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller{
	
	public function index(Request $request){
		
	  if(session()->get('user_id')){

	  $msg=-1;

	  if($request->input('update') != NULL){
		  
		  $_POST=$request; 
		  
		  # Check Email already exist or not
		  $arrArgument['table']='customer';
		  $where=array('user_email'=>$request->input('email'), 'user_id!'=>session()->get('user_id'));
		  $arrArgument['where']=$where;
		  $arrArgument['operator']='AND';
		  $arrArgument['order']='user_id ASC';
		  $arrValue=Helper::instance()->getRecord($arrArgument);

		  if(!empty($arrValue)){
			  $msg=0;
		  } else {
			  $company=$request->input('company');
			  $fname=$request->input('fname');
			  $lname=$request->input('lname');
			  $pcompany=$request->input('pcompany');
			  $phone=$request->input('phone');
			  $email=$request->input('email');
			  $fax=$request->input('fax');
			  $ftype=$request->input('ftype');
			  $gpo=$request->input('gpo');
			  $password=$request->input('password');
			  
			  $post=array(
					'user_fname'		=>$fname,
					'user_lname'		=>$lname,
					'user_phone'		=>$phone,
					'user_email'		=>$email,
					'user_fax'			=>$fax,
					'user_facility'		=>$ftype,
					'user_password'		=>$password,
					'user_company'		=>$company,
					'user_pcompany'		=>$pcompany,
					'user_gpo'			=>$gpo
			  );

			  $arrArgument['table']='customer';
			  $arrArgument['post']=$post;
			  $where=array('user_id'=>session()->get('user_id'));
			  $arrArgument['where']=$where;
			  $arrArgument['operator']='';
			  $response=Helper::instance()->updateRecord($arrArgument);

			  if($response){
				  $msg=1;
			  } else {
				  $msg=2;
			  }

		  }

	  }
		
		# Get User Detail or Profile Info
		$arrArgument['table']='customer';
		$where=array('user_id'=>session()->get('user_id'));
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='user_id ASC';
		$arrValue['detail']=Helper::instance()->getRecord($arrArgument);

		# Bill
		$arrArgument['table']='bill_ship_address';
		$where=array('user_id'=>session()->get('user_id'), 'bsa_type'=>'billing');
		$arrArgument['where']=$where;
		$arrArgument['operator']='AND';
		$arrArgument['order']='bsa_id ASC';
		$arrValue['bsa_b']=Helper::instance()->getRecord($arrArgument);

		# Bill
		$arrArgument['table']='bill_ship_address';
		$where=array('user_id'=>session()->get('user_id'), 'bsa_type'=>'shipping');
		$arrArgument['where']=$where;
		$arrArgument['operator']='AND';
		$arrArgument['order']='bsa_id ASC';
		$arrValue['bsa_s']=Helper::instance()->getRecord($arrArgument);	  

		$arrValue['msg']=$msg;

		return view('frontwebsite.profile',$arrValue);
	
	  } else {
	  	return redirect()->to('login_user');
	  }
	
	}
	
}
