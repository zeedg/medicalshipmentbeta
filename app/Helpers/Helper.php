<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class Helper{
	
	public $nthCategory;
	
	public $nthCategoryID;
	
	public $ftype = ['a', 'b', 'c'];
	
	public $sort_type = ['product_id desc' => 'Product (ID) Desc', 'product_id asc' => 'Product (ID) ASC', 'product_title asc' => 'Product (Title) ASC', 'product_title desc' => 'Product (Title) DESC', 'product_price asc' => 'Price (Low to High)', 'product_price desc' => 'Price (High to Low)', 'product_position asc' => 'Custom Position'];
	
	public $input_type = ['drop_down' => 'Dropdown', 'radio_button' => 'Radio Button', 'checkbox' => 'Checkbox', 'multi_select' => 'Multiple Select'];
	
	public $tax_class = ['0' => 'Retailer A', '1' => 'Retailer B', '2' => 'Retailer C'];
	
	public $states = ['*'  => '*',
	                  'AL' => 'Alabama',
	                  'AK' => 'Alaska',
	                  'AZ' => 'Arizona',
	                  'AR' => 'Arkansas',
	                  'CA' => 'California',
	                  'CO' => 'Colorado',
	                  'CT' => 'Connecticut',
	                  'DE' => 'Delaware',
	                  'DC' => 'District of Columbia',
	                  'FL' => 'Florida',
	                  'GA' => 'Georgia',
	                  'HI' => 'Hawaii',
	                  'ID' => 'Idaho',
	                  'IL' => 'Illinois',
	                  'IN' => 'Indiana',
	                  'IA' => 'Iowa',
	                  'KS' => 'Kansas',
	                  'KY' => 'Kentucky',
	                  'LA' => 'Louisiana',
	                  'ME' => 'Maine',
	                  'MD' => 'Maryland',
	                  'MA' => 'Massachusetts',
	                  'MI' => 'Michigan',
	                  'MN' => 'Minnesota',
	                  'MS' => 'Mississippi',
	                  'MO' => 'Missouri',
	                  'MT' => 'Montana',
	                  'NE' => 'Nebraska',
	                  'NV' => 'Nevada',
	                  'NH' => 'New Hampshire',
	                  'NJ' => 'New Jersey',
	                  'NM' => 'New Mexico',
	                  'NY' => 'New York',
	                  'NC' => 'North Carolina',
	                  'ND' => 'North Dakota',
	                  'OH' => 'Ohio',
	                  'OK' => 'Oklahoma',
	                  'OR' => 'Oregon',
	                  'PA' => 'Pennsylvania',
	                  'RI' => 'Rhode Island',
	                  'SC' => 'South Carolina',
	                  'SD' => 'South Dakota',
	                  'TN' => 'Tennessee',
	                  'TX' => 'Texas',
	                  'UT' => 'Utah',
	                  'VT' => 'Vermont',
	                  'VA' => 'Virginia',
	                  'WA' => 'Washington',
	                  'WV' => 'West Virginia',
	                  'WI' => 'Wisconsin',
	                  'WY' => 'Wyoming'];
	
	public $cstates = ['*'  => '*',
	                   'AB' => 'Alberta',
	                   'BC' => 'British Columbia',
	                   'MB' => 'Manitoba',
	                   'NB' => 'New Brunswick',
	                   'NF' => 'Newfoundland',
	                   'NT' => 'Northwest Territories',
	                   'NS' => 'Nova Scotia',
	                   'NU' => 'Nunavut',
	                   'ON' => 'Ontario',
	                   'PE' => 'Prince Edward Island',
	                   'QC' => 'Quebec',
	                   'SK' => 'Saskatchewan',
	                   'YT' => 'Yukon Territory'];
	
	public $country = ['CA' => 'Canada', 'US' => 'United States'];
	
	public function index($a){
		return 'welcome helper function . :)';
	}
	
	public function loginBackend($arrArgument){
		
		$username = $arrArgument[ 'username' ];
		$password = $arrArgument[ 'password' ];
		
		$query = reset(json_decode(json_encode(DB::select("select * from  admin where username='".$username."'")), TRUE));
		
		$rows = count($query);
		
		if($rows){
			
			$mfa = $rows;
			if(crypt($password, $mfa[ 'password' ]) === $mfa[ 'password' ]){
				
				$_SESSION[ 'admin_username' ] = $username;
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}
	
	public function loginFrontend($arrArgument){
		
		$email = trim($arrArgument[ 'email' ]);
		$password = trim($arrArgument[ 'password' ]);
		
		$query = reset(json_decode(json_encode(DB::select("select * from user where user_email='".$email."' and user_password='".$password."' and user_status=1")), TRUE));
		$rows = count($query);
		if($rows){
			$mfa = ($query);
			session()->put('front_email', $mfa[ 'user_email' ]);
			session()->put('front_id', $mfa[ 'user_id' ]);
			session()->put('front_name', $mfa[ 'user_fname' ]);
			session()->put('company', $mfa[ 'user_company' ]);
			session()->put('reference', $mfa[ 'reference' ]);
			return 1;
		}else{
			return 0;
		}
	}
	
	public function logoutBackend(){
		return session()->pull('admin_username');
	}
	
	public function logoutFrontend(){
		session()->pull('front_id');
		session()->pull('front_email');
		session()->pull('front_name');
		session()->pull('company');
		session()->pull('reference');
	}
	
	public function joinUserOrder($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_decode(json_encode(DB::select("select u.user_email, u.user_id, o.* from user u $join orders o on u.user_id=o.user_id $where order by o.order_id DESC")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserSaveOrder($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_decode(json_encode(DB::select("select u.user_email, u.user_id, o.* from user u $join saveorders o on u.user_id=o.user_id $where order by o.order_id DESC")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinProduct($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		$limit = '';
		if($arrArgument[ 'limit' ]){
			$limit = 'limit '.$arrArgument[ 'limit' ];
		}
		$order = '';
		if($arrArgument[ 'order' ]){
			$order = 'order by '.$arrArgument[ 'order' ];
		}
		
		$query = json_decode(json_encode(DB::select("select p.product_id, p.product_title, p.product_item_no, p.product_slug, p.product_featured, p.product_position, p.product_hero, pt.pt_id, pt.pt_name from product p $join product_type pt on p.pt_id=pt.pt_id $where $order $limit")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinBundleProduct($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_decode(json_encode(DB::select("select bp.*, bpb.product_id as product_id_bridge, bpb.bpb_default, p.product_title, p.product_item_no from bundle_product bp $join bundle_product_bridge bpb on bp.bp_id=bpb.bp_id $join product p on bpb.product_id=p.product_id $where")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			
			return $query;
		}
		return 0;
	}
	
	public function joinCouponType($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$query = json_decode(json_encode(DB::select("select ct.*, c.* from coupon c $join coupon_type ct on c.ct_id=ct.ct_id $where order by c.cop_id ASC")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinConfigProductAttribute($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_decode(json_encode(DB::select("select cp.*, cpa.* from config_product cp $join config_product_attribute cpa on cp.cp_id=cpa.cp_id $where order by cpa.cpa_default DESC")), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserGroup($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_decode(json_encode(DB::select("select u.*, cg.* from user u $join customer_group cg on u.cg_id=cg.cg_id $where order by u.user_id DESC")), TRUE);
		
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinAttributeOption($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = '';
		if($arrArgument[ 'where' ]){
			$where = 'where '.$arrArgument[ 'where' ];
		}
		
		$query = json_encode(json_decode(DB::select("select ass.as_id as as_ids, ass.as_name, aso.* from attribute_set ass $join attribute_set_option aso on ass.as_id=aso.as_id $where order by aso.cp_id ASC")), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $rows;
		}
		return 0;
	}
	
	public function joinUserProductFavorite($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$query = json_decode(json_encode(DB::select("select u.user_id, u.user_email, p.product_id, p.product_title, p.product_detail, p.product_item_no, f.* from user u $join favorite f on u.user_id=f.user_id $join product p on f.product_id=p.product_id $where order by f.fav_id DESC")), TRUE);
		
		$rows = count($query);
		
		if($rows > 0){
			
			return $query;
		}
		return 0;
	}
	
	public function joinUnitProduct($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$query = json_decode(json_encode(DB::select("select u.*, up.*, p.product_id from product p $join unit_product up on p.product_id=up.product_id $join unit u on u.unit_id=up.unit_id $where order by u.unit_title ASC")), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinProductImageUnit($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$type = reset(json_decode(json_encode(DB::select("SELECT * FROM `product` p $where")), TRUE));
		
		if($type[ 'pt_id' ] == 1){
			$sql = "select p.*,pi.*,u.*,up.* from product p left join product_image pi on p.product_id=pi.product_id $join unit_product up on p.product_id=up.product_id $join unit u on up.unit_id=u.unit_id $where order by pi.pi_id DESC limit 1";
		}
		
		if($type[ 'pt_id' ] == 2){
			$sql = "select p.*,pi.*,up.* from product p $join product_image pi on p.product_id=pi.product_id $join unit_product up on p.product_id=up.product_id $where group by p.product_id order by p.product_id ASC";
		}
		
		if($type[ 'pt_id' ] == 3){
			$sql = "select p.*,pi.*,up.* from product p $join product_image pi on p.product_id=pi.product_id $join unit_product up on p.product_id=up.product_id $where group by p.product_id order by p.product_id ASC";
		}
		if($type[ 'pt_id' ] == 4){
			$sql = "select p.*,pi.*,u.*,up.* from product p LEFT JOIN product_image pi on p.product_id=pi.product_id LEFT JOIN unit_product up on p.product_id=up.product_id LEFT JOIN unit u on up.unit_id=u.unit_id $where group by p.product_id order by p.product_id ASC";
		}
		//	echo $sql; 
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function group_product($id){
		
		$sql = "select p.*,pi.*,u.*,up.* from product p inner join product_image pi on p.product_id=pi.product_id inner join unit_product up on p.product_id=up.product_id inner join unit u on up.unit_id=u.unit_id inner join group_product g on p.product_id=g.product_id_group where g.product_id=".$id." group by p.product_id order by p.product_id ASC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function get_from_to_bundle_price($id){
		$from = json_decode(json_encode(DB::select(("SELECT u.product_price FROM bundle_product bp join bundle_product_bridge bpb on bp.bp_id = bpb.bp_id join product p on bpb.product_id = p.product_id join unit_product u on u.product_id = p.product_id where bp.product_id = ".$id.""))), TRUE);
		
		$from_array = [];
		foreach($from as $val){
			$from_array[] = trim($val[ 'product_price' ]);
		}
		
		$to = reset(json_decode(json_encode(DB::select("SELECT sum(u.product_price) as tot FROM bundle_product bp join bundle_product_bridge bpb on bp.bp_id = bpb.bp_id join product p on bpb.product_id = p.product_id join unit_product u on u.product_id = p.product_id where bp.product_id = ".$id." order by u.product_price")), TRUE));
		
		return "From: $".number_format(min($from_array), 2)."<br>
	  			To: $".number_format(trim($to[ 'tot' ]), 2);
	}
	
	public function bundle_group($id){
		
		$query = json_decode(json_encode(DB::select("SELECT * FROM `bundle_product` where product_id=".$id)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function configure_product($id){
		
		$query = json_decode(json_encode(DB::select("SELECT cpo.cpo_id, cp.cp_id, cp.cp_label, cpo.cpa_option, cpo.product_id from config_product cp join config_product_option cpo on cp.cp_id=cpo.cp_id join product p on cpo.product_id=p.product_id where p.product_config_parent = ".$id)), TRUE);
		
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinAttributeList($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		
		$group = $arrArgument[ 'group' ];
		if($group != ''){
			$group = $group;
		}
		
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$sql = "select fe.*, cp.* from form_element fe $join config_product cp on fe.fe_id=cp.fe_id $where $group order by cp.cp_id DESC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinAttributeEdit($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		
		$group = $arrArgument[ 'group' ];
		if($group != ''){
			$group = $group;
		}
		
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$sql = "select fe.*, cp.*, cpa.* from form_element fe $join config_product cp on fe.fe_id=cp.fe_id $join config_product_attribute cpa on cp.cp_id=cpa.cp_id $where $group order by cp.cp_id DESC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserProductReview($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$sql = "select u.*, p.product_id, p.product_title, p.product_item_no, r.* from user u $join review r on u.user_id=r.user_id $join product p on r.product_id=p.product_id $where order by r.rew_id DESC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUnitandUnitProduct($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$limit = $arrArgument[ 'limit' ];
		$sql = "select u.*, up.* from unit u $join unit_product up on u.unit_id=up.unit_id $where order by up.up_id ASC $limit";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserProductQuote($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$sql = "select p.product_id, p.product_title, p.product_item_no, q.*, qd.*, qd.product_price as product_price_quote, un.*, up.* from quote q $join quote_detail qd on q.quote_id=qd.quote_id $join product p on qd.product_id=p.product_id $join unit_product up on p.product_id=up.product_id $join unit un on un.unit_id=up.unit_id $where group by qd.qd_id";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserKitProductQuote($arrArgument){
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		
		$sql = "select p.product_id, p.product_title, p.product_item_no, q.*, qd.*, qd.product_price as product_price_quote, un.*, up.* from kit_quote q $join kit_quote_detail qd on q.quote_id=qd.quote_id $join product p on qd.product_id=p.product_id $join unit_product up on p.product_id=up.product_id $join unit un on un.unit_id=up.unit_id $where group by qd.qd_id";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinCustomerGroupTax($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$sql = "select cg.*, tc.* from customer_group cg $join tax_class tc on cg.tc_id=tc.tc_id $where order by cg.cg_id ASC";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			
			
			return $query;
		}
		return 0;
	}
	
	public function joinUserBSL($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$sql = "select u.*, bsl.* from user u $join bill_ship_location bsl on u.user_id=bsl.user_id order by bsl.bsl_id ASC";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinbslUBD($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = $arrArgument[ 'where' ];
		if($where != ''){
			$where = 'where '.$where;
		}
		$sql = "select bsl.*,ubd.*  from bill_ship_location bsl $join user_bill_detail ubd on bsl.bsl_id=ubd.bsl_id order by bsl.bsl_id DESC";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserProductOrder($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = 'where od.order_id='.$arrArgument[ 'where' ];
		
		$sql = "select u.*, o.*, od.*, p.product_id, p.product_title, p.product_item_no, pi.product_image from user u $join orders o on u.user_id=o.user_id $join order_detail od on o.order_id=od.order_id $join product p on od.product_id=p.product_id $join product_image pi on p.product_id = pi.product_id  $where order by od.od_id DESC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			
			return $query;
		}
		return 0;
	}
	
	public function joinUserProductSaveOrder($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = 'where od.order_id='.$arrArgument[ 'where' ];
		
		$sql = "select u.*, o.*, od.*, p.product_id, p.product_title, p.product_item_no, pi.product_image from user u $join saveorders o on u.user_id=o.user_id $join save_order_detail od on o.order_id=od.order_id $join product p on od.product_id=p.product_id $join product_image pi on p.product_id = pi.product_id  $where order by od.od_id DESC";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		$array_return = [];
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function joinUserProductKitQuote($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = 'where q.quote_id='.$arrArgument[ 'where' ];
		
		$sql = "select q.*, qd.*, pa.*, p.product_title, pi.product_image from kit_quote q $join kit_quote_detail qd on q.quote_id = qd.quote_id $join kit_price_adjustment pa on qd.qd_id = pa.qd_id $join kit_product p on qd.product_id=p.product_id $join kit_product_image pi on p.product_id=pi.product_id $where";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		
		if($rows > 0){
			
			return $query;
		}
		return 0;
	}
	
	public function joinSI($arrArgument){
		
		$join = $arrArgument[ 'join' ];
		$where = 'where si.order_id='.$arrArgument[ 'where' ];
		$sql = "select si.*, sid.* from standard_invoicing si $join standard_invoicing_detail sid on si.si_id=sid.si_id $where order by sid.sid_id DESC";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		
		if($rows > 0){
			return $query;
		}
		return 0;
	}
	
	public function removeRecord($arrArgument){
		
		$table = $arrArgument[ 'table' ];
		$where = 'WHERE '.$arrArgument[ 'where' ];
		$path = $arrArgument[ 'path' ];
		$column = $arrArgument[ 'imageColumn' ];
		
		foreach($column as $col){
			
			if(trim($path) != '' && trim($col) != ''){
				
				$sql = "select $col from $table $where";
				$query = json_decode(json_encode(DB::select($sql)), TRUE);
				
				foreach($query as $mfa){
					$image = $path.$mfa[ trim($col) ];
					@unlink($image);
				}
			}
		}
		
		# Remove Row
		$sql = "Delete from $table $where";
		$query = DB::delete($sql);
		
		if($query){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function getHash($arrArgument){
		
		$password = $arrArgument[ 'password' ];
		$cost = 10;
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		$salt = sprintf("$2a$%02d$", $cost).$salt;
		$hash = crypt($password, $salt);
		return $hash;
	}
	
	public function insertRecord($arrArgument){
		
		$table = $arrArgument[ 'table' ];
		$column = implode(',', array_keys($arrArgument[ 'post' ]));
		$values = "'".implode("','", array_values($arrArgument[ 'post' ]))."'";
		
		$sql = "insert into $table ($column) values ($values)";
		$query = DB::insert($sql);
		$lastInsertedId = DB::getPdo()->lastInsertId();
		if($lastInsertedId > 0){
			return $lastInsertedId;
		}else{
			return 0;
		}
	}
	
	public function updateRecord($arrArgument){
		
		$table = $arrArgument[ 'table' ];
		$key_value = '';
		foreach($arrArgument[ 'post' ] as $key => $value){
			
			$key_value .= $key.'='."'".($value)."'".',';
		}
		$key_value = rtrim($key_value, ',');
		
		$where = '';
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
		$sql = "update $table SET $key_value $where";
		$query = DB::update($sql);
		if($query){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function getRecord($arrArgument, $debug = 'false'){
		
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
		
		($debug != 'false') ? die($sql) : '';
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE); 
		$rows = count($query);
		 
		if($rows > 0){
			
			return $query;
		}
	}
	
	public function getCategoryTree(){
		
		$array_return = self::fetchCategoryTree();
		return $array_return;
	}
	
	public function saveImage($arrArgument){
		
		$file = $arrArgument[ 'image' ][ 'name' ];
		$photo = [];
		$count = count($file);
		for($i = 0 ; $i < $count ; $i++){
			$img = '';
			if(trim($file[ $i ]) != ''){
				
				$ext = pathinfo($file[ $i ], PATHINFO_EXTENSION);
				$img = rand(100, 999999999).'_'.rand(99, 999).'_'.rand(1000, 999999999).'_'.time().'.'.$ext;
				$photo[] = $img;
			}else{
				$photo[] = '';
			}
			
			if($img != ''){
				move_uploaded_file($_FILES[ 'image' ][ 'tmp_name' ][ $i ], $arrArgument[ 'path' ].$img);
			}
		}
		
		return $photo;
	}
	
	public function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = ''){
		
		
		if(!is_array($user_tree_array)) $user_tree_array = [];
		
		$sql = "SELECT * FROM `category` WHERE 1 AND `category_parent` = $parent ORDER BY category_id ASC";
		
		$query = DB::select($sql);
		
		if(count($query) > 0){
			foreach($query as $row){
				$user_tree_array[] = ["category_id" => $row->category_id, "category_title" => $spacing.$row->category_title];
				$user_tree_array = self::fetchCategoryTree($row->category_id, $spacing.'&nbsp;&nbsp;', $user_tree_array);
			}
		}
		
		return $user_tree_array;
	}
	
	public function nthLevelKitCategory($id){
		//global $str;
		$sql = "select * from kit_category where category_id=$id";
		$mfa = (json_decode(json_encode(DB::select($sql)), TRUE));
		if($mfa[ 'category_id' ]){
			$this->nthCategory[] .= $mfa[ 'category_title' ];
			return self::nthLevelKitCategory($mfa[ 'category_parent' ]);
		}else{
			return $this->nthCategory;
		}
	}
	
	public function nthLevelCategory($id){
		
		$sql = "select * from category where category_id=$id";
		$mfa2 = json_decode(json_encode(DB::select($sql)), TRUE);
		$mfa = reset($mfa2);
		
		if($mfa['category_id']){
			$this->nthCategory[] .= $mfa['category_title'];
			return $this->nthLevelCategory($mfa['category_parent']);
		}else{
			return $this->nthCategory;
		}
	}
	
	public function nthLevelCategoryAAA($id){
		
		$sql = "select * from category where category_id=$id";
		$mfa = (json_decode(json_encode(DB::select($sql)), TRUE));
		if($mfa[ 'category_id' ]){
			$this->nthCategory[] .= $mfa[ 'category_title' ];
			$this->nthCategoryID[] .= $mfa[ 'category_id' ];
			return $this->nthLevelCategoryAAA($mfa[ 'category_parent' ]);
		}else{
			$combine = array_combine($this->nthCategory, $this->nthCategoryID);
			return $combine;
		}
	}
	
	public function getRandom($arrArgument){
		
		$table = $arrArgument[ 'table' ];
		$column = $arrArgument[ 'column' ];
		$where = $arrArgument[ 'where' ];
		$limit = $arrArgument[ 'limit' ];
		$sql = "select $column from $table $where order by rand() limit $limit";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
	}
	
	public function recentlyViewed($arrArgument){
		
		//unset($_SESSION['recent_viewed']);
		$id = $arrArgument[ 'product_id' ];
		
		if(!isset($_SESSION[ 'recent_viewed' ])){
			$_SESSION[ 'recent_viewed' ] = [];
		}
		
		if(isset($_SESSION[ 'recent_viewed' ])){
			
			//foreach($_SESSION['recent_viewed'] as $key=>$value){
			
			//if($value!=$id){
			
			$_SESSION[ 'recent_viewed' ][] = $id;
			/*unset($_SESSION['recent_viewed'][$key]);
			$_SESSION['recent_viewed']=array_values($_SESSION['recent_viewed']);*/
			//}
			
			//}
			
		}
		
		return $_SESSION[ 'recent_viewed' ];
		//echo '<pre>'.print_r($_SESSION['recent_viewed'],true).'</pre>';
		
	}
	
	public function inQuery($arrArgument){
		
		$table = trim($arrArgument[ 'table' ]);
		$where = 'WHERE '.trim($arrArgument[ 'where' ]);
		$in = trim($arrArgument[ 'in' ]);
		$order_column = trim($arrArgument[ 'order_column' ]);
		
		$sql = "SELECT * FROM $table $where IN ($in) ORDER BY FIELD($order_column, $in)";
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
	}
	
	public function addCart($arrArgument){
		
		$pid = $arrArgument[ 'product_id' ];
		$uid = $arrArgument[ 'unit_id' ];
		$q = $arrArgument[ 'product_quantity' ];
		
		$bundle = 0;
		$configure = 0;
		
		if(isset($arrArgument[ 'product_bundle' ])){
			$bundle = $arrArgument[ 'product_bundle' ];
		}
		
		if(isset($arrArgument[ 'configure_product' ])){
			$configure = 1;
			$manufacturer = $arrArgument[ 'manufacturer' ];
			$uom = $arrArgument[ 'uom' ];
		}
		
		if($pid < 1 or $q < 1) return;
		if(is_array(session()->get('cart'))){
			if($this->productExist($pid, $uid, $q)) return;
			$max = count(session()->get('cart'));
			session()->put('cart.'.$max.'.product_id', $pid);
			session()->put('cart.'.$max.'.unit_id', $uid);
			session()->put('cart.'.$max.'.product_quantity', $q);
			
			session()->put('cart.'.$max.'.product_bundle', $bundle);
			
			$cookie_id = session()->get('front_name').session()->get('front_id');
			$cart_id = session()->get('cookie_cart_id');
			$userId = session()->get('front_id');
			$useremail = session()->get('front_email');
			$datetime = date('Y-m-d H:i:s');
			
			DB::insert("insert into cookie_cart (cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values ('$cart_id','$cookie_id','$useremail',$pid,$uid,$q,$bundle)");
		}else{
			
			session()->put('cart.0.product_id', $pid);
			session()->put('cart.0.unit_id', $uid);
			session()->put('cart.0.product_quantity', $q);
			
			session()->put('cart.0.product_bundle', $bundle);
			
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
			
			$query_aband = json_decode(json_encode(DB::select("select * from cookie_cart_id where cart_id='$id'")), TRUE);
			$aband_row = count($query_aband);
			
			if($aband_row == 0){
				
				DB::insert("insert into cookie_cart_id (cart_id,user_id,datetime) values ('$cart_id',$userId,'$datetime')");
			}
			
			DB::insert("insert into cookie_cart (cart_id,cookie_id,user_email,product_id,unit_id,product_quantity,product_bundle) values ('$cart_id','$cookie_id','$useremail',$pid,$uid,$q,$bundle)");
		}
		$user_id = session()->get('front_id');
		$ip_addr = $_SERVER[ 'REMOTE_ADDR' ];
		$date = date('Y-m-d H:i:s');
		DB::insert("insert into visitor_cart_stats (user_id, ip_address, product_id, type, action, date) values ($user_id, '$ip_addr', '$pid', 'Cart', 'Add', '$date')");
	}
	
	public function addKit($arrArgument){
		$pid = $arrArgument[ 'product_id' ];
		$q = $arrArgument[ 'product_quantity' ];
		
		$bundle = 0;
		$configure = 0;
		
		if(isset($arrArgument[ 'product_bundle' ])){
			$bundle = $arrArgument[ 'product_bundle' ];
		}
		
		if(isset($arrArgument[ 'configure_product' ])){
			$configure = 1;
			$manufacturer = $arrArgument[ 'manufacturer' ];
			$uom = $arrArgument[ 'uom' ];
		}
		
		if($pid < 1 or $q < 1) return;
		
		if(is_array(session()->get('kit'))){
			if(self::KitProductExist($pid, $q)) return;
			$max = count(session()->get('kit'));
			session()->put('kit.'.$max.'.product_id', $pid);
			session()->put('kit.'.$max.'.product_quantity', $q);
		}else{
			session()->put('kit.'. 0 .'.product_id', $pid);
			session()->put('kit.'. 0 .'.product_quantity', $q);
		}
	}
	
	public function productExist($pid, $uid, $q){
		$pid = (int) ($pid);
		$max = count(session()->get('cart'));
		$flag = 0;
		for($i = 0 ; $i < $max ; $i++){
			if($pid == session()->get('cart.'.$i.'.product_id') && $uid == session()->get('cart.'.$i.'.unit_id')){
				session()->put('cart.'.$i.'.product_quantity', $q);
				$flag = 1;
				break;
			}
		}
		return $flag;
	}
	
	public function KitProductExist($pid, $q){
		$pid = (int) ($pid);
		$max = count(session()->get('kit'));
		$flag = 0;
		for($i = 0 ; $i < $max ; $i++){
			if($pid == sessio()->get('kit.'.$i.'.product_id')){
				session()->put('kit.'.$i.'.product_quantity', $q);
				$flag = 1;
				break;
			}
		}
		return $flag;
	}
	
	public function removeProduct($arrArgument){
		
		$pid = (int) ($arrArgument[ 'product_id' ]);
		$uid = (int) ($arrArgument[ 'unit_id' ]);
		$max = count(session()->get('cart'));
		for($i = 0 ; $i < $max ; $i++){
			if($pid == session()->get('cart.'.$i.'.product_id') && $uid == session()->get('cart.'.$i.'.unit_id')){
				session()->pull('cart.'.$i);
				
				$user_id = session()->get('front_id');
				$cookie_id = session()->get('front_name').session()->get('front_id');
				$ip_addr = $_SERVER[ 'REMOTE_ADDR' ];
				$date = date('Y-m-d H:i:s');
				DB::delete("delete from cookie_cart where cookie_id = '$cookie_id' && product_id=$pid");
				DB::insert("insert into visitor_cart_stats (user_id, ip_address, product_id, type, action, date) values ($user_id, '$ip_addr', '$pid', 'Cart', 'Remove', '$date')");
				break;
			}
		}
		session()->put('cart', array_values($_SESSION[ 'cart' ]));
	}
	
	public function removeKitProduct($arrArgument){
		
		$pid = (int) ($arrArgument[ 'product_id' ]);
		$max = count(session()->get('kit'));
		for($i = 0 ; $i < $max ; $i++){
			if($pid == session()->get('kit.'.$i.'.product_id')){
				session()->get('kit.'.$i);
				break;
			}
		}
		session()->put('kit', array_values($_SESSION[ 'kit' ]));
	}
	
	public function updateCart($arrArgument){
		
		$pid = $arrArgument[ 'product_id' ];
		$uid = $arrArgument[ 'unit_id' ];
		$q = $arrArgument[ 'product_quantity' ];
		
		$max = count(session()->get('cart'));
		for($i = 0 ; $i < $max ; $i++){
			
			if($pid == session()->get('cart.'.$i.'.product_id') && $uid == session()->get('cart.'.$i.'.unit_id')){
				session()->put('cart.'.$i.' .product_quantity', $q);
				break;
			}
		}
	}
	
	public function getFilter($arrArgument){
		
		$table = trim($arrArgument[ 'table' ]);
		$where = trim($arrArgument[ 'where' ]);
		$order = 'order by '.trim($arrArgument[ 'order' ]);
		
		if(isset($arrArgument[ 'column' ])){
			$column = $arrArgument[ 'column' ];
		}else{
			$column = '*';
		}
		
		$sql = "select $column from $table $where $order";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
	}
	
	public function isFile($path, $image){
		
		$path_new = $path.$image;
		
		if(is_file($path_new)){
			
			if(!file_exists($path_new)){
				$path_new = 'assets/images/no-image.jpg';
			}
		}else{
			$path_new = 'assets/images/no-image.jpg';
		}
		
		return $path_new;
	}
	
	public function getCartTotal(){
		
		$sub_total = 0;
		$cartValues = (array) session()->get('cart');
		if(count($cartValues) > 0){
			foreach(array_reverse($cartValues) as $post){
				
				$product_id = (int) (trim($post[ 'product_id' ]));
				$unit_id = (int) (trim($post[ 'unit_id' ]));
				$product_quantity = (int) (trim($post[ 'product_quantity' ]));
				$sql = "select * from unit_product where product_id='".$product_id."' and unit_id='".$unit_id."'";
				$query = json_decode(json_encode(DB::select($sql)), TRUE);
				$mfa = reset($query);
				
				if($post[ 'product_bundle' ] == 0){
					if(trim($mfa[ 'product_sprice' ]) != ''){
						$total = trim($mfa[ 'product_sprice' ])*(int) ($product_quantity);
					}else{
						$total = trim($mfa[ 'product_price' ])*(int) ($product_quantity);
					}
				}else{
					$total = self::getBundleTotal($post[ 'product_bundle' ]);
				}
				$sub_total += $total;
			}
		}
		return $sub_total;
	}
	
	public function getKitCartTotal(){
		
		$sub_total = 0;
		if(isset($_SESSION[ 'bag_id' ])){
			
			$rec = reset(json_decode(json_encode(DB::select("select * from kit_bags where id='".$_SESSION[ 'bag_id' ]."'")), TRUE));
			
			if($rec[ 'bag_sprice' ] > 0.00){
				
				$bag_price = $rec[ 'bag_sprice' ]*$_SESSION[ 'bag_qty' ];
			}else{
				
				$bag_price = $rec[ 'bag_price' ]*$_SESSION[ 'bag_qty' ];
			}
		}
		foreach(array_reverse((array) session()->get('kit')) as $post){
			
			$product_id = (int) (trim($post[ 'product_id' ]));
			$product_quantity = (int) (trim($post[ 'product_quantity' ]));
			$sql = "select * from kit_product where product_id='".$product_id."'";
			$query = json_decode(json_encode(DB::select($sql)), TRUE);
			$mfa = reset($query);
			$total = trim($mfa[ 'product_price' ])*(int) ($product_quantity);
			$sub_total += $total;
		}
		
		$sub_total += $bag_price;
		return $sub_total;
	}
	
	public function getBundleTotal($array){
		
		# Bundle Product
		$bundle_unit_price = 0;
		$bp_array = [];
		foreach($array as $key => $val){
			
			$group_id = $key;
			$qty = 0;
			
			$k = '';
			foreach($val as $key1 => $val1){
				
				if(is_array($val1)){
					
					foreach($val1 as $product_bundle){
						
						$k .= $product_bundle.',';
					}
				}else{
					
					$qty = $val1;
				}
				if($qty != 0){
					$bp_array[] = [$group_id => [rtrim($k, ',').'|'.$qty]];
				}
			}
		}
		
		foreach($bp_array as $key => $value){
			foreach($value as $key1 => $value1){
				
				# Get Group Title
				$sql_group = "select * from bundle_product where bp_id='".$key1."'";
				$query_group = json_decode(json_encode(DB::select($sql_group)), TRUE);
				$mfa_group = reset($query_group);
				$group = trim(stripslashes($mfa_group[ 'bp_title' ]));
				$group_id = trim($mfa_group[ 'bp_id' ]);
				
				foreach($value1 as $value2){
					
					$exp = explode('|', $value2);
					$value2 = trim($exp[ 0 ]);
					$qty = trim($exp[ 1 ]);
					
					$sql_bundle = "select * from product where product_id in(".$value2.")";
					$query_bundle = json_decode(json_encode(DB::select($sql_bundle)), TRUE);
					
					foreach($query_bundle as $mfaBP){
						
						# Get Group Title
						$sql_price = "select * from unit_product where product_id='".$mfaBP[ 'product_id' ]."'";
						$query_price = DB::select($sql_price);
						$mfa_price = reset(json_decode(json_encode($query_price), TRUE));
						$price = trim($mfa_price[ 'product_price' ]);
						$sprice = trim($mfa_price[ 'product_sprice' ]);
						if(trim($sprice) != ''){
							$price = $sprice;
							$is_Special = 1;
							$is_Special_Text = "<div class='special_text'>".'$'.number_format(trim($mfa_price[ 'product_price' ]), 2)."</div>";
						}
						$bundle_unit_price += $price*$qty;
					}
				}
			}
		}
		
		return $bundle_unit_price;
	}
	
	public function getTax(){
		return $this->tax_class;
	}
	
	public function getInputType(){
		return $this->input_type;
	}
	
	public function getSortType(){
		return $this->sort_type;
	}
	
	public function getState(){
		return $this->states;
	}
	
	public function getTaxRuleInfo($arrArgument){
		
		$WHERE = '';
		if(isset($arrArgument[ 'where' ])){
			$WHERE = 'where '.$arrArgument[ 'where' ];
		}
		$sql = "SELECT  
				a.tri_id,a.tri_name,a.tri_priority,a.tri_sort,a.tri_date,
        		GROUP_CONCAT(DISTINCT b.tc_name ORDER BY b.tc_id  ) TaxClass,
        		GROUP_CONCAT(DISTINCT c.tr_name ORDER BY c.tr_id) TaxRate
			  FROM tax_rule_info a
        		INNER JOIN tax_class b
            	ON FIND_IN_SET(b.tc_id, a.tc_id_comma) > 0
        		INNER JOIN tax_rate c
            	ON FIND_IN_SET(c.tr_id, a.tr_id_comma) > 0
			  $WHERE
			  GROUP BY a.tri_id";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		$rows = count($query);
		if($rows > 0){
			return $query;
		}
	}
	
	public function feature_products(){
		
	}
	
	public function getTagProduct($arrArgument){
		
		$array = [];
		$where = $arrArgument[ 'where' ];
		$startpoint = $arrArgument[ 'startpoint' ];
		$attribute_join = $arrArgument[ 'attribute_join' ];
		//$attribute_item_join_paging = $arrArgument[ 'attribute_item_join_paging' ];
		$limit = $arrArgument[ 'limit' ];
		$page = $arrArgument[ 'page' ];
		
		//	$query="select * from product where $where LIMIT $startpoint, $limit";
		$query = "SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id $attribute_join where $where group by product.product_id LIMIT $startpoint, $limit";
		
		$res = json_decode(json_encode(DB::select($query)), TRUE);
		$checkData = count($res);
		$arrProduct = [];
		if($checkData > 0){
			$arrProduct = $res;
		}
		
		$url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		$exp = explode('&', $url);
		$url_new = '';
		foreach($exp as $value){
			if(strpos($value, 'page') !== FALSE){
				echo ' ';
			}else{
				$url_new .= trim($value).'&';
			}
		}
		
		# echo $url.' binary';exit; 
		//	$query="select count(*) as num from product where $where";
		$query = "SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id $attribute_join where $where group by product.product_id";
		
		$arrPaging = self::pagination($query, $limit, $page, $url_new);
		
		$array[ 'product' ] = $arrProduct;
		$array[ 'paging' ] = $arrPaging;
		return $array;
	}
	
	public function pagination($query, $per_page, $page, $url){
		
		$query = "{$query}";
		$limit10 = $limit25 = $limit50 = $limit100 = '';
		
		$row = (json_decode(json_encode(DB::select($query)), TRUE));
		
		$total = count($row);
		$adjacents = "2";
		$page = ($page == 0 ? 1 : $page);
		
		$start = ($page-1)*$per_page;
		
		$firstPage = 1;
		$prev = ($page == 1) ? 1 : $page-1;
		
		$prev = $page-1;
		$next = $page+1;
		$lastpage = ceil($total/$per_page);
		$lpm1 = $lastpage-1;
		
		$pagination = "";
		if($lastpage > 1){
			
			if($page == 1){
				$pagination .= '<div class="pnext"> <img src="images/pnext.png" class=" " /></div>';
				$pagination .= '<div class="pageno">';
			}else{
				$pagination .= '<div class="pnext"><a href="'.$url.'page='.$prev.'"><img src="images/pnext.png" class=" " /></a></div>';
				$pagination .= '<div class="pageno">';
			}
			
			if($lastpage < 7+($adjacents*2)){
				for($counter = 1 ; $counter <= $lastpage ; $counter++){
					if($counter == $page) $pagination .= '<a class="pagesel">'.$counter.'</a>';//	$pagination.= "<li><a class='current'>$counter</a></li>";
					else
						$pagination .= '<a href="'.$url.'page='.$counter.'">'.$counter.'</a>';
				}
			}elseif($lastpage > 5+($adjacents*2)){
				if($page < 1+($adjacents*2)){
					for($counter = 1 ; $counter < 4+($adjacents*2) ; $counter++){
						if($counter == $page) $pagination .= '<a class="pagesel">'.$counter.'</a>';else
							$pagination .= '<a href="'.$url.'page='.$counter.'">'.$counter.'</a>';
					}
					$pagination .= "<a class='dot'>...</a>";
					$pagination .= "<a href='{$url}page=$lpm1'>$lpm1</a>";
					$pagination .= "<a href='{$url}page=$lastpage'>$lastpage</a>";
				}elseif($lastpage-($adjacents*2) > $page && $page > ($adjacents*2)){
					$pagination .= "<a href='{$url}page=1'>1</a>";
					$pagination .= "<a href='{$url}page=2'>2</a>";
					$pagination .= "<a class='dot'>...</a>";
					for($counter = $page-$adjacents ; $counter <= $page+$adjacents ; $counter++){
						if($counter == $page) $pagination .= '<a class="pagesel">'.$counter.'</a>';else
							$pagination .= '<a href="'.$url.'page='.$counter.'">'.$counter.'</a>';
					}
					$pagination .= "<a class='dot'>..</a>";
					$pagination .= "<a href='{$url}page=$lpm1'>$lpm1</a>";
					$pagination .= "<a href='{$url}page=$lastpage'>$lastpage</a>";
				}else{
					$pagination .= "<a href='{$url}page=1'>1</a>";
					$pagination .= "<a href='{$url}page=2'>2</a>";
					$pagination .= "<a class='dot'>..</a>";
					for($counter = $lastpage-(2+($adjacents*2)) ; $counter <= $lastpage ; $counter++){
						if($counter == $page) $pagination .= '<a class="pagesel">'.$counter.'</a>';else
							$pagination .= '<a href="'.$url.'page='.$counter.'">'.$counter.'</a>';
					}
				}
			}
			
			if($page < $counter-1){
				$pagination .= "</div><a href='{$url}page=$next' class='pprev'><img src='images/pprev.png' class='' /></a>";
			}else{
				$pagination .= "</div><a class='current pprev'><img src='images/pprev.png' class='' /></a>";
			}
			$pagination .= "\n";
			
			if($per_page == 10){
				$limit10 = 'selected="selected"';
			}
			
			if($per_page == 25){
				$limit25 = 'selected="selected"';
			}
			
			if($per_page == 50){
				$limit50 = 'selected="selected"';
			}
			
			if($per_page == 100){
				$limit100 = 'selected="selected"';
			}
			
			$pagination .= '<div class="col-lg-4" style="float: right;">
					<div class="2" style="float:right;"><div class="itemperpage"><label>Items per page:</label>
					<select class="iperpage" onchange="apply_limit(this.value);">
					<option value="10" '.$limit10.'>10</option>
					<option value="25" '.$limit25.'>25</option>
					<option value="50" '.$limit50.'>50</option>
					<option value="100" '.$limit100.'>100</option>
					</select></div></div></div>';
		}
		
		return $pagination;
	}
	
	public function bundle_product($id){
		
		$sql = "SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id inner join bundle_product_bridge on product.product_id=bundle_product_bridge.product_id where bundle_product_bridge.bp_id=".$id." group by product.product_id";
		
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		
		$rows = count($query);
		
		$array_return = [];
		
		if($rows > 0){
			
			return $query;
		}
		
		return 0;
	}
	
	public function clean($string){
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
	
	public static function instance(){
		return new Helper();
	}
	
}

