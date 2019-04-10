<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	 
	public function index(Request $request){
		
		if(session()->get('user_id')){
			
			if($request->input('product_id') != NULL && $request->input('cquantity') != NULL){
				
				$qty_cart = $request->input('qty_cart');
				$product_id = $request->input('product_id');
				$cquantity = $request->input('cquantity');
				$unit_id = $request->input('unit_id');
				
				$cart_id = $qty_cart;
				$pid = $product_id;
				$uid = $unit_id;
				$q = $cquantity;
				$bundle = 0;
				$configure = 0;
				
				/////////// SHOPPING CART START //////////
				session()->push('cart', ['product_id'       => $pid,
				                         'unit_id'          => $uid,
				                         'product_quantity' => $q,
				                         'product_bundle'   => $bundle]);
				
				$cookie_id = session()->get('user_fname').session()->get('user_id');
				$cart_id = 'aband_cart_'.session()->get('user_id');
				session()->put('cookie_cart_id', $cart_id);
				$userId = session()->get('user_id');
				$useremail = session()->get('user_email');
				$datetime = date('Y-m-d H:i:s');
				
				$result = DB::insert("insert into cookie_cart(cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values(? ,? ,? ,? ,? ,? ,?)", [$cart_id, $cookie_id, $useremail, $pid, $uid, $q, $bundle]);
				/////////// SHOPPING CART END ///////////
				
				$user_id = session()->get('user_id');
				$ip_addr = $_SERVER[ 'REMOTE_ADDR' ];
				$date = date('Y-m-d H:i:s');
				
				$result = DB::insert("insert into visitor_cart_stats(user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Cart', 'Add', $date]);
			} //CHECK PRODUCT ID AND CQUANTITY SET
			
			//GET ADMIN
			$arrValue[ 'setting' ] = DB::select("SELECT * FROM `admins` WHERE 1 ORDER BY id ASC");
			
			//GET CUSTOMER /OLD USER TBL
			$arrValue[ 'customer' ] = DB::select("SELECT * FROM `customer` WHERE user_id = '".intval(session()->get('user_id'))."' ORDER BY user_id ASC");
			
			//GET SHIPPING
			$arrValue[ 'ship' ] = DB::select("SELECT * FROM `shipping` WHERE 1 ORDER BY ship_id ASC");
			
			return view('frontwebsite.cart');
		}
	} 
	 
	public function index2(Request $request){
		
		if(session()->get('user_id')){
			
			if($request->input('product_id') != NULL && $request->input('cquantity') != NULL){
				
				$qty_cart = $request->input('qty_cart');
				$product_id = $request->input('product_id');
				$cquantity = $request->input('cquantity');
				$unit_id = $request->input('unit_id');
				
				$cart_id = $qty_cart;
				$pid = $product_id;
				$uid = $unit_id;
				$q = $cquantity;
				$bundle = 0;
				$configure = 0;
				
				/////////// SHOPPING CART START //////////
				session()->push('cart', [
					'product_id' => $pid,
					'unit_id' => $uid,
					'product_quantity' => $q,
					'product_bundle' => $bundle
				]);
				
				$cookie_id = session()->get('user_fname').session()->get('user_id');
				$cart_id = 'aband_cart_'.session()->get('user_id');
				session()->put('cookie_cart_id', $cart_id);
				$userId = session()->get('user_id');
				$useremail = session()->get('user_email');
				$datetime = date('Y-m-d H:i:s');
				
				$result = DB::insert("insert into cookie_cart(cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values(? ,? ,? ,? ,? ,? ,?)", [$cart_id, $cookie_id, $useremail, $pid, $uid, $q, $bundle]);
				/////////// SHOPPING CART END ///////////
				
				$user_id = session()->get('user_id');
				$ip_addr = $_SERVER['REMOTE_ADDR'];
				$date = date('Y-m-d H:i:s');
				
				$result = DB::insert("insert into visitor_cart_stats(user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Cart', 'Add', $date]);
								
			} //CHECK PRODUCT ID AND CQUANTITY SET
			
			# When Move to Cart come from Quotes
			if($request->input('move_cart') != NULL){
				
				$quotes = Session::get('quote');
				if(isset($quotes) && !empty($quotes)){
					foreach($quotes as $key=>$value) {
						
						if($request->input('quote1Product'.$value['product_id'])){
							$mfa = @reset(json_decode( json_encode(DB::select("select p.product_id,p.product_title,p.product_item_no,pi.*,u.*, up.* from product p inner join unit_product up on p.product_id=up.product_id inner join unit u on u.unit_id=up.unit_id inner join product_image pi on p.product_id=pi.product_id where p.product_id='".$value['product_id']."' and up.unit_id='".$value['unit_id']."' group by p.product_id")) , true));
							
							$post = $mfa;
							$product_id=$post['product_id'];
							$unit_id=$post['unit_id'];
							$product_quantity=$value['product_quantity'];
							# Add to Cart
							$arrArgument['product_id']=$product_id;
							$arrArgument['unit_id']=$unit_id;
							$arrArgument['product_quantity']=$product_quantity;
							
							self::addCart($arrArgument);
							
							unset($quotes[$key]);
							$newQuotes = array_values($quotes);
							Session::put('quote', $newQuotes);
							break;
							
						}
					}

				}
				
			}
			
			//GET ADMIN
			$arrValue['setting'] = DB::select("SELECT * FROM `admins` WHERE 1 ORDER BY id ASC");
			
			//GET CUSTOMER /OLD USER TBL
			$arrValue['customer'] = DB::select("SELECT * FROM `customer` WHERE user_id = '".intval(session()->get('user_id'))."' ORDER BY user_id ASC");
			
			//GET SHIPPING
			$arrValue['ship'] = DB::select("SELECT * FROM `shipping` WHERE 1 ORDER BY ship_id ASC");
			
			return view('frontwebsite.cart2');
				
		} //CHECK USER LOGIN CONDITION
		else {
			
			if($request->input('product_id') != NULL) {
				//$url="'".SITE_PATH.'index.php?controller=login&function=index&pid='.$_POST['product_id']."'";
				return redirect()->to('login_user/'.$request->input('product_id'));
			} else {
				$product_id = 'abandCart';
				//$url="'".SITE_PATH.'index.php?controller=login&function=index&pid='.$_POST['product_id']."'";
				return redirect()->to('login_user/'.$product_id);
			}
			//return redirect()->to('login_user');
		}
		
	}
	
	public function ajax(Request $request){
		
		if(session()->get('user_id')){
			
			if($request->input('product_id') != NULL && $request->input('cquantity') != NULL){
				
				/*if(isset($_SESSION['fromFav'])){
					unset($_SESSION['fromFav']);
				}*/
				# Add to Cart
				$arrArgument['product_id']=intval($request->input('product_id'));
				$arrArgument['unit_id']=intval($request->input('unit_id'));
				$arrArgument['product_quantity']=intval(trim($request->input('cquantity')));
				
				/////////// SHOPPING CART START //////////
				
				/////////// SHOPPING CART END //////////
				
				self::addCart($arrArgument);
			
			}
			
			//GET ADMIN
			$arrValue['setting'] = DB::select("SELECT * FROM `admins` WHERE 1 ORDER BY id ASC");
			
			//GET CUSTOMER /OLD USER TBL
			$arrValue['customer'] = DB::select("SELECT * FROM `customer` WHERE user_id = '".intval(session()->get('user_id'))."' ORDER BY user_id ASC");
			
			//GET BILL SHIP ADDRESS
			//$arrValue['bsl'] = DB::select("SELECT * FROM `bill_ship_location` WHERE user_id = '".intval(session()->get('user_id'))."' ORDER BY bsl_id ASC");
			
			//GET SHIPPING
			$arrValue['ship'] = DB::select("SELECT * FROM `shipping` WHERE 1 ORDER BY ship_id ASC");
			
			//return view('frontwebsite.cart');
			echo "yes";
			
		}
		else{
			
			echo "login";
		}
	
   }
	
	public function addCart($arrArgument){
	    
		$pid=$arrArgument['product_id'];
		$uid=$arrArgument['unit_id'];
		$q=$arrArgument['product_quantity'];
		
		$bundle=0;
		$configure = 0;
		
		session()->push('cart', [
				'product_id' => $pid,
				'unit_id' => $uid,
				'product_quantity' => $q,
				'product_bundle' => $bundle
			]);
		
		$cookie_id = session()->get('user_fname').session()->get('user_id');
		$cart_id = 'aband_cart_'.session()->get('user_id');
		session()->put('cookie_cart_id', $cart_id);
		$userId = session()->get('user_id');
		$useremail = session()->get('user_email');
		$datetime = date('Y-m-d H:i:s');
		
		$result = DB::insert("insert into cookie_cart(cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values(? ,? ,? ,? ,? ,? ,?)", [$cart_id, $cookie_id, $useremail, $pid, $uid, $q, $bundle]);
		
		$user_id = session()->get('user_id');
		$ip_addr = $_SERVER['REMOTE_ADDR'];
		$date = date('Y-m-d H:i:s');
		
		$result = DB::insert("insert into visitor_cart_stats(user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Cart', 'Add', $date]);
		
	}
	
	public function product_remove($product_id,$unit_id){
		$url = '';
		//$this->isLogin($url);
	    
		if(isset($product_id)){
			
			$arrArgument['product_id']=intval($product_id);
			$arrArgument['unit_id']=intval($unit_id);
			$this->removeProduct($arrArgument);
			
			$pid=intval($product_id);
			//$sql_1="delete from cookie_cart where product_id=$pid && cart_id='".$_SESSION['cookie_cart_id']."'";
		        //mysql_query($sql_1);
			//DB::table('cookie_cart')->where('product_id', '=', $pid)->where('cart_id', '=', $_SESSION['cookie_cart_id'])->delete();
			DB::table('cookie_cart')->where('product_id', '=', $pid)->where('cart_id', '=', session()->get('cookie_cart_id'))->delete();
			
			return redirect()->to('addto_cart');
		
		}
	}
	
	public function removeProduct($arrArgument){
		
		$pid=intval($arrArgument['product_id']);
		$uid=intval($arrArgument['unit_id']);
		
		$carts = Session::get('cart');
        
		foreach($carts as $i => $cart) {		
			if($pid==$cart['product_id'] && $uid==$cart['unit_id']){
				//unset($_SESSION['cart'][$i]);
				unset($carts[$i]);
		
				$newCarts = array_values($carts);
                Session::put('cart', $newCarts);
		
				$user_id = session()->get('user_id');
				$cookie_id=session()->get('user_fname').session()->get('user_id');
				$ip_addr = $_SERVER['REMOTE_ADDR'];
				$date = date('Y-m-d H:i:s');
				DB::table('cookie_cart')->where('cookie_id', '=', $cookie_id)->where('product_id', '=', $pid)->delete();
				$result = DB::insert("insert into visitor_cart_stats(user_id, ip_address, product_id, type, action, date) values(? ,? ,? ,? ,? ,?)", [$user_id, $ip_addr, $pid, 'Cart', 'Remove', $date]);
				break;
			}
		}
		//$_SESSION['cart']=array_values($_SESSION['cart']);
	}
	
	public function product_removeAll(){
		
		session()->pull('cart');
		//DB::table('cookie_cart')->where('cart_id', '=', $_SESSION['cookie_cart_id'])->delete();
		DB::table('cookie_cart')->where('cart_id', '=', session()->get('cookie_cart_id'))->delete();
		return redirect()->to('addto_cart');
		
		
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(){
		
		if($_POST){
		   
			if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
				foreach($_SESSION['cart'] as $post){
					
					# Update Cart
					$pid=$post['product_id'];
					$arrArgument['product_id']=intval($pid);
					$arrArgument['unit_id']=intval($post['unit_id']);
					$arrArgument['product_quantity']=intval(trim($_POST['qnty_'.$pid]));
					//loadModel('medical','updateCart',$arrArgument);
					$this->updateCart($arrArgument);
					
				}
			}
		
		}
		return redirect()->to('addto_cart');
	}
	
	public function updateCart($arrArgument){
		
		$pid=$arrArgument['product_id'];
		$uid=$arrArgument['unit_id'];
		$q=$arrArgument['product_quantity'];
		
		//$max=count($_SESSION['cart']);
		//for($i=0;$i<$max;$i++){
			
		$carts = Session::get('cart');
        
		foreach($carts as $i => $cart) {		
			if($pid==$cart['product_id'] && $uid==$cart['unit_id']){
			
			//if($pid==$_SESSION['cart'][$i]['product_id'] && $uid==$_SESSION['cart'][$i]['unit_id']){
				
				//$_SESSION['cart'][$i]['product_quantity']=$q;
				unset($carts[$i]);
		
				$newCarts = array_values($carts);
                Session::put('cart', $newCarts);
				break;
			
			}
		
		}
		
		
	}
	
	function updateCart2($product_id,$quantity,$unit_id){
		
		
		
		if(isset($product_id)){
		
		$pid=intval($product_id);
		$uid=intval($unit_id);
		$q=intval($quantity);
		
		$carts = Session::get('cart');
		foreach($carts as $i => $cart) {
			
			if($pid==$cart['product_id'] && $uid==$cart['unit_id']){
				
				$carts[$i]['product_quantity']=$q;
				$newCarts = array_values($carts);
                Session::put('cart', $newCarts);
				//$sql_1="update cookie_cart SET product_quantity=$q where product_id=$pid && cart_id='".$_SESSION['cookie_cart_id']."'";
		        //DB::update('update cookie_cart set product_quantity = ? where category_id = ?, cart_id = ?', [$q, $pid, $_SESSION['cookie_cart_id']]);
				$cookie_cart_id = session()->get('cookie_cart_id');
				DB::update("update cookie_cart set product_quantity = '$q' where product_id = '$pid' AND cart_id = '$cookie_cart_id'");
				break;
			
			}
		
		}
		
		$mfa = DB::select("select * from unit_product where product_id=$pid and unit_id=$uid");
		
		$price=trim($mfa[0]->product_price);
		if(trim($mfa[0]->product_sprice)!=''){
		
			$price=trim($mfa[0]->product_sprice);
		}
		
		$price='$'.number_format($price*$q,2);
		
		$total=$this->getCartTotal();
		$total='$'.number_format(trim($total),2);
		
		echo $price.'__'.$total;
		
		}
	}
	
	function getCartTotal(){
	
		$sub_total=0;
		$carts = Session::get('cart');
		foreach(array_reverse($carts) as $post) {
		//foreach(array_reverse($_SESSION['cart']) as $post){
			
			$product_id=intval(trim($post['product_id']));
			$unit_id=intval(trim($post['unit_id']));
			$product_quantity=intval(trim($post['product_quantity']));
			
			$mfa = DB::select("select * from unit_product where product_id='".$product_id."' and unit_id='".$unit_id."'");
			
			if(trim($mfa[0]->product_sprice)==''){
				$total=trim($mfa[0]->product_price)*intval($product_quantity);	
			}
			else{
				$total=trim($mfa[0]->product_sprice)*intval($product_quantity);	
			}
			
			$sub_total+=$total;
			
		}
		return $sub_total;
	
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		//
	}
	
	public function category($id){
		//
	}
	
	public function ajax_cart_items(){
		
	   $carts = Session::get('cart');
	   if(empty($carts)){ 
	   		echo 0;
	   } else {
		  $qty = 0;
			foreach(array_reverse($carts) as $cart) {
				$qty += $cart['product_quantity'];
           }
           echo $qty; 
		} 	
    }
	
	function ajax_cart(){
	   $carts = Session::get('cart');		
	   if(empty($carts)){ ?>
<div style="float:left; width:200px !important; padding-left:15px; font-family:Arial, Helvetica, sans-serif;font-size:14px; text-align: center;">
  <p id="dispaly_Cart"><span style="font-size:12px;"><br>
    <strong>Your Shopping Cart is empty.</strong><br>
    <span>Give it purpose—fill it with supplies, equipment, and more.</span><br>
    <span>If you already have an account, <a href="<?php echo url('login_user') ?>" style="color: #08c;" class="start_here"> Sign in</a><span></span> </span></span></p>
</div>
<button class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" type="button" title="View Cart" onClick="window.location='<?php echo url('addto_cart') ?>'" style="color: #FFF; width: 210px;"> <span style="font-weight:bold;">View Cart</span> (Total 0 items) <span></span></button>
<?php }
      else{
		  $count = 0;
		  $qty = 0;
          echo'<div style="float:left; width:200px !important; padding-left:15px; font-family:Arial, Helvetica, sans-serif;font-size:14px; text-align: center;">';
           foreach(array_reverse($carts) as $cart) {
				$qty += $cart['product_quantity'];
                //$record = mysql_fetch_array(mysql_query("SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id where product.product_id=".$cart['product_id']." group by product.product_id")); 
				$record = DB::select("SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id where product.product_id=".$cart['product_id']." group by product.product_id");
				if($count < 3){ ?>
<p id="dispaly_Cart">
<div style=" width:10px;float:left; margin-left:-15px;"><a href="<?php echo url('product-detail/'.$record[0]->product_id); ?>"><img src="<?php echo url('/uploads/product/'.trim($record[0]->product_image)); ?>" width="62" height="60"></a></div>
<div style="width:150px; float:left; margin:5px 0 0 50px; text-align: left;"><a href="<?php echo url('product-detail/'.$record[0]->product_id); ?>" style="text-indent:0px;"><?php echo $record[0]->product_title; ?><br>
  </a><span style="float:left; margin-top:0 !important; color:#1c7fbf; font-size:13px; font-weight:bold; font-family:Arial, Helvetica, sans-serif;">Quantity: <?php echo $cart['product_quantity']; ?></span></div>
</p>
<?php }
	$count++;
}
				$addto_cart_url = url('addto_cart');
                echo '<br><a href="'.$addto_cart_url.'"><button class="button2 btn-proceed-checkout btn-checkout2 btncart add_cart" type="button" title="View Cart" style="margin-left: 0; color: #FFF; width: 210px;"><span style="font-weight:bold;">View Cart</span> (Total '.$qty.' items) <span></span> </button></a>'; } 
				
   }
	
	public function detailpage($id){
		
		$bestSeller = DB::table("best_seller")->first();
		
		$bsp = (Array) DB::select("SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id where product.product_item_no IN (".$bestSeller->bs_product.") group by product.product_id order by rand() limit 3");
		
		$product = (Array)  DB::select("select p.*,pi.*,u.*,up.* from product p left join product_image pi on p.product_id=pi.product_id INNER JOIN unit_product up on p.product_id=up.product_id INNER JOIN unit u on up.unit_id=u.unit_id where p.product_id=".($id)." order by pi.pi_id DESC limit 1");
		
		$unit = (Array) DB::select("select u.*, up.*, p.product_id from product p INNER JOIN unit_product up on p.product_id=up.product_id INNER JOIN unit u on u.unit_id=up.unit_id where p.product_id= ".($id)." order by u.unit_title ASC");
		
		$review = (Array)  DB::select("select u.*, p.product_id, p.product_title, p.product_item_no, r.* from user u INNER JOIN review r on u.user_id=r.user_id INNER JOIN product p on r.product_id=p.product_id where p.product_id= ".($id)." AND r.rew_status=1 order by r.rew_id DESC");
		
//		dd($product);
		return view('frontwebsite.detail', compact('bsp', 'product', 'unit', 'review'));
		
	}
	
	
		
}
