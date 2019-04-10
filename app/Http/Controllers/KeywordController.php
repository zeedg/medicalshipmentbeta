<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\keyword;
use App\category;

class KeywordController extends Controller{
	//public $Keyword;
	public function __constructor(){
		//$Keyword = App\keyword::paginate(10);
		//App\keyword::paginate(10);
	}
	
	public function index(){
		//$units = DB::select('select * from unit');
		//$units = unit::paginate(50);
		//return view('unit',['units'=>$units]);
		
		$keywords_arr = [];
		$i = 0;
		$search_keywords = DB::select('select * from search_keywords');
		foreach($search_keywords as $rec){
			$categories_title = '';
			$c_id = $rec->categories;
			
			$categories = DB::select("SELECT * FROM category as a WHERE FIND_IN_SET(category_id,'$c_id')");
			
			//$categories = Keyword::select("SELECT * FROM category as a WHERE FIND_IN_SET(category_id,'$c_id')")->paginate(10);
			
			/*$categories = DB::table('category')
            ->select('category.*')
		    ->whereRaw('FIND_IN_SET("$c_id",category_id)')
		    ->paginate(10);*/
			
			foreach($categories as $list){
				$categories_title .= $list->category_title.', ';
			}
			
			$keywords_arr[ $i ][ 'id' ] = $rec->id;
			$keywords_arr[ $i ][ 'keyword' ] = $rec->keyword;
			$keywords_arr[ $i ][ 'categories' ] = $rec->categories;
			$keywords_arr[ $i ][ 'categories_value' ] = $categories_title;
			$i++;
		}
		
		$keywords_arr = json_decode(json_encode($keywords_arr));
		
		return view('keyword', ['keywords_arr' => $keywords_arr]);
	}
	
	public function addkeyword(){
		$categories = DB::select("select * from category where category_parent=0 and category_id != 67 order by category_title asc");
		return view('addkeyword', ['categories' => $categories]);
	}
	
	public function store(Request $request){
		
		
		$validator = Validator::make($request->all(), [
		 
		 'keyword'    => 'required|max:100',
		 'categories' => 'max:500',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if(!empty($request->input('keyword')) && !empty($request->input('categories'))){
			$keyword = $request->input('keyword');
			$categories = $request->input('categories');
			$categories_list = implode(",", $categories);
			$date = date('Y-m-d');
			
			$result = DB::insert("insert into search_keywords(keyword,categories,date_added) values(?, ?, ?)", [$keyword, $categories_list, $date]);
		}
		return redirect()->to('view-keyword' .'?msg=' . urlencode('record has been successfully inserted'));
	}
	
	public function show($id){
		$keywords = DB::select('select * from search_keywords where id = ?', [$id]);
		return view('keyword_update', ['keywords' => $keywords]);
	}
	
	public function edit(Request $request, $id){
		
		$validator = Validator::make($request->all(), [
		 
		 'keyword'    => 'required|max:100',
		 'categories' => 'max:500',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		
		if(!empty($request->input('keyword')) && !empty($request->input('categories'))){
			$keyword = $request->input('keyword');
			$categories = $request->input('categories');
			$categories_list = implode(",", $categories);
			$date = date('Y-m-d');
			
			DB::update('update search_keywords set keyword = ?, categories = ?, date_added = ? where id = ?', [$keyword, $categories_list, $date, $id]);
		}
		return redirect()->to('view-keyword' .'?msg=' . urlencode('record has been successfully updated'));
	}
	
	public function destroy($id){
		DB::table('search_keywords')->where('id', '=', $id)->delete();
		return redirect()->to('view-keyword');
	}
	
	public function filter(Request $request){
		//echo "test function"; exit();
		
		if($request->ajax()){
			if($request->get('selected_option') && ($request->get('keyword') == '')){
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$request->session()->forget('keyword');
				$keywords = category::paginate("$selected_option");
				return view('keyword', ['keywords' => $keywords]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				$pg = (isset($op_select)) ? $op_select : '15';
				
				$keywords = DB::table('search_keywords')->where('keyword', 'like', '%'.$keyword.'%')->select()->orderBy('id', 'asc')->paginate("$pg");
				return view('keyword', ['keywords' => $keywords]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$keywords = DB::table('search_keywords')->select('search_keywords.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('keyword', ['keywords' => $keywords]);
			}else if(isset($keyword) && !isset($pg)){
				$keywords = DB::table('search_keywords')->where('keyword', 'like', '%'.$keyword.'%')->select('search_keywords.*')->orderBy('id', 'asc')->paginate(10);
				return view('keyword', ['keywords' => $keywords]);
			}else if(isset($pg) && isset($keyword)){
				
				echo $pg." and ".$keyword;
				exit();
				
				$keywords = DB::table('search_keywords')->where('keyword', 'like', '%'.$keyword.'%')->select('search_keywords.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('keyword', ['keywords' => $keywords]);
			}
		}
		// exit();
	}
	
}
