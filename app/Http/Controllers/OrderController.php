<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller{
	
	public function index(){

	  if(session()->get('user_id')){

		  # Build Query
		  $param = '';
		  if(!isset($status)){
			  $status='(o.order_status=0 or o.order_status=1)';
		  } else {
			  $param=$status;
		  }
		  
		  if($param=='open'){
			  $status='o.order_status IN(0,2,3)';
		  }
	
		  if($param=='close'){
			  $status='o.order_status=1';
		  }
	
		  $arrArgument['join']='INNER JOIN';
		  $arrArgument['where']=$status.' AND u.user_id='.session()->get('user_id');
		  //$arrValue['orders']=loadModel('medical','joinUserOrder',$arrArgument);
		  $arrValue['orders']=Helper::instance()->joinUserOrder($arrArgument);
		  //$arrValue['order_status']=$this->order_status;
		  $arrValue['order_status']=1;	
			
		  return view('frontwebsite.order',$arrValue);
	
	  } else {
		return redirect()->to('login_user');
	  }

   }
   

   public function detail(){

	  
	  if(session()->get('user_id')){	
		
		$slugs = explode ("/", request()->fullUrl());
 		$id = $slugs [(count ($slugs) - 1)];
		
	  # Build Query
	  $arrArgument['join']='INNER JOIN';
	  $arrArgument['where']=$id;
	  $arrValue['cart']=Helper::instance()->joinUserProductOrder($arrArgument);
	  

	  # Get Order Detail
	  $arrArgument['table']='orders';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='order_id ASC';
	  $arrValue['order']=Helper::instance()->getRecord($arrArgument);	  

	  # Get Order Billing Detail
	  $arrArgument['table']='order_billing_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='obd_id ASC';
	  $arrValue['billing']=Helper::instance()->getRecord($arrArgument);	  

	  # Get Order Shipping Detail
	  $arrArgument['table']='order_shipping_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='osd_id ASC';
	  $arrValue['shipping']=Helper::instance()->getRecord($arrArgument);	  

	  	return view('frontwebsite.order-detail',$arrValue);
		   
	
		} else {
	  	return redirect()->to('login_user');
	  }
	
   }
   
   
   public function reorder(){
	   
	   $slugs = explode ("/", request()->fullUrl());
 	   echo $id = $slugs [(count ($slugs) - 1)];
	   
	   if(isset($id)){
		   			
			$arrArgument['table']='order_detail';
			$where=array('order_id'=>$id);
			$arrArgument['where']=$where;
			$arrArgument['operator']='';
			$arrArgument['order']='order_id ASC';
			$order = Helper::instance()->getRecord($arrArgument);	
		  
			# Add to Cart
			foreach($order as $post)
			{
				$arrArgument['product_id']=$post['product_id'];
				$arrArgument['unit_id']=$post['unit_id'];
				$arrArgument['product_quantity']=$post['product_quantity'];
				Helper::instance()->addCart($arrArgument);
			}
			
			return redirect()->to('cart/index/reorder');
			?>
			<?php /*?>$url="'".SITE_PATH.'index.php?controller=cart&function=index&reorder='.$_GET['_GET']."'";
			echo "<script>window.location=$url</script>";<?php */?>
			<?php
        }
   }
		
}
