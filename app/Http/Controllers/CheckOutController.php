<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Phpcreditcard;
use App\Helpers\BluePay;
use Mail;
use Illuminate\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request){
		
		if($request->get('product_id') != null && $request->get('cquantity') != null){
			
			if(session()->get('fromFav') != null){
				session()->pull('fromFav');
			}
			# Add to Cart
			$arrArgument[ 'product_id' ] = (int) ($request->get('product_id'));
			$arrArgument[ 'unit_id' ] = (int) ($request->get('unit_id'));
			$arrArgument[ 'product_quantity' ] = (int) (trim($request->get('cquantity')));
			self::addCart($arrArgument);
		}
		
		# When Add to Cart come from Favourite
		if($request->get('product_item') !== null){
			
			session()->put('fromFav', 1);
			//echo '<pre>'.print_rreget( ,true').'</pre>';
			foreach($request->get('product_item') as $key => $value){
				
				$exp = explode('_', $value);
				$product_id = $exp[ 0 ];
				$unit_id = [$request->get('unit_').$value];
				$product_quantity = (int) ([$request->get('product_quantity_').$product_id.'_'.$exp[ 2 ]]);
				# Add to Cart
				$arrArgument[ 'product_id' ] = $product_id;
				$arrArgument[ 'unit_id' ] = $unit_id;
				$arrArgument[ 'product_quantity' ] = $product_quantity;
				self::addCart($arrArgument);
			}
		}
		
		# When Move to Cart come from Quotes
		if($request->get('move_cart') !== null){
			
			if(session()->get('quote') != null && !empty(session()->get('quote'))){
				
				foreach(session()->get('quote') as $key => $value){
					
					if($request->get('quote1Product'.$value[ 'product_id' ])){
						
						$post = DB::select("select p.product_id,p.product_title,p.product_item_no,pi.*,u.*, up.* from product p inner join unit_product up on p.product_id=up.product_id inner join unit u on u.unit_id=up.unit_id inner join product_image pi on p.product_id=pi.product_id where p.product_id='".$value[ 'product_id' ]."' and up.unit_id='".$value[ 'unit_id' ]."' group by p.product_id");
						
						$post = reset(json_decode(json_encode($post), TRUE));
						
						$product_id = $post[ 'product_id' ];
						$unit_id = $post[ 'unit_id' ];
						$product_quantity = $value[ 'product_quantity' ];
						
						# Add to Cart
						$arrArgument[ 'product_id' ] = $product_id;
						$arrArgument[ 'unit_id' ] = $unit_id;
						$arrArgument[ 'product_quantity' ] = $product_quantity;
						
						self::addCart($arrArgument);
						session()->pull($key);
					}
				}
			}
		}
		
		$slugs = explode ("/", request()->fullUrl());
 		$bsa_id = $slugs [(count ($slugs) - 1)];
		
		if(isset($bsa_id) && is_numeric($bsa_id)){
			$bsa=intval($bsa_id);
			$arrArgument['table']='bill_ship_address';
			$where=array('user_id'=>session()->get('user_id'),'bsa_id'=>$bsa);
			$arrArgument['where']=$where;
			$arrArgument['operator']='AND';
			$arrArgument['order']='bsa_id ASC';
			//$arrValue['bsa_edit']=self::getRecord2($arrArgument);
			$arrValue['bsa_edit']=Helper::instance()->getRecord($arrArgument);
			
		}
		
		$arrArgument[ 'table' ] = 'admin';
		$where = [];
		$arrArgument[ 'where' ] = $where;
		$arrArgument[ 'operator' ] = '';
		$arrArgument[ 'order' ] = 'id ASC';
		$arrValue[ 'setting' ] = self::getRecord($arrArgument);
		
		$arrArgument[ 'table' ] = 'user';
		$where = ['user_id' => (int) (session()->get('quote'))];
		$arrArgument[ 'where' ] = $where;
		$arrArgument[ 'operator' ] = '';
		$arrArgument[ 'order' ] = 'user_id ASC';
		$arrValue[ 'user' ] = self::getRecord($arrArgument);
		
		$arrArgument[ 'table' ] = 'shipping';
		$where = [];
		$arrArgument[ 'where' ] = $where;
		$arrArgument[ 'operator' ] = '';
		$arrArgument[ 'order' ] = 'ship_id ASC';
		$arrValue[ 'ship' ] = self::getRecord($arrArgument);
		
		$arrArgument[ 'table' ] = 'bill_ship_address';
		//$where = ['user_id' => session()->get('front_id'), 'bsa_id' => ((isset($bsa)) ? $bsa : 2)];
		$where = ['user_id' => session()->get('user_id'), 'bsa_type'=>'shipping'];		
		$arrArgument[ 'where' ] = $where;
		$arrArgument[ 'operator' ] = 'AND';
		$arrArgument[ 'order' ] = 'bsa_id ASC';
		$arrValue[ 'bsa' ] = self::getRecord($arrArgument);
		
		return view('frontwebsite.cart', compact('arrValue'));
	}
	
	public function addCart($arrArgument){
		
		$pid = $arrArgument[ 'product_id' ];
		$uid = $arrArgument[ 'unit_id' ];
		$q = $arrArgument[ 'product_quantity' ];
		
		$bundle = 0;
		$configure = 0;
		//echo '<pre>'.print_r($arrArgument['product_bundle'],true).'</pre>';exit;
		if(isset($arrArgument[ 'product_bundle' ])){
			$bundle = $arrArgument[ 'product_bundle' ];
		}
		
		if(isset($arrArgument[ 'configure_product' ])){
			$configure = 1;
			$manufacturer = $arrArgument[ 'manufacturer' ];
			$uom = $arrArgument[ 'uom' ];
		}
		
		if($pid < 1 or $q < 1) return;
		if(is_array($_SESSION[ 'cart' ])){
			if($this->productExist($pid, $uid, $q)) return;
			$max = count(session()->get('cart'));
			session()->put('cart.'.$max.'product_id', $pid);
			session()->put('cart.'.$max.'unit_id', $uid);
			session()->put('cart.'.$max.'product_quantity', $q);
			session()->put('cart.'.$max.'product_bundle', $bundle);
			
			$cookie_id = session()->get('front_name').session()->get('front_id');
			$cart_id = session()->get('cookie_cart_id');
			$userId = session()->get('front_id');
			$useremail = session()->get('front_email');
			$datetime = date('Y-m-d H:i:s');
			
			DB::insert("insert into cookie_cart (cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values ('$cart_id','$cookie_id','$useremail',$pid,$uid,$q,$bundle)");
		}else{
			
			session()->put('cart.0.product_id.', $pid);
			session()->put('cart.0.unit_id.', $uid);
			session()->put('cart.0.product_quantity.', $q);
			session()->put('cart.0.product_bundle.', $bundle);
			
			if(isset($arrArgument[ 'configure_product' ])){
				session()->put('cart.0.configure_product', $configure);
				session()->put('cart.0.manufacturer', $manufacturer);
				session()->put('cart.0.uom', $uom);
			}
			
			$cookie_id = session()->get('front_name').session()->get('front_id');
			$cart_id = session()->get('cookie_cart_id');
			$userId = session()->get('front_id');
			$useremail = session()->get('front_email');
			$datetime = date('Y-m-d H:i:s');
			
			$aband_row = DB::select("select * from cookie_cart_id where cart_id='$id'");
			
			if(count($aband_row)){
				DB::insert("insert into cookie_cart_id (cart_id,user_id,datetime) values ('$cart_id',$userId,'$datetime')");
			}
			
			DB::insert("insert into cookie_cart (cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values ('$cart_id','$cookie_id','$useremail',$pid,$uid,$q,$bundle)");
		}
		$user_id = session()->get('front_id');
		$ip_addr = $_SERVER[ 'REMOTE_ADDR' ];
		$date = date('Y-m-d H:i:s');
		DB::insert("insert into visitor_cart_stats (user_id, ip_address, product_id, type, action, date) values ($user_id, '$ip_addr', '$pid', 'Cart', 'Add', '$date')");
		return TRUE;
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
	public function update(Request $request, $id){
		//
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
	
	public function getRecord($arrArgument){
		
		$where = '';
		$limit = '';
		$groupby = '';
		$table = $arrArgument[ 'table' ];
		if(isset($arrArgument[ 'column' ])){
			$column = $arrArgument[ 'column' ];
		}else{
			$column = "*";
		}
		$count_array = count($arrArgument[ 'where' ])-1;
		$count = 0;
		foreach($arrArgument[ 'where' ] as $key => $value){
			$count++;
			
			$where .= trim($key).'='."'".(trim($value))."'";
			if($arrArgument[ 'operator' ] != '' && $count <= $count_array){
				
				$where .= ' '.$arrArgument[ 'operator' ].' ';
			}
		}
		
		if($where != ''){
			
			$where = 'WHERE '.$where;
		}
		if(isset($arrArgument[ 'limit' ])){
			
			$limit = 'limit '.$arrArgument[ 'limit' ];
		}
		if(isset($arrArgument[ 'group' ])){
			
			$groupby = 'group by '.$arrArgument[ 'group' ];
		}
		
		$order = 'order by '.$arrArgument[ 'order' ];
		$sql = "select $column from $table $where $groupby $order $limit";
		
		$rows = json_decode(json_encode(DB::select($sql)), TRUE);
		$array_return = [];
		if(count($rows) > 0){
			return $array_return;
		}else{
			return $array_return;
		}
	}
	
	public function getRecord2($arrArgument){
		
		$where = '';
		$limit = '';
		$groupby = '';
		$table = $arrArgument[ 'table' ];
		if(isset($arrArgument[ 'column' ])){
			$column = $arrArgument[ 'column' ];
		}else{
			$column = "*";
		}
		$count_array = count($arrArgument[ 'where' ])-1;
		$count = 0;
		foreach($arrArgument[ 'where' ] as $key => $value){
			$count++;
			
			$where .= trim($key).'='."'".(trim($value))."'";
			if($arrArgument[ 'operator' ] != '' && $count <= $count_array){
				
				$where .= ' '.$arrArgument[ 'operator' ].' ';
			}
		}
		
		if($where != ''){
			
			$where = 'WHERE '.$where;
		}
		if(isset($arrArgument[ 'limit' ])){
			
			$limit = 'limit '.$arrArgument[ 'limit' ];
		}
		if(isset($arrArgument[ 'group' ])){
			
			$groupby = 'group by '.$arrArgument[ 'group' ];
		}
		
		$order = 'order by '.$arrArgument[ 'order' ];
		$sql = "select $column from $table $where $groupby $order $limit";
		
		$rows = json_decode(json_encode(DB::select($sql)), TRUE);
		$array_return = [];
		if(count($rows) > 0){
			return $array_return;
		}else{
			return $array_return;
		}
	}
	
	public function add(Request $request){
		
		$default = 0;
		if($request->get('default') != null) $default = 1;
		
		# Insert Billing Shipping Location
		$type = (trim($request->input('type')));
		$fname = (trim($request->input('fname')));
		$lname = (trim($request->input('lname')));
		$phone = (trim($request->input('phone')));
		
		$address = (trim($request->input('address')));
		$city = (trim($request->input('city')));
		
		$exp = (strpos($request->input('state'), '_') != FALSE) ? explode('_', trim($request->input('state'))) : '';
		
		$state = trim((isset($exp[ 0 ])) ? $exp[ 0 ] : 0);
		
		$address_type = (trim($request->input('address_type')));
		
		$ship_dir = (trim($request->input('ship_dir')));
		
		$country = trim(((isset($exp[ 1 ])) ? $exp[ 1 ] : 0));
		
		$zip = (trim($request->input('zip')));
		$date = date('Y-m-d H:i:s');
		$post = [
		 
		 'user_id'     => session()->get('user_id'),
		 'bsa_fname'   => $fname,
		 'bsa_lname'   => $lname,
		 'bsa_phone'   => $phone,
		 'bsa_address' => $address,
		 'bsa_zip'     => $zip,
		 'bsa_city'    => $city,
		 'bsa_state'   => $state,
		 'bsa_country' => $country,
		 'bsa_type'    => $type,
		 
		 'bsa_address_type' => $address_type,
		 
		 'bsa_ship_dir' => $ship_dir,
		 'bsa_default'  => $default,
		 'bsa_date'     => $date
		
		];
		
		$arrArgument[ 'table' ] = 'bill_ship_address';
		$arrArgument[ 'post' ] = $post;
		$last_id = Helper::instance()->insertRecord($arrArgument);
		
		if($default == 1){
			self::removeDefault($last_id, $type);
		}
		# When add ship address from payment page
		if($request->input('redirect')){
			//$url = "'".url('').'index.php?controller=cart&function=payment&ship_id='.$last_id."'";
			return redirect()->back();
		}else{
			?>
			<?php /*?>$url = "'".url('').'index.php?controller=profile&function=index'."'";
			echo "<script>window.location=$url</script>";<?php */?>
			<?php
            return redirect()->back();
		}
		
		exit;
	}
	
	public function removeDefault($last_id, $type){
		$post = ['bsa_default' => 0];
		$arrArgument[ 'table' ] = 'bill_ship_address';
		$arrArgument[ 'post' ] = $post;
		$where = ['user_id' => session()->get('front_id'), 'bsa_type' => $type, 'bsa_id!' => $last_id];
		$arrArgument[ 'where' ] = $where;
		$arrArgument[ 'operator' ] = 'AND';
		Helper::instance()->updateRecord($arrArgument);
		return TRUE;
	}
	
	public function checkoutAjax(){
		
		$url = base64_encode('index.php?controller=cart&function=checkout');
		//		$this->isLogin($url);
		
		if(isset($_GET[ 'ship_to_this' ])){
			$bsa = intval($_GET[ 'ship_to_this' ]);
			session()->put('ship_to_this', $bsa);
		}
		
		if(request()->input('payment_method') != null){
			if(request()->input('payment_method') == 'ccpayment'){
				$cc_id = split('_', request()->input('cc_id'));
				$cc_id = $cc_id[ 1 ];
				
				$cc = @reset(json_decode(json_encode("SELECT * FROM user_creditcards where user_id=".session()->get('front_id')." and id=".$cc_id), TRUE));
				
				session()->put('payment_method', 'Credit Card ending with '.substr(preg_replace("/\s+/", "", $cc[ "cc_number" ]), -4));
				session()->put('payment_name', $cc[ 'cc_name' ]);
				session()->put('card_name', $cc[ 'cc_name' ]);
				session()->put('card_no', $cc[ 'cc_num' ]);
				session()->put('card_cvv', $cc[ 'cc_cvv_number' ]);
				session()->put('cardExpire', date('m', strtotime($cc[ 'cc_exp_date' ])).'/'.date('Y', strtotime($cc[ 'cc_exp_date' ])));
			}
			
			if(request()->inuput('payment_method') == 'checkmo'){
				session()->put('payment_method', 'Check / Money Order / Purchase Order');
				session()->put('payment_name', 'Check');
			}
			
			if(request()->input('payment_method') == 'echeckpayment'){
				$bank_id = split('_', request()->input('cc_id'));
				$bank_id = $bank_id[ 1 ];
				
				$bank = reset(json_decode(json_encode(DB::select("SELECT * FROM user_account_bank where user_id=".session()->get('front_id')." and id=".$bank_id)), TRUE));
				session()->put('payment_method', 'E-Check with routing number '.$bank[ "routing_number" ]);
				session()->put('payment_name', 'E-Check');
				session()->put('echeck_routing_number', request()->input('echeck_routing_number'));
				session()->put('echeck_bank_acct_num', request()->input('echeck_bank_acct_num'));
				session()->put('echeck_account_type', request()->input('echeck_account_type'));
			}
			
			$url = "'".url('cart/cartreview')."'";
			dd('payment received successfully');
			echo "<script>window.location=$url</script>";
		}
		if(request()->input('delivery') != null && request()->input('name') != null){
			session()->put('delivery_charges', trim(request()->inut('delivery')));
			session()->put('delivery_method', trim(request()->inut('name')));
		}
		
		if(request()->input('ship_pref') != null){
			
			session()->put('ship_pref', trim(request()->input('ship_pref')));
		}
		
		$arrArgument['table'] = 'bill_ship_address';
		$where = ['user_id' => session()->get('user_id'), 'bsa_id' => session()->get('ship_to_this')];
		$arrArgument['where'] = $where;
		$arrArgument['operator'] = 'AND';
		$arrArgument['order'] = 'bsa_id ASC';
		$arrValue['bsa'] = Helper::instance()->getRecord($arrArgument);
		
		return view('frontwebsite.checkoutpayment', compact('arrValue'));
	}
	
	public function check_card(Request $request){
	  //include_once('phpcreditcard.php');
	  $cardnum = request()->input('cardnum');
	  $cardname = request()->input('cardname');
	  
	  //$card = checkCreditCard ($cardnum, $cardname, $ccerror, $ccerrortext);
	  $card = Phpcreditcard::instance()->checkCreditCard ($cardnum, $cardname, $ccerror, $ccerrortext);
	  echo $card;
    }
	
	public function add_creditcard(Request $request){
	  $cardnum = request()->input('cardnum');
	  $cardcvv = request()->input('cardcvv');
	  $cardname = request()->input('cardname');
	  $card_holder_name = request()->input('card_holder_name');
	  $exp_date = date('Y-m-t', strtotime('20'.request()->input('expDatey').'-'.request()->input('expDatem')));
	  
	  $rec = json_decode(json_encode(DB::select("SELECT * FROM `user_creditcards` where cc_number='".$cardnum."' and  user_id=".session()->get('user_id')." and cc_exp_date > '".date('Y-m-d')."'")));
	  $rec_row=count($rec);
	  
	  if($rec_row==0){
		  $cc_result = json_decode(json_encode(DB::select("SELECT * FROM `user_creditcards` where cc_number='".$cardnum."' and  user_id=".session()->get('user_id'))));
	  	  
		  $qry_row=count($cc_result);
		  
		  if($qry_row > 0)
	  	  {
			  $cc_id = $cc_result[0]->id;
			  DB::update("update `user_creditcards` set cc_cvv_number='$cardcvv', cc_exp_date = '$exp_date' where id=".$cc_id);
		  }
		  else{  
		  $user_id = session()->get('user_id');
		  $cc_id = DB::insert("insert into user_creditcards (user_id,cc_name,cc_holder_name,cc_number,cc_cvv_number,cc_exp_date) values ('$user_id','$cardname','$card_holder_name',$cardnum,$cardcvv,$exp_date)");
		  }
		  
		  $cc = json_decode(json_encode(DB::select("SELECT * FROM user_creditcards where user_id=".session()->get('user_id')." and id=".$cc_id)));
		  
					echo '<div class="col-lg-12 cc_style">
						
					<div class="col-lg-5"><input type="radio" name="cc_id" onclick="paymentmethodcc(\'p_method_ccpayment\');" value="cc_'.$cc[0]->id.'" required="required" checked />
					'.$cc[0]->cc_name.' ending with '.substr(preg_replace("/\s+/", "", $cc[0]->cc_number), -4).'</div>
					<div class="col-lg-3">'.$cc[0]->cc_holder_name.'</div>
					<div class="col-lg-3">'.date("m/Y",strtotime($cc[0]->cc_exp_date)).'</div>
					</div>';
	  }
	  else{
		echo "";	  
	  }
  }
  
  function get_card(Request $request)
  {
	  $id = request()->input('id');
	  $post = DB::select("SELECT * FROM user_creditcards WHERE id=".$id);
	  $rec = json_decode(json_encode($post), TRUE);
		
	  $month = date('m', strtotime($rec[0]['cc_exp_date']));
	  $year = date('Y', strtotime($rec[0]['cc_exp_date']));
	  ?>
      <div class="a-row a-spacing-small" style="width: 350px; float: left;"> Enter your card information: </div>
          <table id="tbl_address1">
              <tr><td><div id="card_error1" style="color: red;"></div></td></tr>
              <tr>
              <td>
              	  <input type="hidden" name="cardId" id="cardId" value="<?php echo $rec[0]["id"]; ?>" />
                  <select name="card_name" id="card_name1" class="continput text required">
                      <option value="">Select Card</option>
                      <option value="American Express" <?php if($rec[0]["cc_name"]=='American Express'){echo 'selected="selected"';} ?>>American Express</option>
                      <option value="Diners Club" <?php if($rec[0]["cc_name"]=='Diners Club'){echo 'selected="selected"';} ?>>Diners Club</option>
                      <option value="Discover" <?php if($rec[0]["cc_name"]=='Discover'){echo 'selected="selected"';} ?>>Discover</option>
                      <option value="Diners Club Enroute" <?php if($rec[0]["cc_name"]=='Diners Club Enroute'){echo 'selected="selected"';} ?>>Diners Club Enroute</option>
                      <option value="JCB" <?php if($rec[0]["cc_name"]=='JCB'){echo 'selected="selected"';} ?>>JCB</option>
                      <option value="Maestro" <?php if($rec[0]["cc_name"]=='Maestro'){echo 'selected="selected"';} ?>>Maestro</option>
                      <option value="MasterCard" <?php if($rec[0]["cc_name"]=='MasterCard'){echo 'selected="selected"';} ?>>MasterCard</option>
                      <option value="Solo" <?php if($rec[0]["cc_name"]=='Solo'){echo 'selected="selected"';} ?>>Solo</option>
                      <option value="VISA" <?php if($rec[0]["cc_name"]=='VISA'){echo 'selected="selected"';} ?>>VISA</option>
                      <option value="VISA Electron" <?php if($rec[0]["cc_name"]=='VISA Electron'){echo 'selected="selected"';} ?>>VISA Electron</option>
                      <option value="LaserCard" <?php if($rec[0]["cc_name"]=='LaserCard'){echo 'selected="selected"';} ?>>LaserCard</option>
                    </select>
                    </select></td>
                </tr>
                <tr>
                  <td>
                  <br />
                  <input type="text" class="continput text required" placeholder="Name on Card" name="card_holder_name" id="card_holder_name1" value="<?php echo $rec[0]["cc_holder_name"]; ?>" />
                  </td>
                </tr>
                <tr>
                  <td>
                  <br />
                  <input type="text" class="continput text required creditcard error" placeholder="Credit Card Number" size="15" name="x_card_num" id="x_card_num1" value="<?php echo $rec[0]["cc_number"]; ?>" /></td>
                </tr>
                <tr>
                  <td>
                  <br />
                  <input type="text" class="continput text required creditcard error" placeholder="CVV Number" size="15" name="x_card_cvv" id="x_card_cvv1" value="<?php echo $rec[0]["cc_cvv_number"]; ?>" /></td>
                </tr>
                <tr>
                  <td><b>Expiration Date</b><br />
                  <select name="x_exp_date_m" id="x_exp_date_m1" class="continput text required">
                      <option value="">Month</option>
                      <option value="01" <?php if($month=='01'){echo 'selected="selected"';} ?>>Janaury</option>
                      <option value="02" <?php if($month=='02'){echo 'selected="selected"';} ?>>February</option>
                      <option value="03" <?php if($month=='03'){echo 'selected="selected"';} ?>>March</option>
                      <option value="04" <?php if($month=='04'){echo 'selected="selected"';} ?>>April</option>
                      <option value="05" <?php if($month=='05'){echo 'selected="selected"';} ?>>May</option>
                      <option value="06" <?php if($month=='06'){echo 'selected="selected"';} ?>>June</option>
                      <option value="07" <?php if($month=='07'){echo 'selected="selected"';} ?>>July</option>
                      <option value="08" <?php if($month=='08'){echo 'selected="selected"';} ?>>August</option>
                      <option value="09" <?php if($month=='09'){echo 'selected="selected"';} ?>>September</option>
                      <option value="10" <?php if($month=='10'){echo 'selected="selected"';} ?>>October</option>
                      <option value="11" <?php if($month=='11'){echo 'selected="selected"';} ?>>November</option>
                      <option value="12" <?php if($month=='12'){echo 'selected="selected"';} ?>>December</option>
                    </select>
                    <select name="x_exp_date_y" id="x_exp_date_y1" class="continput text required">
                      <option value="">Year</option>
                      <option value="16" <?php if($year=='2016'){echo 'selected="selected"';} ?>>2016</option>
                      <option value="17" <?php if($year=='2017'){echo 'selected="selected"';} ?>>2017</option>
                      <option value="18" <?php if($year=='2018'){echo 'selected="selected"';} ?>>2018</option>
                      <option value="19" <?php if($year=='2019'){echo 'selected="selected"';} ?>>2019</option>
                      <option value="20" <?php if($year=='2020'){echo 'selected="selected"';} ?>>2020</option>
                      <option value="21" <?php if($year=='2021'){echo 'selected="selected"';} ?>>2021</option>
                      <option value="22" <?php if($year=='2022'){echo 'selected="selected"';} ?>>2022</option>
                      <option value="23" <?php if($year=='2023'){echo 'selected="selected"';} ?>>2023</option>
                      <option value="24" <?php if($year=='2024'){echo 'selected="selected"';} ?>>2024</option>
                    </select></td>
                  </tr>
                
                <tr>
                <td><input id="ccEditCard" onclick="EditCard();" class="signin_btn" tabindex="0" type="button" value="Edit Card"></td>
                </tr>
                
              </table>
              <?php
  }
	

  public function edit_creditcard(Request $request)
  {
	  $_POST = $request;
	  $cardId = $_POST['cardId'];
	  $cardnum = $_POST['cardnum'];
	  $cardcvv = $_POST['cardcvv'];
	  $cardname = $_POST['cardname'];
	  $card_holder_name = $_POST['card_holder_name'];
	  $exp_date = date('Y-m-t', strtotime('20'.$_POST['expDatey'].'-'.$_POST['expDatem']));
	  
		  $cc_id = DB::update("update user_creditcards set user_id=".session()->get('user_id').", cc_name='$cardname', cc_holder_name='$card_holder_name', cc_number='$cardnum', cc_cvv_number='$cardcvv', cc_exp_date='$exp_date' where id=".$cardId);
		  
		  $qry = json_decode(json_encode(DB::select("SELECT * FROM user_creditcards where user_id=".session()->get('user_id'))), TRUE);
		  echo '<div class="col-lg-12 cc_style">
                <div class="col-lg-5"><h3>Your credit and debit cards</h3></div>
                <div class="col-lg-3">Name on card</div>
                <div class="col-lg-2">Expires on</div>
                <div class="col-lg-1" style="float:right;">Edit</div>
                </div>';
		  //while($cc = mysql_fetch_array($qry)){	
			foreach($qry as $cc){	
				echo '<div class="col-lg-12 cc_style">
				<div class="col-lg-5"><input type="radio" name="cc_id" onclick="paymentmethod(\'p_method_ccpayment\');" value="cc_'.$cc["id"].'" required="required"/>
				'.$cc["cc_name"].' ending with '.substr(preg_replace("/\s+/", "", $cc["cc_number"]), -4).'</div>
				<div class="col-lg-3">'.$cc["cc_holder_name"].'</div>
                <div class="col-lg-2">'.date('m/Y',strtotime($cc['cc_exp_date'])).'</div>
                <div class="col-lg-1" style="float:right;cursor: pointer;"><a onclick="showEditCard('.$cc['id'].')">Edit</a></div>
				</div>';
		  }
	  
  }	

	public function add_bank(Request $request){
	  
	  $_POST = $request;
	  $echeckName = $_POST['echeckName'];
	  $routingNumber = $_POST['routingNumber'];
	  $bankAcctNum = $_POST['bankAcctNum'];
	  $driverLicenseNumber = $_POST['driverLicenseNumber'];
	  $accountType = $_POST['accountType'];
	  
	  DB::insert("insert into user_account_bank set user_id=".session()->get('user_id').", echeck_name='$echeckName', routing_number='$routingNumber', bank_acct_number='$bankAcctNum', driver_license_number='$driverLicenseNumber', account_type='$accountType'");
	  $bank_id = DB::getPdo()->lastInsertId();;
	  
	  $bank2 = json_decode(json_encode(DB::select("SELECT * FROM user_account_bank where user_id=".session()->get('user_id')." and id=".$bank_id)), TRUE);
	  $bank = reset($bank2);
	  
	  
				echo '<div class="col-lg-12 cc_style">
                	
                <div class="col-lg-5"><input type="radio" name="cc_id" onclick="paymentmethod(\'p_method_echeckpayment\');" value="'.$bank["id"].'" required="required" />
				'.$bank["bank_acct_number"].' ending with '.substr(preg_replace("/\s+/", "", $bank["routing_number"]), -4).'</div>
                <div class="col-lg-3">'.$bank["echeck_name"].'</div>
                <div class="col-lg-3">'.$bank["account_type"].'</div>
                </div>';
  	}
	
	public function review(Request $request){
		//  Get Billing/Shipping Address
		$_POST = $request;
		
		if(isset($_POST['payment_method']))
		{
			if(isset($_POST['poNo']) && $_POST['poNo'] != '')
			{
				session()->put('poNo', $_POST['poNo']);
				
			}
			else
			{
				session()->put('poNo', '');
			}
			if($_POST['payment_method'] == 'ccpayment')
			{
				//$cc_id =  split('_',session()->put('poNo', $_POST['cc_id']));
				session()->put('poNo', $_POST['cc_id']);
				$cc_id =  explode('_',session()->get('poNo'));
				$cc_id = $cc_id[1];
				
	  			$cc2 = json_decode(json_encode(DB::select("SELECT * FROM user_creditcards where user_id=".session()->get('user_id')." and id=".$cc_id)), TRUE);
				$cc = reset($cc2);
				
				session()->put('payment_method', 'Credit Card ending with '.substr(preg_replace("/\s+/", "", $cc["cc_number"]), -4));
				session()->put('payment_name', $cc['cc_name']);
				session()->put('card_name', $cc['cc_name']);
				session()->put('card_no', $cc['cc_number']);
				session()->put('card_cvv', $cc['cc_cvv_number']);
				session()->put('cardExpire', date('m',strtotime($cc['cc_exp_date'])).'/'.date('Y',strtotime($cc['cc_exp_date'])));
			}
			
			if($_POST['payment_method'] == 'checkmo'){
				session()->put('payment_method', $_POST['checkmo']);
				session()->put('payment_name', $_POST['checkmo']);
			}
			
			if($_POST['payment_method'] == 'echeckpayment')
			{
				$bank_id =  split('_',$_POST['cc_id']);
				$bank_id = $bank_id[1];

				$bank2 = json_decode(json_encode(DB::select("SELECT * FROM user_account_bank where user_id=".session()->get('user_id')." and id=".$bank_id)), TRUE);
				$bank = reset($bank2);
				
				session()->put('payment_method', 'E-Check with routing number '.$bank["routing_number"]);
				session()->put('payment_name', 'E-Check');
				session()->put('echeck_routing_number', $_POST['echeck_routing_number']);
				session()->put('echeck_bank_acct_num', $_POST['echeck_bank_acct_num']);
				session()->put('echeck_account_type', $_POST['echeck_account_type']);
			}	
		}
		  
			$arrArgument['table']='bill_ship_address';
			$where=array('user_id'=>session()->get('user_id'),'bsa_id'=>session()->get('ship_to_this'));
			$arrArgument['where']=$where;
			$arrArgument['operator']='AND';
			$arrArgument['order']='bsa_id ASC';
			//$arrValue['bsa']=loadModel('medical','getRecord',$arrArgument);
		  	$arrValue['bsa']=Helper::instance()->getRecord($arrArgument);
			
			$arrArgument['table']='osco_settings';
			$where=array('id'=>1);
			$arrArgument['where']=$where;
			$arrArgument['order']='id ASC';
			//$arrValue['osco']=loadModel('medical','getRecord',$arrArgument);
	 		$arrValue['osco']=Helper::instance()->getRecord($arrArgument);
			
		/*loadView('header.php');
		loadView('review.php',$arrValue);
		loadView('footer.php');*/ 
		
		return view('frontwebsite.review', compact('arrValue'));
  }
	
	public function review2(Request $request){
		
		echo 'sessionvalue='.session()->get('123');exit;
		
		//  Get Billing/Shipping Address
		$_POST = $request;
		
		if(isset($_POST['payment_method']))
		{
			if(isset($_POST['poNo']) && $_POST['poNo'] != '')
			{
				session()->put('poNo', $_POST['poNo']);
				
			}
			else
			{
				session()->put('poNo', '');
			}
			if($_POST['payment_method'] == 'ccpayment')
			{
				//$cc_id =  split('_',session()->put('poNo', $_POST['cc_id']));
				session()->put('poNo', $_POST['cc_id']);
				$cc_id =  explode('_',session()->get('poNo'));
				$cc_id = $cc_id[1];
				
	  			$cc2 = json_decode(json_encode(DB::select("SELECT * FROM user_creditcards where user_id=".session()->get('user_id')." and id=".$cc_id)), TRUE);
				$cc = reset($cc2);
				
				session()->put('payment_method', 'Credit Card ending with '.substr(preg_replace("/\s+/", "", $cc["cc_number"]), -4));
				session()->put('payment_name', $cc['cc_name']);
				session()->put('card_name', $cc['cc_name']);
				session()->put('card_no', $cc['cc_number']);
				session()->put('card_cvv', $cc['cc_cvv_number']);
				session()->put('cardExpire', date('m',strtotime($cc['cc_exp_date'])).'/'.date('Y',strtotime($cc['cc_exp_date'])));
			}
			
			if($_POST['payment_method'] == 'checkmo'){
				session()->put('payment_method', $_POST['checkmo']);
				session()->put('payment_name', $_POST['checkmo']);
			}
			
			if($_POST['payment_method'] == 'echeckpayment')
			{
				$bank_id =  split('_',$_POST['cc_id']);
				$bank_id = $bank_id[1];

				$bank2 = json_decode(json_encode(DB::select("SELECT * FROM user_account_bank where user_id=".session()->get('user_id')." and id=".$bank_id)), TRUE);
				$bank = reset($bank2);
				
				session()->put('payment_method', 'E-Check with routing number '.$bank["routing_number"]);
				session()->put('payment_name', 'E-Check');
				session()->put('echeck_routing_number', $_POST['echeck_routing_number']);
				session()->put('echeck_bank_acct_num', $_POST['echeck_bank_acct_num']);
				session()->put('echeck_account_type', $_POST['echeck_account_type']);
			}	
		}
		  
			$arrArgument['table']='bill_ship_address';
			$where=array('user_id'=>session()->get('user_id'),'bsa_id'=>session()->get('ship_to_this'));
			$arrArgument['where']=$where;
			$arrArgument['operator']='AND';
			$arrArgument['order']='bsa_id ASC';
			//$arrValue['bsa']=loadModel('medical','getRecord',$arrArgument);
		  	$arrValue['bsa']=Helper::instance()->getRecord($arrArgument);
			
			$arrArgument['table']='osco_settings';
			$where=array('id'=>1);
			$arrArgument['where']=$where;
			$arrArgument['order']='id ASC';
			//$arrValue['osco']=loadModel('medical','getRecord',$arrArgument);
	 		$arrValue['osco']=Helper::instance()->getRecord($arrArgument);
			
		/*loadView('header.php');
		loadView('review.php',$arrValue);
		loadView('footer.php');*/ 
		
		return view('frontwebsite.review2', compact('arrValue'));
  }
	
	public function checkoutCustomer(){
	   
	   //$url = base64_encode('index.php?controller=cart&function=checkoutCustomer');
		//$this->isLogin($url);
	   if(session()->get('user_id')){
	   
	   $mfa_ship = @reset(json_decode(json_encode(DB::select("select * from bill_ship_address where bsa_id='".session()->get('ship_to_this')."' and user_id='".session()->get('user_id')."'")), TRUE));
	   
	   $p_method = substr(session()->get('payment_method'),0,11);
	   
	   if(session()->get('payment_method') != null && $p_method =='Credit Card'){
		
		//include('BluePay.php');
		$user= json_decode(json_encode(DB::select("SELECT * FROM `user` where user_id=".session()->get('user_id'))), TRUE);
		
		$accountID="100091013338";//"100144703153"; "Merchant's Account ID Here";
		$secretKey="RE9VYFCC86S9V222O5GAQTJMHVPJOSRX";//"QTWZREJHNG7G.GKIZBYMU11XGIGHWC6H";	"Merchant's Secret Key Here";
		$mode="TEST";
		//$mode="LIVE";
		
		$payment = new BluePay();
		
		$payment->BluePay($accountID,$secretKey,$mode);
		
		/*$payment=new BluePay(
			$accountID,
			$secretKey,
			$mode
		);*/
				
		//$payment=BluePay::instance();
		$payment->setCustomerInformation(array(
			'firstName' => trim($mfa_ship['bsa_fname']), 
			'lastName' 	=> trim($mfa_ship['bsa_lname']),
			'addr1' 	=> trim($mfa_ship['bsa_address']),
			'city' 		=> trim($mfa_ship['bsa_city']),
			'state' 	=> trim($mfa_ship['bsa_state']), 
			'zip' 		=> trim($mfa_ship['bsa_zip']), 
			'country' 	=> trim($mfa_ship['bsa_country']), 
			'phone' 	=> trim($mfa_ship['bsa_phone'])
		));
		
		$payment->setCCInformation(array(
			
			'cardNumber' 	=> trim(session()->get('card_no')),
			'cardExpire' 	=> trim(session()->get('cardExpire')),
			'cvv2' 			=> trim(session()->get('card_cvv'))
		));
		
		//$cart_total=loadModel('medical','getCartTotal');
		$cart_total=Helper::instance()->getCartTotal();
		//$cart_total=$this->getCartTotal();
		if(session()->get('reference')=='flyer')
		{
			$flyer_amount=($cart_total/100)*10;
			$cart_total = number_format($cart_total - $flyer_amount,2);
		}
		$grand_total=number_format(trim($cart_total) + trim(session()->get('delivery_charges')),2);
	//	echo $grand_total; exit;
		$payment->auth($grand_total);
		$payment->process();
		if($payment->isSuccessfulResponse()){			
			$transaction_status 	= $payment->getStatus();
			$transaction_message   	= $payment->getMessage();
			$transaction_id 		= $payment->getTransID();
			$AVS_response 		  	= $payment->getAVSResponse();
			$CVS_response 		  	= $payment->getCVV2Response();
			$masked_account 		= $payment->getMaskedAccount();
			$card_type 			 	= $payment->getCardType();
			$authorization_code 	= $payment->getAuthCode();
			
			if($transaction_status == 'APPROVED'){
				$this->checkoutCustomerCard($transaction_id);
			} else {		
				session()->put('cc_error',$transaction_message);
				$url = "'".url('cart/review2')."'";
				echo "<script>window.location=$url</script>";
			}
		} else {
				
				$array=array('Transaction Status'=>$payment->getStatus(), 'Transaction Message'=>$payment->getMessage(), 'Transaction ID'=>$payment->getTransID(), 'AVS Response'=>$payment->getAVSResponse(), 'CVS Response'=>$payment->getCVV2Response(), 'Masked Account'=>$payment->getMaskedAccount(), 'Card Type'=>$payment->getCardType(), 'Authorization Code'=>$payment->getAuthCode());
				
				/*$url = "'".url('cart/review2')."'";
				echo "<script>window.location=$url</script>";
				exit;*/
				
				/////////// redirect new code ///////////////
				session()->put('all_error',$array);
				
				$arrArgument['table']='bill_ship_address';
				$where=array('user_id'=>session()->get('user_id'),'bsa_id'=>session()->get('ship_to_this'));
				$arrArgument['where']=$where;
				$arrArgument['operator']='AND';
				$arrArgument['order']='bsa_id ASC';
				$arrValue['bsa']=Helper::instance()->getRecord($arrArgument);
				
				$arrArgument['table']='osco_settings';
				$where=array('id'=>1);
				$arrArgument['where']=$where;
				$arrArgument['order']='id ASC';
				$arrValue['osco']=Helper::instance()->getRecord($arrArgument);
				
				return view('frontwebsite.review2', compact('arrValue'));
				/////////// redirect new code ///////////////
		}
		
	} else {	
		$this->checkoutCustomerCard();
	}   
	   
	session()->put('thanks', '<h2  class="a-color-success">Thank you, your order has been placed.</h2>
	<p id="subHeadingOnly">An email confirmation has been sent to you.</p>
	<h5> <strong>Order Number:</strong> <span class="a-text-bold">Med- '.session()->get("order_id").'</span></h5>
	<p class="a-text-bold">Estimated delivery: '.date('M. d, Y', strtotime(date('Y-m-d'). ' + 4 days')).' - '.date('M. d, Y', strtotime(date('Y-m-d'). ' + 6 days')).'</p>');
	DB::table('cookie_cart')->where('cart_id', '=', session()->get('cookie_cart_id'))->delete();
	$url = "'".url('thanks/index')."'";
	echo "<script>window.location=$url</script>";
	   
  }
	
	}
	
	public function getCartTotal(){
	
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
	
	function checkoutCustomerCard($transaction_id=''){
		//echo $_SESSION['poFile'].' __ '.$_COOKIE['poFile']; exit;
		//$url = '';
		//$this->isLogin($url);
		
		if(session()->get('user_id')){
		  
	    if(session()->get('user_id') != null){
			$user_id=intval(session()->get('user_id'));
			$delivery_method=trim(session()->get('delivery_method'));
			if(session()->get('delivery_charges') != null){
				$delivery_charges=trim(session()->get('delivery_charges'));
			} else {
				$delivery_charges=0;
			}
			$ship_pref='';
			if(session()->get('ship_pref')){
				$ship_pref=trim(session()->get('ship_pref'));
			}
			$ship_to_this=intval(session()->get('ship_to_this'));
			$payment_method=trim(session()->get('payment_method'));
			# Coupon Variables
			$ct_id=0;
			$cop_code='';
			$cop_value='';
			$poNo = session()->get('poNo');
	//		$poFile = $_SESSION['poFile'];
			$poFile = session()->get('poFile');
			$ctype='';
			$discount_amount=0;
			if(session()->get('ctype') != null){	
				$ct_id=intval(session()->get('coupon_type'));
				$cop_code=trim(session()->get('coupon_code'));
				$cop_value=trim(session()->get('coupon_value'));
	
				$discount_amount=trim(session()->get('discount_amount'));
				$ctype=trim(session()->get('ctype'));
			}
			$echeck_routing_number='';
			$echeck_bank_acct_num='';
			$echeck_account_type='';
			if($payment_method=='E-Check'){
				$echeck_routing_number=trim(session()->get('echeck_routing_number'));
				$echeck_bank_acct_num=trim(session()->get('echeck_bank_acct_num'));
				$echeck_account_type=trim(session()->get('echeck_account_type'));
			}
			//$cart_total=loadModel('medical','getCartTotal');
			$cart_total=Helper::instance()->getCartTotal();
			//$cart_total=$this->getCartTotal();
			$tax=0;
			$total_before_tax=$cart_total + $delivery_charges;
			$total_after_tax=$cart_total + $delivery_charges + $tax - $discount_amount;
			$date=date('Y-m-d H:i:s'); 
			if(session()->get('reference')=='flyer'){
				$flyer_amount=($cart_total/100)*10;
				$total_after_tax=$total_after_tax - $flyer_amount;
			} else {
				$flyer_amount='';
			}
			# Get User Detail
			$arrArgument['table']='user';
			$where=array('user_id'=>session()->get('user_id'));
			$arrArgument['where']=$where;
			$arrArgument['operator']='';
			$arrArgument['order']='user_id ASC';
			//$arrValue['user']=loadModel('medical','getRecord',$arrArgument);
			$arrValue['user']=Helper::instance()->getRecord($arrArgument);
			
			# Get Shipping Detail
			$arrArgument['table']='bill_ship_address';
			$where=array('user_id'=>session()->get('user_id'), 'bsa_id'=>$ship_to_this);
			$arrArgument['where']=$where;
			$arrArgument['operator']='AND';
			$arrArgument['order']='user_id ASC';
			//$arrValue['bsa']=loadModel('medical','getRecord',$arrArgument);
			$arrValue['bsa']=Helper::instance()->getRecord($arrArgument);
			
			if(substr(session()->get('payment_method'),0,11) == 'Credit Card')
			{
				$payment_method=trim(session()->get('payment_name'));
			}
		   # Order Table
		   $post=array(
				'order_transaction_id'		 => $transaction_id,
				'user_id'					  => $user_id,
				'order_delivery_method'		=> $delivery_method,
				'order_delivery_charges'	   => $delivery_charges,
				'order_ship_pref'			  => $ship_pref,
				'order_tax'					=> $tax,
				'ct_id'						=> $ct_id,
				'ct_name'					  => $ctype,
				'cop_code'					 => $cop_code,
				'cop_value'					=> $cop_value,
				'cop_amount'				   => $discount_amount,
				'order_discount'			   => $flyer_amount,
				'order_grand_total'			=> $total_after_tax,
				'order_payment_method'		 => $payment_method,
				'order_routing_number'		 => $echeck_routing_number,
				'order_bank_acct_num'		  => $echeck_bank_acct_num,
				'order_account_type'		   => $echeck_account_type,
				'purchase_order_no'			=> $poNo,
				'purchase_order_file'		  => $poFile,
				'order_status'				 => 0,
				'order_date'				   => $date
			);
		  # echo '<pre>'.print_r($post,true).'</pre>';exit;
		  $arrArgument['table']='orders';
		  $arrArgument['post']=$post;
		  //$order_id=loadModel('medical', 'insertRecord', $arrArgument);
		  $order_id=Helper::instance()->insertRecord($arrArgument);
		  
		  $order_date=strtotime($date);
		  $order_date=date("m/d/Y g:i A", $order_date);
		  $dear=ucwords(trim($arrValue['bsa'][0]['bsa_fname']));
		  if(trim($dear)==''){
			  $dear=ucwords(trim($arrValue['bsa'][0]['bsa_lname']));
		  }	   
	   	  # Order Detail Table
		  $carts = Session::get('cart');
		   foreach(array_reverse($carts) as $post) {
		   		
				$product_id=intval(trim($post['product_id']));
				# $is_Special=loadModel('medical', 'isSpecial', $product_id);
				$unit_id=intval(trim($post['unit_id']));
				$product_quantity=intval(trim($post['product_quantity']));
			
				$pt_id = 1;
	
				if(isset($post['configure_product']) && $post['configure_product'] != 0)
				{
					$configure_product = 1;
					$manufacturer = $post['manufacturer'];
					$uom = $post['uom'];
					$pt_id = 2;
				}
				
				$mfa = @reset(json_decode(json_encode(DB::select("select * from unit_product where product_id='".$product_id."' and unit_id='".$unit_id."'")), TRUE));
				
				$price=trim($mfa['product_price']);
				if(trim($mfa['product_sprice'])!=''){
					$price=trim($mfa['product_sprice']);
				}
				
				$post=array(
					 
						'order_id'=>trim($order_id),
						'pt_id'=>$pt_id,
						'product_id'=>trim($product_id),
						'product_quantity'=>trim($product_quantity),
						'product_price'=>trim($price),
						'unit_id'=>$unit_id
						
				);
			    $arrArgument['table']='order_detail';
			    $arrArgument['post']=$post;  
			    $id = Helper::instance()->insertRecord($arrArgument);
				
				if(isset($configure_product) && $configure_product != 0)
				{
					$manuf_rec = @reset(json_decode(json_encode(DB::select("SELECT * FROM config_product_option where cpo_id=".$manufacturer)), TRUE));
					$uom_rec = @reset(json_decode(json_encode(DB::select("SELECT * FROM config_product_option where cpo_id=".$uom)), TRUE));
						
		//  Start Query for Manufacture attribute			
					$post=array(
					
						'od_id'=>trim($id),
						'product_id'=>trim($product_id),
						'attribute_id'=>trim($manufacturer),
						'cp_id'=>trim($manuf_rec['cp_id']),
						'attribute_value'=>trim($manuf_rec['cpa_option'])
	
					);
					
					$arrArgument['table']='order_detail_configure';
					$arrArgument['post']=$post;  
					//loadModel('medical', 'insertRecord', $arrArgument);
					Helper::instance()->insertRecord($arrArgument);
					
		//  End Query for Manufacture attribute			
					
					
		//  Start Query for UOM attribute			
					$post=array(
					
						'od_id'=>trim($id),
						'product_id'=>trim($product_id),
						'attribute_id'=>trim($uom),
						'cp_id'=>trim($uom_rec['cp_id']),
						'attribute_value'=>trim($uom_rec['cpa_option'])
	
					);
					
					$arrArgument['table']='order_detail_configure';
					$arrArgument['post']=$post;  
					//loadModel('medical', 'insertRecord', $arrArgument);
					Helper::instance()->insertRecord($arrArgument);
				}
				
		//  End Query for UOM attribute			
		
		   }
			# Insert Order Billing Detail	
			session()->put('order_id', $order_id);
			$post=array(	
				'order_id'			=>trim($order_id),
				'obd_fname'			=>trim($arrValue['bsa'][0]['bsa_fname']),
				'obd_lname'			=>trim($arrValue['bsa'][0]['bsa_lname']),
				'obd_phone'			=>trim($arrValue['bsa'][0]['bsa_phone']),
				'obd_address'		=>trim($arrValue['bsa'][0]['bsa_address']),
				'obd_zip'			=>trim($arrValue['bsa'][0]['bsa_zip']),
				'obd_city'			=>trim($arrValue['bsa'][0]['bsa_city']),
				'obd_state'			=>trim($arrValue['bsa'][0]['bsa_state']),
				'obd_country'		=>trim($arrValue['bsa'][0]['bsa_country']),
				'obd_address_type'	=>trim($arrValue['bsa'][0]['bsa_address_type']),		
				'obd_ship_dir'		=>trim($arrValue['bsa'][0]['bsa_ship_dir'])
			);
			$arrArgument['table']='order_billing_detail';
			$arrArgument['post']=$post;
			//loadModel('medical', 'insertRecord', $arrArgument);
			Helper::instance()->insertRecord($arrArgument);
			# Insert Order Shipping Detail
			$post=array(
			'order_id'			=>trim($order_id),
			'osd_fname'			=>trim($arrValue['bsa'][0]['bsa_fname']),
			'osd_lname'			=>trim($arrValue['bsa'][0]['bsa_lname']),
			'osd_phone'			=>trim($arrValue['bsa'][0]['bsa_phone']),
			'osd_address'		=>trim($arrValue['bsa'][0]['bsa_address']),
			'osd_zip'			=>trim($arrValue['bsa'][0]['bsa_zip']),
			'osd_city'			=>trim($arrValue['bsa'][0]['bsa_city']),
			'osd_state'			=>trim($arrValue['bsa'][0]['bsa_state']),
			'osd_country'		=>trim($arrValue['bsa'][0]['bsa_country']),
			'osd_address_type'	=>trim($arrValue['bsa'][0]['bsa_address_type']),	
			'osd_ship_dir'		=>trim($arrValue['bsa'][0]['bsa_ship_dir'])
			);
			$arrArgument['table']='order_shipping_detail';
			$arrArgument['post']=$post;
			//loadModel('medical', 'insertRecord', $arrArgument);
			Helper::instance()->insertRecord($arrArgument);
				$str="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
						<tr align='center'>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
								<a href=''>
									<img src='url{{ url('/') }}/uploads/ms_o31.png'>
								</a>
							</td>
						</tr>
				</table>";		
	  $str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
			
					<tr align='center'>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p>
								8060 Saint Louis Avenue, <br />
								Skokie, IL 60076<br />
								1-855-MED-SHIP<br />
								<a style='color:#2692da;text-decoration:none' href='http://www.medicalshipment.com'>www.medicalshipment.com</a>
							</p>
						</td>
					</tr>
		
			  </table>";
			  
	  $str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p><b>Dear</b> $dear</p>
						</td>
					</tr>
		
			  </table>";
		  
	  $str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
					
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
								<p style='line-height:16.2pt' class='MsoNormal'>
									This email confirms that your order was received by <b>MedicalShipment</b> on <b>$order_date</b>. Please allow 24 hours for your order to be processed. You may view the status of your order at any time via <span><a style='color:#2692da' href='http://medicalshipment.com/index.php?controller=account&function=index'>your medicalshipment User Account Current Orders Section</a></span>. If you have any further questions or need to make any changes in regards to your order, please contact Customer Service at (847) 253-3000 or email us at <span style='color:#2692da'>info@medicalshipment.com</span>.
								</p>
							</td>
						</tr>
				
				</table>";
				
		$str.="<br /><table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p style='border-bottom:1px solid #eaeaea'><b>Order Information</b></p>
						</td>
					</tr>
		
			  </table><br />";
		$xml="<order>\n\t\t";
		$xml.="<order_information>\n\t\t";
		$xml.="<order_number>$order_id</order_number>\n\t\t";
		$xml.="<order_date>$order_date</order_date>\n\t\t";
		$xml.="</order_information>\n\t\t";
				  
		$str.="<table cellspacing='0' cellpadding='0' width='300' border='0' style=''>			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Order Number</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>$order_id</td>
					</tr>					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Order Date</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>$order_date</td>
					</tr>	
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Payment Method</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>$payment_method</td>
					</tr>
			  </table>";			  
	  
		$str.="<br /><table cellspacing='0' cellpadding='0' width='' border='0' style='width:550pt;'>			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p style='border-bottom:1px solid #eaeaea'><b>Billing Address</b></p>
						</td>
					</tr>

			  </table><br />";
		
		
		$xml.="<billing_address>\n\t\t";
		$xml.="<name>".trim($arrValue['bsa'][0]['bsa_fname']).' '.trim($arrValue['bsa'][0]['bsa_lname'])."</name>\n\t\t";
		$xml.="<phone_number>".trim($arrValue['bsa'][0]['bsa_phone'])."</phone_number>\n\t\t";
		$xml.="<address>".trim($arrValue['bsa'][0]['bsa_address'])."</address>\n\t\t";
		$xml.="<zip_code>".trim($arrValue['bsa'][0]['bsa_zip'])."</zip_code>\n\t\t";
		$xml.="<city>".trim($arrValue['bsa'][0]['bsa_city'])."</city>\n\t\t";
		$xml.="<state>".trim($arrValue['bsa'][0]['bsa_state'])."</state>\n\t\t";
		$xml.="<country>".trim($arrValue['bsa'][0]['bsa_country'])."</country>\n\t\t";
		$xml.="</billing_address>\n\t\t";
		
		
		$xml.="<shipping_address>\n\t\t";
		$xml.="<name>".trim($arrValue['bsa'][0]['bsa_fname']).' '.trim($arrValue['bsa'][0]['bsa_lname'])."</name>\n\t\t";
		$xml.="<phone_number>".trim($arrValue['bsa'][0]['bsa_phone'])."</phone_number>\n\t\t";
		$xml.="<address>".trim($arrValue['bsa'][0]['bsa_address'])."</address>\n\t\t";
		$xml.="<zip_code>".trim($arrValue['bsa'][0]['bsa_zip'])."</zip_code>\n\t\t";
		$xml.="<city>".trim($arrValue['bsa'][0]['bsa_city'])."</city>\n\t\t";
		$xml.="<state>".trim($arrValue['bsa'][0]['bsa_state'])."</state>\n\t\t";
		$xml.="<country>".trim($arrValue['bsa'][0]['bsa_country'])."</country>\n\t\t";
		$xml.="</shipping_address>\n\t\t";		
		
		$xml.="<order_items>\n\t\t";
		$str.="<table cellspacing='0' cellpadding='0' width='' border='0' style=''>
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Full Name</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_fname']).' '.trim($arrValue['bsa'][0]['bsa_lname'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Phone Number</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_phone'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Email</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim(session()->get('front_email'))."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>School/Company</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim(session()->get('company'))."</td>
						</tr>						
						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Address</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_address'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Zip Code</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_zip'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>City</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_city'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>State</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_state'])."</td>
						</tr>						
						<tr>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Country</td>
							<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_country'])."</td>
						</tr>			
				  </table><br />";
			  $str.="<table cellspacing='0' cellpadding='0' width='550' border='1' style='width:550pt;border:solid #eaeaea 1.0pt'>
					<thead>
						<tr>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Item Number<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Product<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Price<u></u><u></u></span></b></p></td>							
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>QTY<u></u><u></u></span></b></p></td>
							<td style='border:none;background:#eaeaea;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><b><span style='font-size:10.0pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Total<u></u><u></u></span></b></p></td>
						</tr>
					</thead>
				<tbody>";
		  
		  $carts = Session::get('cart');
		  foreach(array_reverse($carts) as $post){		   
		   		$product_bundle=0;				
				if($post['product_bundle']!=0){
					$product_bundle=$post['product_bundle'];
				}
		   		$product_id=intval(trim($post['product_id']));
				# $is_Special=loadModel('medical', 'isSpecial', $product_id);
				
				$unit_id=intval(trim($post['unit_id']));
				$product_quantity=intval(trim($post['product_quantity']));				
				
				$mfa = @reset(json_decode(json_encode(DB::select("select * from product where product_id='".$product_id."'")), TRUE));
				
				$mfa_unit = @reset(json_decode(json_encode(DB::select("select * from unit u inner join unit_product up on u.unit_id=up.unit_id where up.product_id='".$product_id."' and up.unit_id='".$unit_id."'")), TRUE));
				
				$special_html="";
				$price=$mfa_unit['product_price'];
				if(trim($mfa_unit['product_sprice'])!=''){
					$price=$mfa_unit['product_sprice'];
				}
			    $total=trim($price) * intval(trim($product_quantity));
				
				$a="";
		  		$str1="";
				# Bundle Product
				$bundle_unit_price=0;
				if($product_bundle!=0){
					
					$bp_array=array();
					foreach($post['product_bundle'] as $key=>$val){
						
						$group_id=$key;
						$qty=0;
						
						$k='';
						foreach($val as $key1=>$val1){
						
							if(is_array($val1)){
								
								foreach($val1 as $product_bundle){
									
									$k.=$product_bundle.',';
									
								}
							}
							else{
								
								$qty=$val1;
							}
							if($qty!=0){
								$bp_array[]=array( $group_id=>array(rtrim($k,',').'|'.$qty));
							}
						}
					}
									
						
						foreach($bp_array as $key=>$value){
							foreach($value as $key1=>$value1){
								
								
								# Get Group Title
								$mfa_group = @reset(json_decode(json_encode(DB::select("select * from bundle_product where bp_id='".$key1."'")), TRUE));
								
								$group=trim($mfa_group['bp_title']);
								$group_id=trim($mfa_group['bp_id']);
								/*echo '<pre>'.print_r($value1,true).'</pre>';exit;*/
								foreach($value1 as $value2){
									
									$exp=explode('|', $value2);
									$value2=trim($exp[0]);
									$qty=trim($exp[1]);
									/*echo '<pre>'.print_r($value2,true).'</pre>';*/
									
									$query_bundle = json_decode(json_encode(DB::select("select * from product where product_id in(".$value2.")")), TRUE);
									
									foreach(@reset($query_bundle) as $mfaBP){
										
										# Get Group Title
										$mfa_price = @reset(json_decode(json_encode(DB::select("select * from unit_product where product_id='".$mfaBP['product_id']."'")), TRUE));
										
										$price=trim($mfa_price['product_price']);
										$sprice=trim($mfa_price['product_sprice']);
										if(trim($sprice)!=''){
											
											$price=$sprice;
											$is_Special=1;
											$is_Special_Text="<div class='special_text'>".'$'.number_format(trim($mfa_price['product_price']), 2)."</div>";
										}									
										$bundle_unit_price+=$price*$qty;
										
										$total=trim($bundle_unit_price)*intval($product_quantity);
										
										
										$str1.='<span class="qnty">'.$qty.'</span>'.' x <span class="product">'.$mfaBP['product_title'].'</span> [ <span class="price">$'.number_format(trim($price),2).'</span> ] '.'<br>';
										
									}
									
									
										if($str1!=''){
											$str1='<br><label class="group"><a href=index.php?controller=product&function=index&id='.$group_id.'>'.$group.'</a></label>'.'<br><br>'.$str1;
											$a.=$str1;
											$str1='';
										}
								
								}
							
							}
						}
									
								/*echo '<pre>'.print_r($bp_array,true).'</pre>';exit;*/
					
				}
				
				if($product_bundle==0){
					$a='';
				}
				if($bundle_unit_price!=0){
					$price=$bundle_unit_price;
				}
				
				$configure = '';
				if(isset($configure_product) && $post['configure_product'] == 1)
				{					
					
					$manuf_rec = @reset(json_decode(json_encode(DB::select("SELECT * FROM config_product_option where cpo_id=".$post['manufacturer'])), TRUE));
					$uom_rec = @reset(json_decode(json_encode(DB::select("SELECT * FROM config_product_option where cpo_id=".$post['uom'])), TRUE));
					
					$configure.="<p style='font-size: 8.5pt;font-family:'Verdana','sans-serif';color:#2f2f2f'><strong>Manufacturer: </strong>".$manuf_rec['cpa_option']."</p>";
					$configure.="<p style='font-size: 8.5pt;font-family:'Verdana','sans-serif';color:#2f2f2f'><strong>UOM: </strong>".$uom_rec['cpa_option']."</p>";
				}
				
				
			$xml.="<order_item>\n\t\t";
			$xml.="<item_no>".stripslashes($mfa['product_item_no'])."</item_no>\n\t\t";
			$xml.="<title>".stripslashes($mfa['product_title'])."</title>\n\t\t";
			$xml.="<price>".number_format(trim($price), 2)."</price>\n\t\t";
			$xml.="<quantity>".intval(trim($product_quantity))."</quantity>\n\t\t";
			$xml.="<total>".number_format(trim($total), 2)."</total>\n\t\t";
			$xml.="</order_item>\n\t\t";
				
			  $str.="<tr>
						<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$mfa['product_item_no']."</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'> <u></u><u></u></span></p></td>
						<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p style='line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".$mfa['product_title'].$a.$configure."$special_html<u></u><u></u></span></p></td>
						<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><div>
						<p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format(trim($price), 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p>
						</div></td>
						
						<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><div>
						<p align='center' style='text-align:center;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".intval(trim($product_quantity))."<u></u><u></u></span></p>
						</div>
						</td>
						<td valign='top' style='border:none;border-bottom:dotted #cccccc 1.0pt;padding:2.25pt 6.75pt 2.25pt 6.75pt'><div>
						<p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($total, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p>
						</div></td>
					</tr>";
			  
			  
		  }
		  
		$xml.="</order_items>\n\t\t";
		$xml.="<sub_total>".number_format($cart_total, 2)."</sub_total>\n\t\t";
		//$xml.="<shipping_handling>".number_format($delivery_charges, 2)."</shipping_handling>\n\t\t";
		$xml.="<shipping_handling>".number_format($delivery_charges, 2)."</shipping_handling>\n\t\t";
		$xml.="<total_before_tax>".number_format($total_before_tax, 2)."</total_before_tax>\n\t\t";
		$xml.="<tax>".number_format($tax, 2)."</tax>\n\t\t";
		$xml.="<discount>".number_format($discount_amount, 2)."</discount>\n\t\t";
		$xml.="<order_total>".number_format($total_after_tax, 2)."</order_total>\n\t\t";
		
		$xml.="<payment_details>\n\t\t";
		$xml.="<payment_method>".session()->get('payment_name')."</payment_method>\n\t\t";
		
		if(substr(session()->get('payment_method'),0,11) == 'Credit Card'){
		$xml.="<transaction_id>".$transaction_id."</transaction_id>\n\t\t";
		}
		if($payment_method == 'E-Check'){
		$xml.="<transaction_id>".$echeck_routing_number."</transaction_id>\n\t\t";
		}
		if($payment_method == 'Check / Money Order / Purchase Order'){
		$xml.="<transaction_id>".$echeck_routing_number."</transaction_id>\n\t\t";
		}
		
		$xml.="<payment_done>".number_format($total_after_tax, 2)."</payment_done>\n\t\t";
		$xml.="</payment_details>\n\t\t";
		
		  
		  
		  $str.="<tr>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Subtotal:<u></u><u></u></span></p></td>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($cart_total, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
				</tr>";
		
		
		$str.="<tr>
				<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Shipping & Handling:<u></u><u></u></span></p></td>
				<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>".'$'.number_format($delivery_charges,2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
			   </tr>";
				
					  
		
						  
		$str.="<tr>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Total before Tax:<u></u><u></u></span></p></td>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($total_before_tax, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
			  </tr>";
			  
			  
		$str.="<tr>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Tax:<u></u><u></u></span></p></td>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($tax, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;color:#2f2f2f'><u></u><u></u></span></p></td>
			  </tr>";
		
		if($ctype!=''){
			$str.="<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Discount:<u></u><u></u></span></p></td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."- $".number_format($discount_amount, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;color:#2f2f2f'><u></u><u></u></span></p></td>
				  </tr>";
		}
		if(session()->get('reference') != null && session()->get('reference') == 'flyer'){	
			$str.="<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Discount:<u></u><u></u></span></p></td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."- $".number_format($flyer_amount, 2)."</span></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;color:#2f2f2f'><u></u><u></u></span></p></td>
				  </tr>";
		}
			  
			  
		$str.="<tr>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='4'><p align='right' style='text-align:right;line-height:16.2pt' class='MsoNormal'><strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>Order Total:</span></strong><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'><u></u><u></u></span></p></td>
					<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'><p align='right' style='text-align:left;line-height:16.2pt' class='MsoNormal'><span><b><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;;color:#2f2f2f'>"."$".number_format($total_after_tax, 2)."</span></b></span><span style='font-size:8.5pt;font-family:&quot;Verdana&quot;&quot;sans-serif&quot;color:#2f2f2f'><u></u><u></u></span></p></td>
			  </tr>";
			  
	  	$str.="</tbody></table>";
		
		
			
		$str.="<br /><table cellspacing='0' cellpadding='0' width='' border='0' style='width:550pt;'>
			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>
							<p style='border-bottom:1px solid #eaeaea'><b>Shipping Information</b></p>
						</td>
					</tr>
		
			  </table><br />";
		
		$str.="<table cellspacing='0' cellpadding='0' width='' border='0' style=''>
			
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Full Name</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_fname']).' '.trim(stripslashes($arrValue['bsa'][0]['bsa_lname']))."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Phone Number</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_phone'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Address</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_address'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Zip Code</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_zip'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>City</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_city'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>State</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_state'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Country</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".trim($arrValue['bsa'][0]['bsa_country'])."</td>
					</tr>
					
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>Shipping speed</td>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt'>".session()->get('delivery_method')."</td>
					</tr>
		
			  </table><br />";
		
		
			$str.="<table cellspacing='0' cellpadding='0' width='550' border='0' style='width:550pt;'>
					<tr>
						<td style='border:none;padding:2.25pt 6.75pt 2.25pt 6.75pt' colspan='5'>
							<p style='line-height:16.2pt' class='MsoNormal'>
								We at MedicalShipment appreciate your continued business and support.
							</p>
						</td>
					</tr>
				  </table>";
				  
				  $xml.="</order>\n\r";
		//		  echo $str; exit;
		//		  echo $xml; exit;
				  $xmlobj=new \SimpleXMLElement($xml);
				  $xml_name = $order_id.'_'.strtotime(date('Y-m-d H:i:s'));
		//		  $xmlobj->asXML("beta/fishbowl_orders/".$xml_name.".xml");
				  $xmlobj->asXML("fishbowl_orders/".$xml_name.".xml");
				  
				  rename ("Ratelogix_xml/".session()->get('xml_name').".xml", "Ratelogix_xml/".$order_id.".xml");
				  session()->pull('xml_name');
				  
		//	echo $str; exit;
		
		    $pofile='';
			if ($payment_method=='Purchase Order') {
				$pofile=$poFile;
			}
			
			//$this->sendEmail($str,$arrValue['user'][0]['user_email'],$pofile);
			//$this->sendEmailReminder($str,$arrValue['user'][0]['user_email'],$pofile);
			//$this->attachment_email($str,$arrValue['user'][0]['user_email'],$pofile);
			$user_email = $arrValue['user'][0]['user_email'];
			/*$url = "'".url('attachment_email/'.$str.'/'.$user_email.'/'.$pofile)."'";
			echo "<script>window.location=$url</script>";*/
			
			//return redirect()->to("attachment_email/$str/$user_email/$pofile");
			
			//$this->attachment_email($str,$user_email,$pofile);
			$this->sendEmail($str,$user_email,$pofile);
			
			//$user_email2 = $arrValue['user'][0]['user_email'];
			//return redirect()->to("sendEmail/$str/$user_email2/$pofile");
			
			if(@$cop_type!='' || session()->get('reference')=='flyer')
			{
					
				$post=array
				(
					'reference'=>''
				); 
	
				$arrArgument['table']='user';
				$arrArgument['post']=$post;
				$where=array('user_id'=>intval(session()->get('user_id')));
				$arrArgument['where']=$where;
				$arrArgument['operator']='';
				//$response=loadModel('medical','updateRecord',$arrArgument);			
				$response=Helper::instance()->updateRecord($arrArgument);
			}
			session()->pull('cart');
			session()->pull('delivery_method');
			session()->pull('delivery_charges');
			session()->pull('poNo');
			session()->pull('poFile');
			setcookie("poFile", "", time() - 3600);
			if(session()->get('ship_pref') != null){
				session()->pull('ship_pref');
			}			
			session()->pull('ship_to_this');
			session()->pull('payment_method');
			session()->pull('coupon_type');
			session()->pull('coupon_code');
			session()->pull('coupon_count');
			session()->pull('coupon_symbol');
			session()->pull('coupon_value');
			session()->pull('discount_amount');
			session()->pull('ctype');
			session()->pull('reference');
			session()->put('thanks','Thank you for submitting your order to MedicalShipment. You will be receiving an order confirmation via email to the address provided. If you have any further questions, or would like to speak with a representative directly, please call (800)736-1743. As always, we appreciate your continued business and support!');
			$url = "'".url('thanks/index')."'";
			echo "<script>window.location=$url</script>";
  }
  
		}
  }
	
	function sendEmail($str,$user_email,$pofile){
		
		# Email to Customer
		$to='asim23ert@gmail.com';		
		$subject="MedicalShipment - Order Confirmation";	
		$message=$str;		
		$headers="MIME-Version: 1.0" . "\r\n";
		$headers.="Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers.='From: <sales@medicalshipment.com>' . "\r\n";

		@mail($to,$subject,$message,$headers);
		
		/*$exp=explode(',',$to);
		foreach($exp as $to){
			@mail($to,$subject,$message,$headers);
		}*/

		
   }
	
	public function attachment_email($str,$user_email,$pofile) {
	  
	  $emailcontent = array('emailBody' => $str);
	  
	  $data = array('name'=>"Virat Gandhi");
      Mail::send(['html' => 'frontwebsite.mail'], $emailcontent, function($message) {
         //$message->to('orders@medicalshipment.com','dan@medicalshipment.com','michael@medicalshipment.com','Alexandra@medicalshipment.com','Alex@medicalshipment.com', 'medical shipment')->subject('MedicalShipment - Order Confirmation');
         $message->to('asim23ert@gmail.com', 'medical shipment')->subject('MedicalShipment - Order Confirmation');
		 //$message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         //$message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
		 //$message->from('orders@medicalshipment.com','medical shipment');
      	 $message->from('asim23ert@gmail.com','medical shipment');
	  });
      echo "Email Sent with attachment. Check your inbox.";
	  
   }
	
	function sendEmail2($message,$user_email,$pofile){
	  
		//$subject="MedicalShipment - Order Confirmation";
		//$headers="MIME-Version: 1.0" . "\r\n";
		//$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
		//$headers.='From: <orders@medicalshipment.com>'."\r\n";
		//$headers.='Cc: myboss@example.com'."\r\n";
		
		$to="orders@medicalshipment.com,dan@medicalshipment.com,michael@medicalshipment.com,Alexandra@medicalshipment.com,Alex@medicalshipment.com";
	
		$userEmail=trim($user_email);//orders@medicalshipment.com
		//$userEmail='shahzeb5@outlook.com';
	
		//require_once 'php_mailer/PHPMailerAutoload.php';
        
		$mail = new PHPMailer;
		
		$mail->setFrom('orders@medicalshipment.com', 'medical shipment');
        
        $mail->Subject  = 'MedicalShipment - Order Confirmation';
        $mail->addAddress($userEmail);
        
		$exp=explode(',',$to);
		foreach($exp as $to){
			$mail->addBCC($to);
		}
		
		if ($pofile!='') {
			/* Attachment File location */
		  $file_name = $pofile;
		  $path = "/home/meditcom/public_html/purchase_orders/";
			
			$mail->addAttachment($path.$file_name);
		}
		$mail->Body = $message;
		$mail->isHTML(true);
	
		$mail->send();
	  
  }
	
	function sendSaveEmail($message,$user_email){
	  
	$to="orders@medicalshipment.com,dan@medicalshipment.com,michael@medicalshipment.com,adriana@medicalshipment.com,".trim($user_email);//orders@medicalshipment.com
	$subject="MedicalShipment - Save Order Confirmation";
	$headers="MIME-Version: 1.0" . "\r\n";
	$headers.="Content-type:text/html;charset=UTF-8"."\r\n";
	
	$headers.='From: <orders@medicalshipment.com>'."\r\n";
	//$headers.='Cc: myboss@example.com'."\r\n";
	$exp=explode(',',$to);
	foreach($exp as $to){
		@mail($to,$subject,$message,$headers);
	}
	  
  }
		
}

