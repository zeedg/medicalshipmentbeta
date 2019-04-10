<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class BillshipController extends Controller{
	
	public function index(Request $request){
		//index code	
	}
	
	public function add(Request $request){
	   
	    $slugs = explode ("/", request()->fullUrl());
 		$type = $slugs [(count ($slugs) - 1)];
	   
		$msg = '';
		$arrValue = array();
		
		if($request->input('add') != NULL){
			
			$_POST = $request;
				
			$default=0;
			if(isset($_POST['default'])){
				$default=1;
			}
			
			# Insert Billing Shipping Location
			$type=$_POST['type'];
			$fname=$_POST['fname'];
			$lname=$_POST['lname'];
			$phone=$_POST['phone'];
			
			$address=$_POST['address'];
			$city=$_POST['city'];
			$exp=explode('_',trim($_POST['state']));
			$state=$exp[0];
			
			$address_type=$_POST['address_type'];
			
			$ship_dir=$_POST['ship_dir'];
			$country=$exp[1];
			$zip=$_POST['zip'];
			$date=date('Y-m-d H:i:s');
			$post=array(
			
				'user_id'			=>session()->get('user_id'),
				'bsa_fname'			=>$fname,
				'bsa_lname'			=>$lname,
				'bsa_phone'			=>$phone,
				'bsa_address'		=>$address,
				'bsa_zip'			=>$zip,
				'bsa_city'			=>$city,
				'bsa_state'			=>$state,
				'bsa_country'		=>$country,
				'bsa_type'			=>$type,
				
				'bsa_address_type'	=>$address_type,
				
				'bsa_ship_dir'		=>$ship_dir,
				'bsa_default'		=>$default,
				'bsa_date'			=>$date
			
			);
			
			$arrArgument['table']='bill_ship_address';
			$arrArgument['post']=$post;
			$last_id=Helper::instance()->insertRecord($arrArgument);
			
			if($default==1){
				$this->removeDefault($last_id,$type);
			}
			# When add ship address from payment page
			if(isset($_POST['redirect'])){
				$url="'".SITE_PATH.'index.php?controller=cart&function=payment&ship_id='.$last_id."'";
				echo "<script>window.location=$url</script>";
			} else {
				return redirect()->to('profile/index');
			}
			
			exit;
			
		}
		
		$arrValue['error']=$msg;
		$arrValue['type']=$type;
		
	   return view('frontwebsite.bill-ship-add',$arrValue);
	   
  }
  
  public function edit(Request $request){
	   
		if($request->input('edit') != NULL){
			
			$_POST = $request;
			
			$bsa=intval($_POST['id']);
			$default=0;
			if(isset($_POST['default'])){
				$default=1;
			}
			
			# Update Address
			$type=$_POST['type'];
			$fname=$_POST['fname'];
			$lname=$_POST['lname'];
			$phone=$_POST['phone'];
			
			$address=$_POST['address'];
			$city=$_POST['city'];
			$exp=explode('_',trim($_POST['state']));
			$state=$exp[0];
			
			$address_type=$_POST['address_type'];
			
			$ship_dir=$_POST['ship_dir'];
			$country=$exp[1];
			$zip=$_POST['zip'];
			$post=array(
						
				'user_id'			=>session()->get('user_id'),
				'bsa_fname'			=>$fname,
				'bsa_lname'			=>$lname,
				'bsa_phone'			=>$phone,
				'bsa_address'		=>$address,
				'bsa_zip'			=>$zip,
				'bsa_city'			=>$city,
				'bsa_state'			=>$state,
				'bsa_country'		=>$country,
				'bsa_type'			=>$type,
				
				'bsa_address_type'	=>$address_type,
				
				'bsa_ship_dir'		=>$ship_dir,
				'bsa_default'		=>$default
			);
			
			$arrArgument['table']='bill_ship_address';
			$arrArgument['post']=$post;
			$where=array('user_id'=>session()->get('user_id'), 'bsa_id'=>$bsa);
			$arrArgument['where']=$where;
			$arrArgument['operator']='AND';
			Helper::instance()->updateRecord($arrArgument);
			
			if($default==1){
				$this->removeDefault($bsa,$type);
			}
			
			# When add ship address from payment page
			if(isset($_POST['redirect'])){
				
				$url="'".SITE_PATH.'index.php?controller=cart&function=payment'."'";
				echo "<script>window.location=$url</script>";
			}
			else{
				
				return redirect()->to('profile/index');
			}
			
			exit;
			
		}
	   
		# Update Addresses
		$slugs = explode ("/", request()->fullUrl());
 		$bsa = $slugs [(count ($slugs) - 1)];
		
		# Get Shipping Detail
		$arrArgument['table']='bill_ship_address';
		$where=array('user_id'=>session()->get('user_id'),'bsa_id'=>$bsa);
		$arrArgument['where']=$where;
		$arrArgument['operator']='AND';
		$arrArgument['order']='bsa_id ASC';
		$arrValue['bsa']=Helper::instance()->getRecord($arrArgument);
		
		$msg='';
		$arrValue['error']=$msg;
		
	   
	   # When add ship address from payment page
		if($request->input('redirect') != NULL){
			return redirect()->to('/checkoutpage');
		}
		else{
			
			return view('frontwebsite.bill-ship-edit',$arrValue);
		}
		
		exit;
	   
  }
  
  function removeDefault($last_id,$type){
	 
		$post=array(
			'bsa_default'=>0
		);
		
		$arrArgument['table']='bill_ship_address';
		$arrArgument['post']=$post;
		$where=array('user_id'=>session()->get('user_id'), 'bsa_type'=>$type, 'bsa_id!'=>$last_id);
		$arrArgument['where']=$where;
		$arrArgument['operator']='AND';
		Helper::instance()->updateRecord($arrArgument);
	  
	  
  }

  public function remove(){
	  
	  	$slugs = explode ("/", request()->fullUrl());
 		$id = $slugs [(count ($slugs) - 1)];
	  
		if(isset($id)){
			$bsa=$id;
			$arrArgument['table']='bill_ship_address';
			$arrArgument['where']='bsa_id='.$bsa.' AND user_id='.session()->get('user_id');
			$arrArgument['path']='';
			$imageColumn=array();
			$arrArgument['imageColumn']=$imageColumn;
			Helper::instance()->removeRecord($arrArgument);
		}
		
		# When add ship address from payment page
		if(isset($redirect)){
		
			$url="'".SITE_PATH.'index.php?controller=cart&function=payment'."'";
			echo "<script>window.location=$url</script>";
		}
		else{
		
			return redirect()->to('profile/index');
		}
	  
  }
	
}
