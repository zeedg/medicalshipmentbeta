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
		  $arrValue['order_status']='';	
			
		  return view('frontwebsite.order',$arrValue);
	
	  } else {
		return redirect()->to('login_user');
	  }

   }
   

   public function detail(){

	  
	  $url = base64_encode('index.php?controller=order&function=detail');
	  $this->isLogin($url);		

	  # Build Query
	  $arrArgument['join']='INNER JOIN';
	  $arrArgument['where']=intval(trim($_GET['id']));
	  $arrValue['cart']=loadModel('medical','joinUserProductOrder',$arrArgument);
	  

	  # Get Order Detail
	  $arrArgument['table']='orders';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='order_id ASC';
	  $arrValue['order']=loadModel('medical','getRecord',$arrArgument);	  

	  # Get Order Billing Detail
	  $arrArgument['table']='order_billing_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='obd_id ASC';
	  $arrValue['billing']=loadModel('medical','getRecord',$arrArgument);	  

	  # Get Order Shipping Detail
	  $arrArgument['table']='order_shipping_detail';
	  $where=array('order_id'=>$arrValue['cart'][0]['order_id']);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='osd_id ASC';
	  $arrValue['shipping']=loadModel('medical','getRecord',$arrArgument);	  

	  loadView('header.php');
	  loadView('order-detail.php', $arrValue);
	  loadView('footer.php');	   

   }
   
   
   public function reorder()
   {
	   if(isset($_GET['id']))
	   {			
			$arrArgument['table']='order_detail';
			$where=array('order_id'=>$_GET['id']);
			$arrArgument['where']=$where;
			$arrArgument['operator']='';
			$arrArgument['order']='order_id ASC';
			$order = loadModel('medical','getRecord',$arrArgument);	
		  
			# Add to Cart
			foreach($order as $post)
			{
				$arrArgument['product_id']=intval($post['product_id']);
				$arrArgument['unit_id']=intval($post['unit_id']);
				$arrArgument['product_quantity']=intval(trim($post['product_quantity']));
				loadModel('medical','addCart',$arrArgument);
			}
			
			$url="'".SITE_PATH.'index.php?controller=cart&function=index&reorder='.$_GET['_GET']."'";
			echo "<script>window.location=$url</script>";
		}
   }
		
}
