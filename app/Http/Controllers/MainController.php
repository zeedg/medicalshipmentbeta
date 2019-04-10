<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use App\statistics;

class MainController extends Controller
{
    
	public $nthCategory;
	public function __constructor(){
		$this->nthCategory = array();
	}
	
	function index(){
		return view('login');
	}
	
	function checklogin(Request $request){
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|alphaNum|min:3',
		]);
		
		$user_data = array(
			'email' => $request->get('email'),
			'password' => $request->get('password')
		);
		
		if(Auth::attempt($user_data))
		{
			return redirect('main/successlogin');
		}
		else
		{
			return back()->with('error', 'Wrong Login Details');
		}
	}
	
	function successlogin(){
		
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
		//return view('successlogin',['arrValue'=>$arrValue]);
	}
	
	function logout()
	{
		Auth::logout();
		return redirect('main');
	}
	
}
