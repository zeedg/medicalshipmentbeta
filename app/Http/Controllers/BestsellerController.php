<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\bestseller;

class BestsellerController extends Controller{
	//
	public function index(){
		//$units = DB::select('select * from unit');
		$units = unit::paginate(50);
		return view('unit', ['units' => $units]);
	}
	
	public function addunit(){
		return view('addunit');
	}
	
	public function store(Request $request){
		//print_r($request->input());
		//$result = DB::insert("insert into test(name,email) values(? ,?)",[$request->input('name'),$request->input('email')]);
		$validator = Validator::make($request->all(), ['unit_title' => 'max:5000']);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$result = DB::insert("insert into unit(unit_title) values(?)", [$request->input('title')]);
		
		return redirect()->to('view-unit');
	}
	
	public function show($id){
		$bestsellers = DB::select('select * from best_seller where bs_id = ?', [$id]);
		return view('bestseller_update', ['bestsellers' => $bestsellers]);
	}
	
	public function edit(Request $request, $id){
		$validator = Validator::make($request->all(), [ 'unit_title' => 'max:5000' ]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$bestseller = $request->input('bestseller');
		DB::update('update best_seller set bs_product = ? where bs_id = ?', [$bestseller, $id]);
		return redirect()->to('bestsellerupdate/1'.'?msg=' . urlencode('record has been successfully updated'));
	}
	
	public function destroy($id){
		DB::table('unit')->where('unit_id', '=', $id)->delete();
		return redirect()->to('view-unit');
	}
	
}
