<?php

namespace App\Http\Controllers;

use Validator;
use DB;
use App\ubs;
use Illuminate\Http\Request;

class UbsController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		
		$record = Ubs::paginate(10);
		return view('ubs', compact('record'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		return view('addubs');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		
		
		$validator = Validator::make($request->all(), [
		 
		 'user_id'          => 'required|max:100',
		 'bsa_type'         => 'required|max:100',
		 'bsa_fname'        => 'required|max:100',
		 'bsa_lname'        => 'max:100',
		 'bsa_phone'        => 'max:100',
		 'bsa_zip'          => 'max:100',
		 'bsa_city'         => 'required|max:100',
		 'bsa_country'      => 'required|max:100',
		 'bsa_state'        => 'required|max:100',
		 'bsa_address'      => 'required|max:100',
		 'bsa_address_type' => 'max:100',
		 'bsa_ship_dir'     => 'required|max:100',
		 'bsa_default'      => 'max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$status = Ubs::create($request->except(['_token', '_method', 'add_ubs']));
		if($status->save()){
			//dd('store redirect');
			return redirect(action('UbsController@index'));
		}else{
			return abort(404);
		}
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
		
		$data = Ubs::where('bsa_id', $id)->firstOrFail();
		return view('addubs', compact('data'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		
		$validator = Validator::make($request->all(), [
		 
		 'user_id'          => 'required|max:100',
		 'bsa_type'         => 'required|max:100',
		 'bsa_fname'        => 'required|max:100',
		 'bsa_lname'        => 'max:100',
		 'bsa_phone'        => 'max:100',
		 'bsa_zip'          => 'max:100',
		 'bsa_city'         => 'required|max:100',
		 'bsa_country'      => 'required|max:100',
		 'bsa_state'        => 'required|max:100',
		 'bsa_address'      => 'required|max:100',
		 'bsa_address_type' => 'max:100',
		 'bsa_ship_dir'     => 'required|max:100',
		 'bsa_default'      => 'max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$preData = Ubs::where('bsa_id', $id)->firstOrFail();
		$preData->where('bsa_id', $id)->update($request->except(['_token', '_method', 'add_ubs']));
		if($preData->save()){
			//dd('update redirect');
			return redirect(action('UbsController@index'));
		}else{
			return abort(404);
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	/*public function destroy($id){
		$status = Ubs::delete($id);
		return redirect(action('UbsController@index'));
	}*/
	
	public function destroy($id){
		DB::table('bill_ship_address')->where('bsa_id', '=', $id)->delete();
		return redirect(action('UbsController@index'));
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				$record = ubs::paginate("$selected_option");
				return view('ubs', ['record' => $record]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$pg = (isset($op_select)) ? $op_select : '10';
				
				$record = DB::table('bill_ship_address')->where('bsa_fname', 'like', '%'.$keyword.'%')->orWhere('bsa_lname', 'like', '%'.$keyword.'%')->orWhere('bsa_address', 'like', '%'.$keyword.'%')->select()->orderBy('bsa_id', 'asc')->paginate("$pg");
				return view('ubs', ['record' => $record]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$record = DB::table('bill_ship_address')->select('bill_ship_address.*')->orderBy('bsa_id', 'asc')->paginate("$pg");
				return view('ubs', ['record' => $record]);
			}else if(isset($keyword) && !isset($pg)){
				$record = DB::table('bill_ship_address')->where('bsa_fname', 'like', '%'.$keyword.'%')->orWhere('bsa_lname', 'like', '%'.$keyword.'%')->orWhere('bsa_address', 'like', '%'.$keyword.'%')->select('bill_ship_address.*')->orderBy('bsa_id', 'asc')->paginate(10);
				return view('ubs', ['record' => $record]);
			}else if(isset($pg) && isset($keyword)){
				
				$record = DB::table('bill_ship_address')->where('bsa_title', 'like', '%'.$keyword.'%')->orWhere('bsa_lname', 'like', '%'.$keyword.'%')->orWhere('bsa_address', 'like', '%'.$keyword.'%')->select('bill_ship_address.*')->orderBy('bsa_id', 'asc')->paginate("$pg");
				return view('ubs', ['record' => $record]);
				
			}else{
				$record = DB::table('bill_ship_address')->where('bsa_fname', 'like', '%'.$keyword.'%')->orWhere('bsa_lname', 'like', '%'.$keyword.'%')->orWhere('bsa_address', 'like', '%'.$keyword.'%')->select('bill_ship_address.*')->orderBy('bsa_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('ubs', ['record' => $record]);
			}
		}
		// exit();
	}
	
}
