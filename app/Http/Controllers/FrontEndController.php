<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontEndController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$slider = DB::select('select * from slider');
		
		$featured = DB::select('select p.*,pi.*,up.*,u.* from product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id where p.product_featured=1 and p.pt_id=1 order by rand() limit 12');
		
		$new = DB::select('select p.*,pi.*,up.*,u.* from product p left join product_image pi on p.product_id=pi.product_id left join unit_product up on p.product_id=up.product_id left join unit u on u.unit_id=up.unit_id where p.product_featured=1 and p.pt_id=1 group by p.product_id order by p.product_id desc limit 12');
		
		$categories = DB::table('category')->get();
		
		return view('frontwebsite.index', compact('slider', 'featured', 'new', 'categories'));
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
	
	public function detailpage($id){
		$categories = DB::table('category')->get();
		
		$bestSeller = DB::table("best_seller")->first();
		
		$bsp = (Array) DB::select("SELECT * FROM product inner join product_image on product.product_id=product_image.product_id inner join unit_product on  product.product_id=unit_product.product_id where product.product_item_no IN (".$bestSeller->bs_product.") group by product.product_id order by rand() limit 3");
		
		$product = (Array) DB::select("select p.*,pi.*,u.*,up.* from product p left join product_image pi on p.product_id=pi.product_id INNER JOIN unit_product up on p.product_id=up.product_id INNER JOIN unit u on up.unit_id=u.unit_id where p.product_id=".($id)." order by pi.pi_id DESC limit 1");
		
		$unit = (Array) DB::select("select u.*, up.*, p.product_id from product p INNER JOIN unit_product up on p.product_id=up.product_id INNER JOIN unit u on u.unit_id=up.unit_id where p.product_id= ".($id)." order by u.unit_title ASC");
		
		$review = (Array) DB::select("select u.*, p.product_id, p.product_title, p.product_item_no, r.* from user u INNER JOIN review r on u.user_id=r.user_id INNER JOIN product p on r.product_id=p.product_id where p.product_id= ".($id)." AND r.rew_status=1 order by r.rew_id DESC");
		
		$group_product = (Array) DB::select("select p.*,pi.*,u.*,up.* from product p inner join product_image pi on p.product_id=pi.product_id inner join unit_product up on p.product_id=up.product_id inner join unit u on up.unit_id=u.unit_id inner join group_product g on p.product_id=g.product_id_group where g.product_id=".$id." group by p.product_id order by p.product_id ASC");
		
		$arrArgument['table']= 'wishlist';		
		$where=array('user_id'=>session()->get('user_id'));
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='wishlist_name desc';		
		$wishlists=json_decode(json_encode(self::getRecord($arrArgument)));
		
		//		dd(compact('bsp', 'product', 'unit', 'review' , 'group_product'));
		return view('frontwebsite.detail', compact('bsp', 'product', 'unit', 'review', 'group_product', 'categories', 'wishlists'));
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
		//$array_return = [];
		$array_return = DB::select($sql);
		if(count($rows) > 0){
			return $array_return;
		}else{
			return $array_return;
		}
	}
	
	public function category($id){
	  
	  $fullUrl = request()->fullUrl();
	  /*$slugs = explode ("/", request()->fullUrl());
 	  $id2 = $slugs [(count ($slugs) - 2)];
	  $to_price = $slugs [(count ($slugs) - 3)];
	  if(is_numeric($to_price)){
		  $id = $id2;
		  $_GET['id'] = $id;
		  $from_price = $slugs [(count ($slugs) - 2)];
		  $_GET['from_price'] = $from_price;
		  $to_price = $slugs [(count ($slugs) - 3)];
		  $_GET['to_price'] = $to_price;
	  } else if(is_numeric($id2)){
		  $id = $id2;
		  $_GET['id'] = $id;
		  $price = $slugs [(count ($slugs) - 1)];
	  	  $_GET['price'] = $price;
	  }*/
	  
	  $id2 = explode ("/", request()->fullUrl());
	  if(is_numeric($id2)){
	  	$id = $id2;
		$_GET['id'] = $id;
	  }
	  
	  if(strpos($fullUrl, 'price') !== false) {
	  	$slugs = explode ("&price=", request()->fullUrl());
		$slugs2 = explode ("/", $slugs[1]);
 	  	$_GET['price'] = $slugs2[0];
	  }
	  
	  if(strpos($fullUrl, 'fromto') !== false) {
	  	$slugs = explode ("&fromto=", request()->fullUrl());
 	  	$slugs2 = explode ("/", $slugs[1]);
		$slugs3 = explode ("-", $slugs2[0]);
		$_GET['from_price'] = $slugs3[0];
		$_GET['to_price'] = $slugs3[1];
	  }
	  
	  if(strpos($fullUrl, 'attribute') !== false) {
	  	$slugs = explode ("&attribute=", request()->fullUrl());
 	  	$slugs2 = explode ("/", $slugs[1]);
		$_GET['attribute'] = $slugs2[0];
	  }
	  
	  if(strpos($fullUrl, 'match') !== false) {
	  	$slugs = explode ("&match=", request()->fullUrl());
 	  	$slugs2 = explode ("/", $slugs[1]);
		$_GET['match'] = $slugs2[0];
	  }
	  
	  
	  if(isset($_GET['keyword']) and $id=='all')
	  {
		  $get_cate = mysql_query("SELECT * FROM category WHERE category_title = '".$_GET['keyword']."'");
		  if(mysql_num_rows($get_cate) > 0)
		  {
			  $cate = mysql_fetch_array($get_cate);
			  $url="'".SITE_PATH.'index.php?controller=category&function=index&id='.$cate['category_id']."'";
			  echo "<script>window.location=$url</script>";
		  }
	  }	  
	  
	  if(isset($id) and $id=='all'){
		$id=0;
	  } else {
	  	$id=filter_var(trim($id), FILTER_VALIDATE_INT);
	  }
	  
	  # Get Category
	  $categoryDetail = json_decode(json_encode(DB::select("select * from category WHERE category_id='".($id)."' order by category_id ASC")), TRUE);
	  
	  # Get Sub Categories
	  $categoryArray = json_decode(json_encode(DB::select("select * from category WHERE category_parent='".($id)."'  order by category_title ASC ")), TRUE);
	  
	  # Get Product Detail
	  $product = json_decode(json_encode(DB::select("SELECT * FROM product left join product_image on product.product_id=product_image.product_id inner join unit_product on product.product_id=unit_product.product_id  where product.category_id=".($id)."    group by product.product_id   order by product.product_sort_order  LIMIT 0, 100 ")), TRUE);
	  
	  # Get Unit Prices
	  $unit = json_decode(json_encode(DB::select("select u.*, up.*, p.product_id from product p INNER JOIN unit_product up on p.product_id=up.product_id INNER JOIN unit u on u.unit_id=up.unit_id  order by u.unit_title ASC ")), TRUE);
	  
	  //check this manucturer variable data
	  $manufacturer = json_decode(json_encode(DB::select("select * from manufacturer   order by manu_id ASC limit 7")), TRUE);
	  
	  
	  # Get All Product Reviews
			$page=(int)(!isset($_GET["page"])?1:$_GET["page"]);
	  		if(isset($_GET['limit']))
			{ 
				$limit = $_GET['limit']; 
			} 
			else{ 
			$limit=10; 
			}
	  		$startpoint=($page*$limit)-$limit;
			
			$catalog="product.category_id=$id";
			if($id==0)
			{
				$catalog="";
			}
			else
			{
				/************  Get sub categories ID from parent category   **************/
				if(@$_GET['attribute'])
				{
					//$chk_sub = mysql_query("SELECT * FROM category WHERE category_parent = ".$id);
					$chk_sub = json_decode(json_encode(DB::select("SELECT * FROM category WHERE category_parent = ".$id)), TRUE);
					if(count($chk_sub) > 0)     // If category have sub categories
					{
						$catalog = '('.$catalog;
						//while($sub_cate = mysql_fetch_array($chk_sub))
						foreach($chk_sub as $sub_cate)
						{
							$catalog.= " or product.category_id=".$sub_cate['category_id'];
						}
						$catalog = $catalog.')';
					}
				}
			}
			
			$keyword="";
			if(isset($_GET['keyword'])){
				$keyword=trim(mysql_real_escape_string(urldecode($_GET['keyword'])));
				if(substr($keyword, -1) == 's')
				{
					$keyword1 = substr($keyword,0, -1);
				}
				elseif(substr($keyword, -2) == 'es')
				{
					$keyword1 = substr($keyword,0, -2);
				}
				else
				{
					$keyword1 = $keyword.'s';
				}
				if($catalog!=""){
					$keyword=' and (product.product_title LIKE "%'.$keyword.'%" OR product.product_title LIKE "%'.$keyword1.'%" OR product.product_item_no LIKE "%'.$keyword.'%")';
				}
				else{
					$keyword='(product.product_title LIKE "%'.$keyword.'%" OR product.product_title LIKE "%'.$keyword1.'%" OR product.product_item_no LIKE "%'.$keyword.'%")';
				}
			
			}
			
			$filter = "";
			$order = '  order by product.product_sort_order ';
			
			
			if(isset($_GET['from_price'])){
				if($_GET['from_price'] == ''){
					$from_price = 0.00;
				} else {
					$from_price = $_GET['from_price'];
				}
				
				if($_GET['to_price'] == ''){
					$to_price = 100000.00;
				} else {
					$to_price = $_GET['to_price'];
				}
				$filter = " and (unit_product.product_price >= ".$from_price." and unit_product.product_price <= ".$to_price.")";
				$order = '  order by unit_product.product_price asc';
			}
				
		//  Price Select options	
			if(isset($_GET['price'])){
				
				if($_GET['price'] == 'price05'){
					$from = 0;
					$to = 5;
				}
				elseif($_GET['price'] == 'price510'){
					$from = 5;
					$to = 10;
				}
				elseif($_GET['price'] == 'price1020'){
					$from = 10;
					$to = 20;
				}
				elseif($_GET['price'] == 'price20100'){
					$from = 20;
					$to = 100;
				}
				elseif($_GET['price'] == 'price100'){
					$from = 100;
					$to = 50000;
				}
				$filter .= " and (unit_product.product_price >= ".$from." and unit_product.product_price <= ".$to.")";
			}	
			
		//  Size Select options	
			if(isset($_GET['size'])){
				
				$filter .= ' and product.product_title LIKE "%'.$_GET['size'].'%"';
			}
		
		//  Meterial Select options	
			if(isset($_GET['meterial'])){
				
				$filter .= ' and product.product_title LIKE "%'.$_GET['meterial'].'%"';
			}
		
		//  Special Offer Select options	
			if(isset($_GET['special_offer'])){
				
				if($_GET['special_offer'] == 'sprice'){
				$filter .= ' and unit_product.product_sprice > 0';
				}
			}
		
		//  Top Brand Select options	
			if(isset($_GET['brand'])){
				
				$filter .= ' and product.manu_id ='.$_GET['brand'];
				
			}
		
		//  Best Match Select options	
			if(isset($_GET['match'])){
				
				if($_GET['match'] == 'best_seller'){
				$order = '  order by rand()';
				}
				
				if($_GET['match'] == 'low_to_high'){
				$order = '  order by unit_product.product_price*1 ';
				}
				
				if($_GET['match'] == 'high_to_low'){
				$order = '  order by unit_product.product_price*1 desc ';
				}
				
			}
			
			
			
	$attribute_join="";
	$attribute_condition="";
	if(isset($_GET['attribute'])){
		$attribute_count = 0;
		$selected_attribute_items=$this->getSelectedAttributeCombination(trim($_GET['attribute']));
		$attribute_set = array();
		foreach($selected_attribute_items as $items){
			$item = explode("_",$items);
			if (in_array($item[0], $attribute_set))
			{
				$attr_val = "attribute_combination$item[0]";
				$$attr_val.=" or pi".$item[0].".attribute_item_id=".$item[1];
			}
			else
			{
				array_push($attribute_set, $item[0]);	
				$attr_val = "attribute_combination$item[0]";
				$$attr_val=" join product_item pi".$item[0]." on product.product_id=pi".$item[0].".product_id AND (pi".$item[0].".attribute_item_id=".$item[1];					
			}
			$attribute_count++;
		}
		foreach ($attribute_set as $attr_val)
		{
			$attribute_val = "attribute_combination$attr_val";
			$attribute_join.= $$attribute_val.')';
		}
		
		if($attribute_condition!=''){
			$attribute_condition=rtrim($attribute_condition, 'AND ');
			$attribute_condition="AND (".$attribute_condition.")";
		}
		
	}
	
	$sql="SELECT * FROM product left join product_image on product.product_id=product_image.product_id inner join unit_product on product.product_id=unit_product.product_id $attribute_join where $catalog $keyword $filter $attribute_condition group by product.product_id $order LIMIT $startpoint, $limit";
	
	$gc="";
	if(isset($_GET['attribute'])){
		$sql_="SELECT group_concat(distinct product.product_id) as gc FROM product left join product_image on product.product_id=product_image.product_id inner join unit_product on product.product_id=unit_product.product_id $attribute_join where $catalog $keyword $filter $attribute_condition";
		
		//$mfa_=mysql_fetch_assoc(mysql_query($sql_));
		$mfa_2 = json_decode(json_encode(DB::select($sql_)), TRUE);
		$mfa_ = reset($mfa_2);
		if($mfa_['gc'] != ''){
			$gc=" AND p.product_id in(".$mfa_['gc'].")";
		} else {
			$gc='';
		}
	}
	   
	$query = json_decode(json_encode(DB::select($sql)), TRUE);
	$rows=count($query);
	$array_return=array();
	if($rows>0){
		foreach($query as $mfa){
			  $array_return[]=$mfa;
		}
	}
	
	//$arrValue['product']=$array_return;
	$product=$array_return;
	
	if($id == 0){
		$where=$keyword.$filter;
	}
	else{
		$where='product.category_id='.$id;
				/************  Get sub categories ID from parent category   **************/
				if(@$_GET['attribute'])
				{
					//$chk_sub = mysql_query("SELECT * FROM category WHERE category_parent = ".$id);
					$chk_sub = json_decode(json_encode(DB::select("SELECT * FROM category WHERE category_parent = ".$id)), TRUE);
					if(count($chk_sub) > 0)     // If category have sub categories
					{
						$where = '('.$where;
						while($sub_cate = mysql_fetch_array($chk_sub))
						foreach($chk_sub as $sub_cate)
						{
							$where.= " or product.category_id=".$sub_cate['category_id'];
						}
						$where = $where.')';
					}
				}
		$where=$where.$keyword.$filter;
	}
	$where=$where.'  '.$attribute_condition;
	$arrArgument['where']=$where;
	//echo '<br>   Where='.$where.'<br>  Join==='.$attribute_join.'<br>';
	//$arrArgument['attribute_item_join_paging']=$attribute_join;
    $arrArgument=array('page'=>$page, 'startpoint'=>$startpoint, 'limit'=>$limit, 'where'=>$where, 'attribute_join'=>$attribute_join);
	# Get Tag Product
	//$arrValue['binary']=Helper::instance()->getTagProduct($arrArgument);  
	  $binaries=Helper::instance()->getTagProduct($arrArgument);
	  
	  # Get Category Title
	  $arrArgument['table']='category';
	  $where=array('category_id'=>$id);
	  $arrArgument['where']=$where;
	  $arrArgument['operator']='';
	  $arrArgument['order']='category_id ASC';
	  //$arrValue['category']=Helper::instance()->getRecord($arrArgument);
	  $categories=Helper::instance()->getRecord($arrArgument);
	  
	  // Get user Wish List
		
		$arrArgument['table']= 'wishlist';		
		$where=array('user_id'=>session()->get('front_id'));
		$arrArgument['where']=$where;
		$arrArgument['operator']='';
		$arrArgument['order']='wishlist_name desc';		
		$wishlists=Helper::instance()->getRecord($arrArgument);
	  	  
			
			if(isset($_GET['keyword'])){
				//
			} else {
				$_GET['keyword'] = '';
			}
			
			//$keyword=urldecode($this->escape($_GET['keyword']));
			$keyword=urldecode($_GET['keyword']);
			if(isset($keyword1)){
				//
			} else {
				$keyword1 = $keyword.'s';
			}
			
			$and="";
			if($id!=0){
				$and=" AND p.category_id=".$id;
			}
			$sql_attr="select * from product p inner join product_item pas on p.product_id=pas.product_id where (p.product_title like '%".$keyword."%' OR p.product_title like '%".$keyword1."%' OR p.product_item_no like '%".$keyword."%') $and $gc order by pas.attribute_id asc";
			
			$attributes=$this->getAttribute($sql_attr);
			
			
	  # Open expendy attributes
	  if(isset($_GET['attribute'])){
			/*$arrValue['expendy_attribute']=$this->getExpendyAttribute(trim($_GET['attribute']));
			list($search_attribute, $expendy_collapse)=$this->getSelectedSearchAttribute(trim($_GET['attribute']));
			$arrValue['search_attribute']=$search_attribute;
			$arrValue['expendy_old_ids']=$expendy_collapse;*/
			$expendy_attribute=$this->getExpendyAttribute(trim($_GET['attribute']));
			list($search_attribute, $expendy_collapse)=$this->getSelectedSearchAttribute(trim($_GET['attribute']));
			$search_attribute=$search_attribute;
			$expendy_old_ids=$expendy_collapse;	
	  } else {
	  	$expendy_attribute='';
			list($search_attribute, $expendy_collapse)='';
			$search_attribute='';
			$expendy_old_ids='';
	  }
	  
	  $arrData = ['arrData'      => [
		 
		 'categoryDetail' => $categoryDetail,
		 'categoryArray'  => $categoryArray,
		 'product'        => $product,
		 'unit'           => $unit,
		 'manufacturer'   => $manufacturer,
		 'wishlists'   => $wishlists,
		 'attributes'   => $attributes,
		 'binaries'   => $binaries,
		 'categories'   => $categories,
		 'expendy_attribute'   => $expendy_attribute,
		 'search_attribute'   => $search_attribute,
		 'expendy_old_ids'   => $expendy_old_ids
		 
		],
		            'manufacturer' => $manufacturer,
					'wishlists'   => $wishlists,
					'attributes'   => $attributes,
					'binaries'   => $binaries];
		
		return view('frontwebsite.category-detail', $arrData);
	  
   }
	
	function getExpendyAttribute($attribute){
	   
	   $expendy=array();
	   $explode=explode('_', $attribute);
	   foreach($explode as $str){
		   $exp=explode('.', $str);
		   $expendy[]=$exp[0];
	   }
	   return array_unique($expendy);
		   
   }
	
	function getSelectedSearchAttribute($attribute){
	$search_attribute="<div class='search_attribute'><h2>Your Search</h2>";
	$explode=explode('_', $attribute);
	$expendy_array=array();
	foreach($explode as $str){
		
		# will use in view for expendy stuff
		$exp_=explode('.',$str);
		$expendy_array[]=array('expendy'=>$exp_[0],'attr_item'=>$exp_[1].'.'.$exp_[2]);
		
		# get whole array value before explode for searchRemove javascript function
		$searchRemove=trim($str);
		$searchRemove="onclick=searchRemove('".$searchRemove."')";
		
		$exp=explode('.', $str);
		# echo '<pre>'.print_r($exp,true).'</pre>';
		$attribute_id=$exp[1];
		$attribute_item_id=$exp[2];
		$sql="select * from attribute a left join attribute_item ai on a.attribute_id=ai.attribute_id where ai.attribute_item_id='".$attribute_item_id."'";
		//$mfa=mysql_fetch_assoc(mysql_query($sql));
		$mfa2=json_decode(json_encode(DB::select($sql)), TRUE);
		$mfa = reset($mfa2);
		$search_attribute.="<p><span $searchRemove title='Remove' class='remove_searc_attribute'>x</span><b>".trim(stripslashes($mfa['attribute_name']))."</b>: ".trim($mfa['attribute_item_name'])."</p>";
	}
	//echo $this->pre($expendy_array);
	return array($search_attribute.'</div>', $expendy_array);
}
	
	function getAttribute($sql){
		$query = json_decode(json_encode(DB::select($sql)), TRUE);
		//$query = reset($query2);
		if(count($query) > 0){
			$attribute=array();
			foreach($query as $mfa){	
				$attribute[]=$mfa;
			}
			return $this->attributeSetOccurance($attribute);
		}
	}
	
	function attributeSetOccurance($array){
		$array1=$array;
		$attr_set=array();
		
		foreach($array as $val){
			$attr_set[]=$val['attribute_id'].'-'.$val['attribute_item_id'];
		}
		$duplicate_attr_set=$attr_set;
		$unique_attr_set=array_values(array_unique($attr_set));
		return $this->getAttributeSet($duplicate_attr_set, $unique_attr_set);
	}
	function getAttributeSet($duplicate, $unique){
		$attr_set=array();
		$attr_=array();
		foreach($unique as $val){
			$count=0;
			foreach($duplicate as $val_){
				if($val==$val_){
					$count++;
				}
			}
			$exp=explode('-', $val);
			$attr=$exp[0];
			$attr_item=$exp[1];
			$total=$count;
			$attr_set[]=array('attr'=>$attr, 'attr_item'=>$attr_item, 'total'=>$total);
			$attr_[]=$attr;
		}
		$attr_=array_values(array_unique($attr_));
		return $this->getFinalAttributeSet($attr_set, $attr_);
	}
	
	function getFinalAttributeSet($array, $attr){
		$new=array();
		foreach($attr as $val){
			$info=array();
			foreach($array as $val_){
				$attr=$val_['attr'];
				$attr_item=$val_['attr_item'];
				$total=$val_['total'];
				if($val==$attr){
					$info[]=array('attr_item'=>$attr_item,'attr_item_name'=>$this->getAttributeItemTitle($attr_item),'total'=>$total);
				}
			}
			$info=$this->getSortedAttributeItem($info);
			$new[]=array('attr_id'=>$val, 'attr_name'=>$this->getAttributeTitle($val), 'detail'=>$info);
		}
		return $new;
	}
	
	function getAttributeItemTitle($attr_item_id){	
		$mfa2 = json_decode(json_encode(DB::select("select attribute_item_name from attribute_item where attribute_item_id='".$attr_item_id."'")), TRUE);
		$mfa = reset($mfa2);
		return $mfa['attribute_item_name'];
	}
	
	function getSortedAttributeItem($array){
		//usort($array, array('FrontEndController', 'compareByName'));
		return $array;
	}
	
	function getAttributeTitle($attr_id){	
		$mfa2 = json_decode(json_encode(DB::select("select attribute_name from attribute where attribute_id='".$attr_id."'")), TRUE);
		$mfa = reset($mfa2);
		return $mfa['attribute_name'];
	}
	
	private static function compareByName($a, $b){
	  return strcmp($a["attr_item_name"], $b["attr_item_name"]);
	}
	
	function getSelectedAttributeCombination($url_attribute_str){
	   $items=array();
	   $explode=explode('_', $url_attribute_str);
	   foreach($explode as $str){
		   $exp=explode('.', $str);
		   $items[]=$exp[1].'_'.$exp[2];
	   }
	   return $items;
	   
   }
	
}
