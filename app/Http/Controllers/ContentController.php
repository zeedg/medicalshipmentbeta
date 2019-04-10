<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\content;
use Illuminate\Support\Facades\Input;
use Hash;

class ContentController extends Controller{
	//
	public function index(){
		//$pages = DB::select('select * from page');
		$pages = content::paginate(10);
		return view('content', ['pages' => $pages]);
	}
	
	public function addcontent(){
		return view('addcontent');
	}
	
	public function store(Request $request){
		
		$validator = Validator::make([
		 
		 'page_title'  => $request->input('title'),
		 'page_slug'   => $request->input('slug'),
		 'page_detail' => $request->input('detail'),
		
		], [
		 
		 'page_title'  => 'required|max:100',
		 'page_slug'   => 'required|max:100',
		 'page_detail' => 'required|max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$result = DB::insert("insert into page(page_title,page_slug,page_detail) values(? ,? ,?)", [$request->input('title'), $request->input('slug'), $request->input('detail')]);
		
		return redirect()->to('view-content');
	}
	
	public function show($id){
		$pages = DB::select('select * from page where page_id = ?', [$id]);
		return view('content_update', ['pages' => $pages]);
	}
	
	public function edit(Request $request, $id){
		
		
		$validator = Validator::make([
		 
		 'page_title'  => $request->input('title'),
		 'page_slug'   => $request->input('slug'),
		 'page_detail' => $request->input('detail'),
		
		], [
		 
		 'page_title'  => 'required|max:100',
		 'page_slug'   => 'required|max:100',
		 'page_detail' => 'required|max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$title = $request->input('title');
		$slug = $request->input('slug');
		$detail = $request->input('detail');
		DB::update('update page set page_title = ?, page_slug = ?, page_detail = ? where page_id = ?', [$title, $slug, $detail, $id]);
		return redirect()->to('view-content');
	}
	
	function slug($id, $title){
		
		$exp = explode(' ', trim($title));
		$slug = '';
		foreach($exp as $value){
			
			if($value != ''){
				$slug .= strtolower(trim($value)).'-';
			}
		}
		
		$remove[] = "'";
		$remove[] = '"';
		$remove[] = "&";
		$remove[] = "_";
		$remove[] = "%";
		$remove[] = "$";
		$remove[] = "*";
		$remove[] = "@";
		$remove[] = "!";
		$remove[] = ";";
		$remove[] = ",";
		$remove[] = "/";
		$remove[] = "<";
		$remove[] = "<";
		$remove[] = ">>";
		$remove[] = "<<";
		
		$slug = str_replace($remove, "", $slug);
		
		$slug = rtrim($slug, '-');
		$slug = str_replace('--', '-', $slug);
		
		/*$sql="select * from category where category_slug='".trim($slug)."' and category_id!='".intval($_GET['id'])."'";
		$query=mysql_query($sql);
		$num_rows=mysql_num_rows($query);*/
		
		$pages = DB::select('select * from page where page_slug = ? and category_id = ?', [trim($slug), $id]);
		$num_rows = 0;
		foreach($pages as $page){
			$num_rows = $num_rows+1;
		}
		
		$slug = trim($slug).'||'.$num_rows;
		echo $slug;
	}
	
	public function destroy($id){
		DB::table('page')->where('page_id', '=', $id)->delete();
		return redirect()->to('view-content');
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				
				//$products = products::orderBy('product_id','asc')->paginate('15');
				$pages = DB::table('page')->select('page.*')->orderBy('page_id', 'asc')->paginate("$selected_option");
				return view('content', ['pages' => $pages]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				
				$pg = (isset($op_select)) ? $op_select : '10';
				$pages = DB::table('page')->where('page_title', 'like', '%'.$keyword.'%')->orWhere('page_slug', 'like', '%'.$keyword.'%')->select('page.*')->orderBy('page_id', 'asc')->paginate("$pg");
				return view('content', ['pages' => $pages]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$pages = DB::table('page')->select('page.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('content', ['pages' => $pages]);
			}else if(isset($keyword) && !isset($pg)){
				$pages = DB::table('page')->where('page_title', 'like', '%'.$keyword.'%')->orWhere('page_slug', 'like', '%'.$keyword.'%')->select('page.*')->orderBy('page_id', 'asc')->paginate(10);
				return view('content', ['pages' => $pages]);
			}else if(isset($pg) && isset($keyword)){
				
				$pages = DB::table('page')->where('page_title', 'like', '%'.$keyword.'%')->orWhere('page_slug', 'like', '%'.$keyword.'%')->select('page.*')->orderBy('page_id', 'asc')->paginate("$pg");
				return view('content', ['pages' => $pages]);
			}else{
				$pages = DB::table('page')->where('page_title', 'like', '%'.$keyword.'%')->orWhere('page_slug', 'like', '%'.$keyword.'%')->select('page.*')->orderBy('page_id', 'asc')->paginate(10);
				return view('content', ['pages' => $pages]);
			}
		}
		// exit();
	}
	
}
