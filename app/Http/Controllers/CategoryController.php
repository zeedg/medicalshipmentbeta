<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\category;
use Illuminate\Support\Facades\Input;
use Hash;

class CategoryController extends Controller{
	//
	public function index(){
		//$categories = DB::select('select * from category');
		$categories = category::paginate(10);
		return view('category', ['categories' => $categories]);
	}
	
	public function fetchCategoryTree($parent = 0, $spacing = '', $user_tree_array = ''){
		
		if(!is_array($user_tree_array)) $user_tree_array = [];
		
		$categories = DB::select("SELECT * FROM `category` WHERE 1 AND `category_parent` = $parent ORDER BY category_id ASC");
		foreach($categories as $row){
			$user_tree_array[] = ["category_id" => $row->category_id, "category_title" => $spacing.$row->category_title];
			$user_tree_array = $this->fetchCategoryTree($row->category_id, $spacing.'&nbsp;&nbsp;', $user_tree_array);
		}
		
		return $user_tree_array;
	}
	
	public function addcategory(){
		
		$categories = $this->fetchCategoryTree();
		
		//$categories = DB::select('select * from category');
		return view('addcategory', ['categories' => $categories]);
		//return view('addcategory');
	}
	
	public function store(Request $request){
		
		
		/*validation */
		$validator = Validator::make([
		 
		 'category_parent' => $request->input('category'),
		 'category_title'  => $request->input('title'),
		 'category_slug'   => $request->input('slug'),
		 'category_sort'   => $request->input('category_sort'),
		 'category_detail' => $request->input('detail'),
		
		], [
		 
		 'category_parent' => 'required|max:100',
		 'category_title'  => 'required |max:100',
		 'category_slug'   => 'required|max:100',
		 'category_sort'   => 'max:20',
		 'category_detail' => 'required|max:200',
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		//get the file
		$file = Input::file('file');
		//create a file path
		$path = 'uploads/category/';
		
		//get the file name
		if(!empty($file)){
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			//save the file to your path
			$file->move($path, $file_name); //( the file path , Name of the file)
		}else{
			$file_name = '';
		}
		
		$result = DB::insert("insert into category(category_parent,category_title,category_slug,category_sort,category_detail,category_image) values(? ,? ,? ,? ,? ,?)", [$request->input('category'), $request->input('title'), $request->input('slug'), $request->input('category_sort'), $request->input('detail'), $file_name]);
		
		return redirect()->to('view-category');
	}
	
	public function show($id){
		//$categories = DB::select('select * from category');	
		$categories = $this->fetchCategoryTree();
		$categories2 = DB::select('select * from category where category_id = ?', [$id]);
		return view('category_update', ['categories' => $categories, 'categories2' => $categories2]);
	}
	
	public function edit(Request $request, $id){
		
		
		/*validation */
		$validator = Validator::make([
		 
		 'category_parent' => $request->input('category'),
		 'category_title'  => $request->input('title'),
		 'category_slug'   => $request->input('slug'),
		 'category_sort'   => $request->input('category_sort'),
		 'category_detail' => $request->input('detail'),
		
		], [
		 
		 'category_parent' => 'required|max:100',
		 'category_title'  => 'required |max:100',
		 'category_slug'   => 'required|max:100',
		 'category_sort'   => 'max:20',
		 'category_detail' => 'required|max:200',
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($request->hasFile('file')){
			//get the file
			$file = Input::file('file');
			
			//create a file path
			$path = 'uploads/category/';
			
			//get the file name
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			
			//save the file to your path
			$file->move($path, $file_name); //( the file path , Name of the file)
			
			//unlink previous image
			$file_name2 = $request->input('category_image');
			$file_path = 'uploads/category/'.$file_name2;
			unlink($file_path);
		}else{
			$file_name = $request->input('category_image');
		}
		
		$category = $request->input('category');
		$title = $request->input('title');
		$slug = $request->input('slug');
		$category_sort = $request->input('category_sort');
		$detail = $request->input('detail');
		DB::update('update category set category_parent = ?, category_title = ?, category_slug = ?, category_sort = ?, category_detail = ?, category_image = ? where category_id = ?', [$category, $title, $slug, $category_sort, $detail, $file_name, $id]);
		return redirect()->to('view-category');
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
		
		$categories = DB::select('select * from category where category_slug = ? and category_id = ?', [trim($slug), $id]);
		$num_rows = 0;
		foreach($categories as $category){
			$num_rows = $num_rows+1;
		}
		
		$slug = trim($slug).'||'.$num_rows;
		echo $slug;
	}
	
	public function destroy($id){
		$categories = DB::select('select * from category where category_id = ?', [$id]);
		foreach($categories as $category){
			$category_image = $category->category_image;
		}
		//unlink previous image
		$file_name2 = $category_image;
		$file_path = 'uploads/category/'.$file_name2;
		unlink($file_path);
		
		DB::table('category')->where('category_id', '=', $id)->delete();
		return redirect()->to('view-category');
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				$categories = category::paginate("$selected_option");
				return view('category', ['categories' => $categories]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$pg = (isset($op_select)) ? $op_select : '15';
				
				$categories = DB::table('category')->where('category_title', 'like', '%'.$keyword.'%')->select()->orderBy('category_id', 'asc')->paginate("$pg");
				return view('category', ['categories' => $categories]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$categories = DB::table('category')->select('category.*')->orderBy('category_id', 'asc')->paginate("$pg");
				return view('category', ['categories' => $categories]);
			}else if(isset($keyword) && !isset($pg)){
				$categories = DB::table('category')->where('category_title', 'like', '%'.$keyword.'%')->select('category.*')->orderBy('category_id', 'asc')->paginate(15);
				return view('category', ['categories' => $categories]);
			}else if(isset($pg) && isset($keyword)){
				
				echo $pg." and ".$keyword;
				exit();
				
				$categories = DB::table('category')->where('category_title', 'like', '%'.$keyword.'%')->select('category.*')->orderBy('category_id', 'asc')->paginate("$pg");
				return view('category', ['categories' => $categories]);
			}else{
				$categories = DB::table('category')->select('category.*')->orderBy('category_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('category', ['categories' => $categories]);
			}
		}
		// exit();
	}
	
}
