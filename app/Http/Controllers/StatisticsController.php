<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\statistics;

class StatisticsController extends Controller
{
    //
	public function index() {
		
		$arrValue['account'] = DB::select('select count(*) as total from user order by user_id DESC');
		$arrValue['users-order'] = DB::select('SELECT count(*) as total_user FROM `orders` group by user_id');
		$arrValue['highest-amount'] = DB::select('SELECT u.*, o.* FROM `orders` o inner join user u on o.user_id=u.user_id order by o.order_grand_total desc limit 1');
		$arrValue['frequently-order'] = DB::select('SELECT u.*, o.* FROM `orders` o inner join user u on o.user_id=u.user_id order by o.order_id desc limit 1');
		
		//REQUESTED CATALOG
		$catalog1 = date('Y-m-d');
		$arrValue['requested-catalog1'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date= '".$catalog1."' and catalog_type='Request Catalog'");
		$catalog7 = date('Y-m-d', strtotime('-1 week'));
		$arrValue['requested-catalog7'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog7."' and catalog_type='Request Catalog'");
		$catalog30 = date('Y-m-d', strtotime('-1 month'));
		$arrValue['requested-catalog30'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog30."' and catalog_type='Request Catalog'");
		$catalog90 = date('Y-m-d', strtotime('-3 month'));
		$arrValue['requested-catalog90'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog90."' and catalog_type='Request Catalog'");
		$catalog180 = date('Y-m-d', strtotime('-6 month'));
		$arrValue['requested-catalog180'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog180."' and catalog_type='Request Catalog'");
		$catalog365 = date('Y-m-d', strtotime('-12 month')); 
		$arrValue['requested-catalog365'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog365."' and catalog_type='Request Catalog'");
		
		//VIRTUAL CATALOG
		$catalog1 = date('Y-m-d');
		$arrValue['virtual-catalog1'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date= '".$catalog1."' and catalog_type='Virtual Catalog'");
		$catalog7 = date('Y-m-d', strtotime('-1 week'));
		$arrValue['virtual-catalog7'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog7."' and catalog_type='Virtual Catalog'");
		$catalog30 = date('Y-m-d', strtotime('-1 month'));
		$arrValue['virtual-catalog30'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog30."' and catalog_type='Virtual Catalog'");
		$catalog90 = date('Y-m-d', strtotime('-3 month'));
		$arrValue['virtual-catalog90'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog90."' and catalog_type='Virtual Catalog'");
		$catalog180 = date('Y-m-d', strtotime('-6 month'));
		$arrValue['virtual-catalog180'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog180."' and catalog_type='Virtual Catalog'");
		$catalog365 = date('Y-m-d', strtotime('-12 month')); 
		$arrValue['virtual-catalog365'] = DB::select("SELECT count(*) as tot FROM trace_catalog where date >= '".$catalog365."' and catalog_type='Virtual Catalog'");
		
		$arrValue['biggest-seller'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales FROM product p inner join order_detail od on p.product_id=od.product_id group by od.product_id order by sales desc limit 10");
		
		//$arrValue['list-all-items'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales FROM product p left join order_detail od on p.product_id=od.product_id group by p.product_id order by sales desc");
		//$arrValue['list-all-items'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales FROM product p left join order_detail od on p.product_id=od.product_id group by p.product_id order by sales desc");
		
		$arrValue['list_all_items'] = DB::table('product')
        ->leftjoin('order_detail', 'product.product_id', '=', 'order_detail.product_id')
        ->select('product.*')
		->groupBy('product.product_id')
		//->orderBy('sales','desc')
        ->paginate(20);

		
		
		$arrValue['customers-statewise'] = DB::select("select count(bsa.bsa_state) as fromstate, bsa.bsa_state from user u inner join bill_ship_address bsa on u.user_id=bsa.user_id group by bsa.bsa_state order by fromstate desc limit 10");
		
		return view('statistics',['arrValue'=>$arrValue]);
   
   }


	public function order_report() {
		
		//REQUESTED CATALOG
		$order_report7 = date('Y-m-d', strtotime('-1 week'));
		$arrValue['order_report7'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales, o.order_date FROM product p inner join order_detail od on p.product_id=od.product_id JOIN orders o on od.order_id = o.order_id WHERE ".$order_report7." group by od.product_id order by sales desc limit 20");
		$order_report30 = date('Y-m-d', strtotime('-1 month'));
		$arrValue['order_report30'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales, o.order_date FROM product p inner join order_detail od on p.product_id=od.product_id JOIN orders o on od.order_id = o.order_id WHERE ".$order_report7." group by od.product_id order by sales desc limit 20");
		$order_report90 = date('Y-m-d', strtotime('-3 month'));
		$arrValue['order_report90'] = DB::select("SELECT p.*, sum(od.product_quantity) as sales, o.order_date FROM product p inner join order_detail od on p.product_id=od.product_id JOIN orders o on od.order_id = o.order_id WHERE ".$order_report7." group by od.product_id order by sales desc limit 20");
		
		return view('order_report',['arrValue'=>$arrValue]);
   
   }

	public function visitor_stats() {
		
		//REQUESTED CATALOG
		$visitor_stats = date('Y-m-d');
		$arrValue['visitor_stats1'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		
		$visitor_stats7 = date('Y-m-d', strtotime('-1 week'));
		$arrValue['visitor_stats7'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats7."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		
		$visitor_stats30 = date('Y-m-d', strtotime('-1 month'));
		$arrValue['visitor_stats30'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats30."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		$visitor_stats90 = date('Y-m-d', strtotime('-3 month'));
		$arrValue['visitor_stats90'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats90."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		$visitor_stats180 = date('Y-m-d', strtotime('-6 month'));
		$arrValue['visitor_stats180'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats180."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		$visitor_stats365 = date('Y-m-d', strtotime('-12 month')); 
		$arrValue['visitor_stats365'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.visit_date >= '".$visitor_stats365."' and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' group by u.user_id ORDER BY v.id DESC");
		
		return view('visitor_stats',['arrValue'=>$arrValue]);
   
   }
    
    public function visitor_stats_listing($user_id,$ip_address){
		if(isset($user_id) && isset($ip_address)){
			
			$uid=trim($user_id);
			$ip=trim($ip_address);
			
			//if($uid!=''){
			if($uid == 0){
				$arrValue['stats'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email FROM visitor_stats v LEFT JOIN user u on v.user_id = u.user_id where v.user_id=$uid and v.page_title!='' and v.page_url NOT LIKE '%count(*)%' ORDER BY v.id DESC");
			} else {
				$arrValue['stats'] = DB::select("SELECT * FROM visitor_stats where ip_address='".$ip."' and page_title!='' and page_url NOT LIKE '%count(*)%' ORDER BY id DESC");
			}
			
			return view('visitor_stats_listing',['arrValue'=>$arrValue]);
			
		}  
	}
	 
	 public function visitor_carts_listing($user_id){
		if(isset($user_id)){
			
			$uid=trim($user_id);
			
			$arrValue['cart_stats'] = DB::select("SELECT v.*, u.user_id, u.user_fname, u.user_lname, u.user_email, p.* FROM visitor_cart_stats v LEFT JOIN user u on v.user_id = u.user_id LEFT JOIN product p on v.product_id=p.product_id where v.user_id=$uid ORDER BY v.id DESC");
			
			return view('visitor_cart_listing',['arrValue'=>$arrValue]);
			
		}  
	}
    	   
   public static function nthLevelCategory($id){
			
		$sql = DB::select("select * from category where category_id=$id");		
		$nthCategory2 = '';
		
		if(count($sql)){
			$c = 0;
			foreach($sql as $mfa){
				$c++;
			if(is_numeric($mfa->category_id)){
				return $nthCategory2 = $mfa->category_title. ' >> ' . implode('  >> ' , self::navChilds($mfa->category_parent));
				
				//return self::nthLevelCategory($mfa->category_parent);
			} else {
				return $nthCategory;
			}
		}
			}else{
				return false;
				}
		
		
	}
   
   public static function navChilds($id){
	   
	   
	   $sql = DB::select("select * from category where category_id=$id");
	   
	  if(count($sql)){
		  $pusher = [];
		  foreach($sql as $r){
			  $pusher[] = $r->category_title;
			  }
			  return $pusher;
		  }else{
			  return [];}
	   }
   
   public function piechart(){
	$onday_piechart = DB::table('orders')
	   		->where('order_date', '=', date('Y-m-d'))
   		 	->sum('order_grand_total');

   	$oneweek_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 week")))
   		 	->sum('order_grand_total');

   	$onemonth_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 month")))
   		 	->sum('order_grand_total');

   	$threemonths_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-3 month")))
   		 	->sum('order_grand_total');

   	$sixmonths_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-6 month")))
   		 	->sum('order_grand_total');
   	$oneyear_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 year")))
   		 	->sum('order_grand_total');


	return view('piechart',['oneweek_piechart' => $oneweek_piechart,'onday_piechart' => $onday_piechart, 'onemonth_piechart' => $onemonth_piechart, 'threemonths_piechart' => $threemonths_piechart,'sixmonths_piechart' => $sixmonths_piechart,'oneyear_piechart' => $oneyear_piechart]);
	}

	public function barchart(){

		$onday_piechart = DB::table('orders')
	   		->where('order_date', '=', date('Y-m-d'))
   		 	->sum('order_grand_total');

   	$oneweek_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 week")))
   		 	->sum('order_grand_total');

   	$onemonth_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 month")))
   		 	->sum('order_grand_total');

   	$threemonths_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-3 month")))
   		 	->sum('order_grand_total');

   	$sixmonths_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-6 month")))
   		 	->sum('order_grand_total');
   	$oneyear_piechart = DB::table('orders')
	   		 ->where('order_date', '>=', date('Y-m-d', strtotime("-1 year")))
   		 	->sum('order_grand_total');

   	return view('barchart',['oneweek_piechart' => $oneweek_piechart,'onday_piechart' => $onday_piechart, 'onemonth_piechart' => $onemonth_piechart, 'threemonths_piechart' => $threemonths_piechart,'sixmonths_piechart' => $sixmonths_piechart,'oneyear_piechart' => $oneyear_piechart]);

	}
   
   /*public static function nthLevelCategory($id){
			
		$sql = DB::select("select * from category where category_id=$id");		
		
		foreach($sql as $mfa){
			if($mfa->category_id){
				nthCategory[].=$mfa->category_title;
				return nthLevelCategory($mfa->category_parent);
			} else {
				return nthCategory;
			}
		}
		
	}*/
   
  public function addkeyword() {
	  $categories = DB::select("select * from category where category_parent=0 and category_id != 67 order by category_title asc");
	  return view('addkeyword',['categories'=>$categories]);
  }
  
  public function store(Request $request){
		
		if(!empty($request->input('keyword')) && !empty($request->input('categories'))) {
			$keyword = $request->input('keyword');
			$categories = $request->input('categories');		
			$categories_list = implode (",", $categories);
			$date = date('Y-m-d');
			
			$result = DB::insert("insert into search_keywords(keyword,categories,date_added) values(?, ?, ?)",[$keyword,$categories_list,$date]);
		}
		return redirect()->to('view-keyword');
		
    }
  
  	public function show($id) {
      $keywords = DB::select('select * from search_keywords where id = ?',[$id]);
      return view('keyword_update',['keywords'=>$keywords]);
   }
  
  	public function edit(Request $request,$id) {
		
		if(!empty($request->input('keyword')) && !empty($request->input('categories'))) {	
			$keyword = $request->input('keyword');
			$categories = $request->input('categories');
			$categories_list = implode (",", $categories);
			$date = date('Y-m-d');	
			
			DB::update('update search_keywords set keyword = ?, categories = ?, date_added = ? where id = ?',[$keyword,$categories_list,$date,$id]);
		}
		return redirect()->to('view-keyword');
			
	}
  
  	public function destroy($id)
	{
		 DB::table('search_keywords')->where('id', '=', $id)->delete();
		 return redirect()->to('view-keyword');
	}
	
	
}
