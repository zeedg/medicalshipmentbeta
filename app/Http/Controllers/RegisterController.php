<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller{
	
	public function index(Request $request){
		$msg='';
	  	$success = '';	
		
		if($request->input('register') != NULL){
		  	
		  # Check Email already exist or not
		  $arrArgument['table']='customer';
		  $where=array('user_email'=>$_POST['email']);
		  $arrArgument['where']=$where;
		  $arrArgument['operator']='';
		  $arrArgument['order']='user_id ASC';
		  $arrValue=json_decode( json_encode(Helper::instance()->getRecord($arrArgument)) , true);		
		  	
		  if(!empty($arrValue)){
		  	  $msg='Email already exist';
		  } else {
			  $fname=$request->input('fname');
			  $lname=$request->input('lname');
			  $email=$request->input('email');
			  $password=$request->input('password');
			  $reference=$request->input('reference');
			  $status=0;
			  $date=date('Y-m-d H:i:s');
			  
			  $post=array(			  
					'user_fname'		=>	$fname,
					'user_lname'		=>	$lname,
					'user_email'		=>	$email,
					'user_password'	 =>	$password,
					'reference'		 =>	$reference,
					'user_status'	   =>	$status,
					'user_created'	  =>	$date
			  );
			  
			  $arrArgument['table']='customer';
			  $arrArgument['post']=$post;
			  $user_id=Helper::instance()->insertRecord($arrArgument);
			  	
			  $arrValue['success'] = 'Account created successfully! Please check your email to activate your account';
			  
			  # Sent Email to Admin and Customer 
			  $link=$this->encryptURL($email);
			  $this->sendEmail($post, $link);
			  
			  return redirect()->to('register/success');
			  
		  }
	  
		}
		
		# Get All Facilities
		$arrArgument['table']='facility';
		$where=array('facility_status'=>1);
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='facility_title ASC';
		$arrValue['fac']=json_decode( json_encode(Helper::instance()->getRecord($arrArgument)) , true);

		$arrValue['error']=$msg;
		$arrValue['success']= $success;

		return view('frontwebsite.register',$arrValue);
		
	}
	
	public function success(){
		return view('frontwebsite.register-success');
	}
	
	function encryptURL($email){

		$keySalt="aghtUJ6y";
		$qryStr=$email;

		$query=base64_encode(urlencode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($keySalt), $qryStr, MCRYPT_MODE_CBC, md5(md5($keySalt)))));
		//$link="index.php?controller=register&function=decryptURL&auth=".$query;
		$link=$this->decryptURL($query); 
		return $link;

    }
	
	function decryptURL($auth = ''){

	    if(!isset($auth)){
			$this->index();
		}

		$keySalt="aghtUJ6y";
		$queryString=rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($keySalt), urldecode(base64_decode($auth)), MCRYPT_MODE_CBC, md5(md5($keySalt))), "\0");
		
		# Check Email already exist or not
		$arrArgument['table']='customer';
		$where=array('user_email'=>$queryString);
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='user_id ASC';
		$arrValue=Helper::instance()->getRecord($arrArgument);

		if(!empty($arrValue)){
			if($arrValue[0]['user_status']==1){
				return redirect()->to('profile/index');
			} else {
				$post=array(
					'user_status'=>1
				);
				$arrArgument['table']='customer';
				$arrArgument['post']=$post;
				$where=array('user_email'=>$queryString);
				$arrArgument['where']=$where;
				$arrArgument['operator']='';
				Helper::instance()->updateRecord($arrArgument);				

				/*$_SESSION['front_email'] = $arrValue[0]['user_email'];
				$_SESSION['front_id']	= $arrValue[0]['user_id'];
				$_SESSION['front_name']  = $arrValue[0]['user_fname'];
				$_SESSION['company']	 = $arrValue[0]['user_company'];				
				$_SESSION['reference']   = $arrValue[0]['reference'];*/
				
				session()->put('user_email', $arrValue[0]['user_email']);
				session()->put('user_id', $arrValue[0]['user_id']);
				session()->put('user_fname', $arrValue[0]['user_fname']);
				session()->put('user_company', $arrValue[0]['user_company']);
				session()->put('reference', $arrValue[0]['reference']);
				
				/*$action = action('ProfileController@index');
				echo "<script>window.location='".$action."'</script>";*/
				
				
			}
		} else {
			exit("Something went wrong in account activation process, Do contact with admin");
		}

  }
	
	function sendEmail($array,$link){

	    # Email to Admin	   
	    $to="sales@medicalshipment.com";
		$subject="Medicalshipment - New Signup";		

		$message="<b>Form Details</b>"."<br /><br />";
		$message.="<b>Contact Name: </b> ".$array['user_fname']." ".$array['user_lname']."<br />";
		$message.="<b>Email: </b> ".$array['user_email']."<br />";
		$message.="<b>Password: </b> ".$array['user_password']."<br />";
		$message.="<b>Date Time: </b> ".$array['user_created'];

		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers.='From: <sales@medicalshipment.com>' . "\r\n";

		$exp=explode(',',$to);
		foreach($exp as $to){
			@mail($to,$subject,$message,$headers);
		}

		# Email to Customer
		$encrypt="'".$link."'";		
		$to=$array['user_email'];
		$subject="Medicalshipment - Thanks for your signup to our site";	
		$message="Thanks for your signup to our site medicalshipment.<br /><br />";		
		$message.="<b>Click below link to activate your account!</b>"."<br /><br />";		
		$message.="<b>Activation URL: </b> "."<a href=".$encrypt.">Click Here</a><br />";		
		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers.='From: <sales@medicalshipment.com>' . "\r\n";

		$exp=explode(',',$to);

		foreach($exp as $to){
			@mail($to,$subject,$message,$headers);
		}

		
   }
	
}
