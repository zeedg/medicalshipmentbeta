<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;
use Validator;
use App\reviews;

use DB;

class ReviewController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		//$reviews = reviews::orderBy('rew_id','asc')->paginate('15');
		
		/*$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate('15');*/
		
		$arrArgument['join']='INNER JOIN';
	  	$arrArgument['where']='';
		$reviews = Helper::instance()->joinUserProductReview($arrArgument);
		
		return view('listReviews', ['reviews' => $reviews]);
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
		
		
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		
		$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'review.rew_comment', 'user.user_email', 'review.rew_date')->where('review.rew_id', $id)->get();
		
		/*echo '<pre>';
		print_r($reviews); 
		exit();*/
		
		return view('editReviews', ['reviews' => $reviews]);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request){
		
		$validator = Validator::make($request->all(), [
		 
		 'rew_comment' => 'required|max:500',
		 'rew_status'  => 'required|max:5',
		 'rew_rating'  => 'integer|required|max:100',
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$id = $request->input('rew_id');
		
		$reviews = reviews::find($id);
		
		$reviews->rew_comment = $request->input('rew_comment');
		$reviews->rew_status = $request->input('rew_status');
		$reviews->rew_rating = $request->input('rew_rating');
		$reviews->save();
		return redirect('/review')->with('review_update', 'Review Updated');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		//
		
		$review = reviews::find($id);
		$review->delete();
		
		// redirect
		// Session::flash('message', 'Successfully deleted the review!');
		//return Redirect::to('review');
		return Redirect::to('review')->with('message', 'Login Failed');
		//Redirect::route('review');
	}
	
	public function filter(Request $request){
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				
				//$products = products::orderBy('product_id','asc')->paginate('15');
				$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')//->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')
				->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate("$selected_option");
				return view('listReviews', ['reviews' => $reviews]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				
				$pg = (isset($op_select)) ? $op_select : '15';
				
				$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')//->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')
				->where('user.user_email', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate("$pg");
				return view('listReviews', ['reviews' => $reviews]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$billshipaddress = billshipaddress::orderBy('bsa_id', 'asc')->paginate($pg);
				//echo "first sec".$pg."---".$keyword; exit();
				return view('billshipaddress')->with('billshipaddress', $billshipaddress);
			}else if(isset($keyword) && !isset($pg)){
				$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')//->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')
				->where('user.user_email', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate("15");
				return view('listReviews', ['reviews' => $reviews]);
			}else if(isset($pg) && isset($keyword)){
				
				$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')//->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')
				->where('user.user_email', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate("$pg");
				return view('listReviews', ['reviews' => $reviews]);
			}else{
				$reviews = DB::table('review')->leftjoin('product', 'review.product_id', '=', 'product.product_id')->leftjoin('user', 'review.user_id', '=', 'user.user_id')//->join('product_type', 'product.pt_id', '=', 'product_type.pt_id')
				->where('user.user_email', 'like', '%'.$keyword.'%')->orWhere('product.product_title', 'like', '%'.$keyword.'%')->select('review.rew_id', 'review.user_id', 'review.product_id', 'product.product_title', 'product.product_item_no', 'review.rew_rating', 'review.rew_status', 'user.user_email', 'review.rew_date')->orderBy('review.rew_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('listReviews', ['reviews' => $reviews]);
			}
		}
	}
}
