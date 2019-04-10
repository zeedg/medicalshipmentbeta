<?php

namespace App\Http\Controllers;

use App\news;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use DB;
use Validator;
use File;

class NewsController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		//
		$news = DB::table('news')->select('news.*')->orderBy('id', 'asc')->paginate('10');
		return view('listNews', ['news' => $news]);
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		return view('addNews');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//       
		$validator = Validator::make([
		 'title'=> $request->input('title'),
		 'description'=> $request->input('description'),
		 'author'=> $request->input('author'),
		 'image'=> Input::file('news_img'),
		 
		], [
		 
		 'title'    => 'required|max:100',
		 'description'    => 'required|max:9999999',
		 'author'    => 'required|max:100',
		 'image'    => 'required|max:1000',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($file = $request->file('news_img')){
			$path = 'uploads/news/';
			$image_name = $file->getClientOriginalName();
			$file->move($path, $image_name);
		}
		
		// print_r($image_name); exit();
		$result = DB::insert("INSERT INTO news(title,image,description,author,date_added) VALUES(?,?,?,?,?)", [$request->input('title'), $image_name, $request->input('description'), $request->input('author'), date('Y-m-d H:i:s')]);
		
		//return redirect()->to('news' .'?msg=' . urlencode('record has been successfully inserted')->with('news_added', 'New news added'));
		return redirect()->to('news');
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  \App\cr $cr
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\cr $cr
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
		$news = DB::table('news')->select('news.*')->where('id', $id)->get();
		return view('/editNews', ['news' => $news]);
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\cr                  $cr
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request){
		//
		$validator = Validator::make([
		 'title'=> $request->input('title'),
		 'description'=> $request->input('news_description'),
		 'author'=> $request->input('author'),
		 'image'=> Input::file('news_img'),
		
		], [
		 
		 'title'    => 'required|max:100',
		 'description'    => 'required|max:9999999',
		 'author'    => 'required|max:100',
		 'image'    => 'max:1000',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($request->hasFile('news_image_file')){
			if($file = $request->file('news_image_file')){
				$path = 'uploads/news/';
				$image_name = $file->getClientOriginalName();
				$file->move($path, $image_name);
			}
		}else{
			$image_name = $request->input('news_image');
		}
		
		$id = $request->input('news_id');
		
		$news = news::find($id);
		
		$news->title = $request->input('title');
		$news->author = $request->input('author');
		$news->image = $image_name;
		$news->description = $request->input('news_description');
		$news->save();
		return redirect('/news')->with('news_update', 'News Updated');
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\cr $cr
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		$news = DB::select('select * from news where id = ?', [$id]);
		foreach($news as $new){
			$news_image = $new->image;
		}
		//unlink previous image
		$file_name2 = $news_image;
		$file_path = 'uploads/news/'.$file_name2;
		unlink($file_path);
		
		$blog = DB::table('news')->where('id', $id)->delete();
		return Redirect::to('news')->with('news_deleted', 'Deleted News Successfully');
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
				$news = DB::table('news')->select('news.*')->orderBy('id', 'asc')->paginate("$selected_option");
				return view('listNews', ['news' => $news]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				
				$pg = (isset($op_select)) ? $op_select : '15';
				$news = DB::table('news')->where('title', 'like', '%'.$keyword.'%')->orWhere('description', 'like', '%'.$keyword.'%')->orWhere('author', 'like', '%'.$keyword.'%')->select('news.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('listNews', ['news' => $news]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$news = DB::table('news')->select('news.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('listNews', ['news' => $news]);
			}else if(isset($keyword) && !isset($pg)){
				$news = DB::table('news')->where('title', 'like', '%'.$keyword.'%')->orWhere('description', 'like', '%'.$keyword.'%')->orWhere('author', 'like', '%'.$keyword.'%')->select('news.*')->orderBy('id', 'asc')->paginate(15);
				return view('listNews', ['news' => $news]);
			}else if(isset($pg) && isset($keyword)){
				
				$news = DB::table('news')->where('title', 'like', '%'.$keyword.'%')->orWhere('description', 'like', '%'.$keyword.'%')->orWhere('author', 'like', '%'.$keyword.'%')->select('news.*')->orderBy('id', 'asc')->paginate("$pg");
				return view('listNews', ['news' => $news]);
			}else{
				$news = DB::table('news')->where('title', 'like', '%'.$keyword.'%')->orWhere('description', 'like', '%'.$keyword.'%')->orWhere('author', 'like', '%'.$keyword.'%')->select('news.*')->orderBy('id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('listNews', ['news' => $news]);
			}
		}
		// exit();
	}
	
	function delete_img($id){
		//echo "do you want to delete video". $id;
		$exp_id = explode('_', $id);
		$news_id = $exp_id[ 0 ];
		$image_name = $exp_id[ 1 ];
		DB::table('news')->where('id', $news_id)->update(['image' => '']);
		//$destinationPath = url('/uploads/news/'.$image_name);
		//File::delete($destinationPath);
		
		//unlink previous image
		$file_name2 = $image_name;
		$file_path = 'uploads/news/'.$file_name2;
		unlink($file_path);
		
		return Redirect::to('news/edit/'.$news_id)->with('delete_img', 'News Image Deleted');
	}
}
