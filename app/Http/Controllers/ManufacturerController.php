<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\manufacturer;
use DB;

class ManufacturerController extends Controller{
	//
	public function index(){
		//$manufacturers = DB::select('select * from manufacturer');
		$manufacturers = manufacturer::orderBy('manu_id', 'ASC')->paginate(10);
		
		return view('manufacturer', ['manufacturers' => $manufacturers]);
	}
	
	public function addmanufacturer(){
		return view('addmanufacturer');
	}
	
	public function store(Request $request){
		
		/* validation */
		$validator = Validator::make(['manu_title' => $request->input('title')], ['manu_title' => 'required|max:100']);
		
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$result = DB::insert("insert into manufacturer(manu_title) values(?)", [$request->input('title')]);
		
		return redirect()->to('view-manufacturer');
	}
	
	public function show($id){
		$manufacturers = DB::select('select * from manufacturer where manu_id = ?', [$id]);
		return view('manufacturer_update', ['manufacturers' => $manufacturers]);
	}
	
	public function edit(Request $request, $id){
		/* validation */
		$validator = Validator::make(['manu_title' => $request->input('title')], ['manu_title' => 'required|max:100']);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$validator = Validator::make(['manu_title' => $request->input('title'),], ['manu_title' => 'required|max:100',]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$title = $request->input('title');
		DB::update('update manufacturer set manu_title = ? where manu_id = ?', [$title, $id]);
		return redirect()->to('view-manufacturer');
	}
	
	public function destroy($id){
		DB::table('manufacturer')->where('manu_id', '=', $id)->delete();
		return redirect()->to('view-manufacturer');
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				$manufacturers = manufacturer::paginate("$selected_option");
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$pg = (isset($op_select)) ? $op_select : '15';
				
				$manufacturers = DB::table('manufacturer')->where('manu_title', 'like', '%'.$keyword.'%')->select('manufacturer.*')->orderBy('manu_id', 'asc')->paginate("$pg");
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$manufacturers = DB::table('manufacturer')->select('manufacturer.*')->orderBy('manu_id', 'asc')->paginate("$pg");
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}else if(isset($keyword) && !isset($pg)){
				$manufacturers = DB::table('manufacturer')->where('manu_title', 'like', '%'.$keyword.'%')->select('manufacturer.*')->orderBy('manu_id', 'asc')->paginate(15);
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}else if(isset($pg) && isset($keyword)){ 
				$manufacturers = DB::table('manufacturer')->where('manu_title', 'like', '%'.$keyword.'%')->select('manufacturer.*')->orderBy('manu_id', 'asc')->paginate("$pg");
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}else{
				$manufacturers = DB::table('manufacturer')->where('manu_title', 'like', '%'.$keyword.'%')->select('manufacturer.*')->orderBy('manu_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('manufacturer', ['manufacturers' => $manufacturers]);
			}
		}
		// exit();
	}
	
}
