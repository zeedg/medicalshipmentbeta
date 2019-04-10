<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\testimonial;
use Illuminate\Support\Facades\Input;
use Hash;

class TestimonialController extends Controller{
	//
	public function index(){
		//$testimonials = DB::select('select * from testimonial');
		$testimonials = testimonial::paginate(10);
		return view('testimonial', ['testimonials' => $testimonials]);
	}
	
	public function addtestimonial(){
		return view('addtestimonial');
	}
	
	public function store(Request $request){
		$validator = Validator::make([
		 
		 'testimonial_name'        => $request->input('name'),
		 'testimonial_email'       => $request->input('email'),
		 'testimonial_company'     => $request->input('company'),
		 'testimonial_address'     => $request->input('address'),
		 'testimonial_testimonial' => $request->input('testimonial'),
		 'testimonial_status'      => $request->input('status'),
		 'testimonial_image'       => Input::file('file'),
		
		], [
		 
		 'testimonial_name'        => 'required|max:100',
		 'testimonial_email'       => 'required|email|max:100',
		 'testimonial_company'     => 'max:100',
		 'testimonial_address'     => 'max:100',
		 'testimonial_testimonial' => 'max:100',
		 'testimonial_status'      => 'required|max:100',
		 'testimonial_image'       => 'max:10000',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		//get the file
		$file = Input::file('file');
		
		//create a file path
		$path = 'uploads/testimonial/';
		
		//get the file name
		$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
		
		//save the file to your path
		$file->move($path, $file_name); //( the file path , Name of the file)
		
		$result = DB::insert("insert into testimonial(testimonial_name,testimonial_email,testimonial_company,testimonial_address,testimonial_testimonial,testimonial_status,testimonial_image,testimonial_date) values(? ,? ,? ,?, ? ,? ,? ,?)", [$request->input('name'), $request->input('email'), $request->input('company'), $request->input('address'), $request->input('testimonial'), $request->input('status'), $file_name, date('Y-m-d H:i:s')]);
		
		return redirect()->to('view-testimonial');
	}
	
	public function show($id){
		$testimonials = DB::select('select * from testimonial where testimonial_id = ?', [$id]);
		return view('testimonial_update', ['testimonials' => $testimonials]);
	}
	
	public function edit(Request $request, $id){
		
		$validator = Validator::make([
		 
		 'testimonial_name'        => $request->input('name'),
		 'testimonial_email'       => $request->input('email'),
		 'testimonial_company'     => $request->input('company'),
		 'testimonial_address'     => $request->input('address'),
		 'testimonial_testimonial' => $request->input('testimonial'),
		 'testimonial_status'      => $request->input('status'),
		 'testimonial_image'       => Input::file('file'),
		
		], [
		 
		 'testimonial_name'        => 'required|max:100',
		 'testimonial_email'       => 'required|email|max:100',
		 'testimonial_company'     => 'max:100',
		 'testimonial_address'     => 'max:100',
		 'testimonial_testimonial' => 'max:100',
		 'testimonial_status'      => 'required|max:100',
		 'testimonial_image'       => 'max:10000',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($request->hasFile('file')){
			//get the file
			$file = Input::file('file');
			
			//create a file path
			$path = 'uploads/testimonial/';
			
			//get the file name
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			
			//save the file to your path
			$file->move($path, $file_name); //( the file path , Name of the file)
			
			//unlink previous image
			$file_name2 = $request->input('testimonial_image');
			$file_path = 'uploads/testimonial/'.$file_name2;
			unlink($file_path);
		}else{
			$file_name = $request->input('testimonial_image');
		}
		
		$name = $request->input('name');
		$email = $request->input('email');
		$company = $request->input('company');
		$address = $request->input('address');
		$testimonial = $request->input('testimonial');
		$status = $request->input('status');
		$date = date('Y-m-d H:i:s');
		
		DB::update('update testimonial set testimonial_name = ?, testimonial_email = ?, testimonial_company = ?, testimonial_address = ?, testimonial_testimonial = ?, testimonial_status = ?, testimonial_image = ?, testimonial_date = ? where testimonial_id = ?', [$name, $email, $company, $address, $testimonial, $status, $file_name, $date, $id]);
		return redirect()->to('view-testimonial');
	}
	
	public function destroy($id){
		$testimonials = DB::select('select * from testimonial where testimonial_id = ?', [$id]);
		foreach($testimonials as $testimonial){
			$testimonial_image = $testimonial->testimonial_image;
		}
		//unlink previous image
		$file_name2 = $testimonial_image;
		$file_path = 'uploads/testimonial/'.$file_name2;
		unlink($file_path);
		
		DB::table('testimonial')->where('testimonial_id', '=', $id)->delete();
		return redirect()->to('view-testimonial');
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
				$testimonials = DB::table('testimonial')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate("$selected_option");
				return view('testimonial', ['testimonials' => $testimonials]);
			}else if($request->get('keyword')){
				$keyword = $request->get('keyword');
				$request->session()->put('keyword', $keyword);
				
				$selected_option = $request->get('selected_option');
				$request->session()->put('selected_option', $selected_option);
				$op_select = $request->session()->get('selected_option');
				
				$pg = (isset($op_select)) ? $op_select : '10';
				$testimonials = DB::table('testimonial')->where('testimonial_name', 'like', '%'.$keyword.'%')->orWhere('testimonial_email', 'like', '%'.$keyword.'%')->orWhere('testimonial_company', 'like', '%'.$keyword.'%')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate("$pg");
				return view('testimonial', ['testimonials' => $testimonials]);
			}
		}else{
			$keyword = $request->session()->get('keyword');
			
			if(isset($pg) && !isset($keyword)){
				$testimonials = DB::table('testimonial')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate("$pg");
				return view('testimonial', ['testimonials' => $testimonials]);
			}else if(isset($keyword) && !isset($pg)){
				$testimonials = DB::table('testimonial')->where('testimonial_name', 'like', '%'.$keyword.'%')->orWhere('testimonial_email', 'like', '%'.$keyword.'%')->orWhere('testimonial_company', 'like', '%'.$keyword.'%')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate(10);
				return view('testimonial', ['testimonials' => $testimonials]);
			}else if(isset($pg) && isset($keyword)){
				
				$testimonials = DB::table('testimonial')->where('testimonial_name', 'like', '%'.$keyword.'%')->orWhere('testimonial_email', 'like', '%'.$keyword.'%')->orWhere('testimonial_company', 'like', '%'.$keyword.'%')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate("$pg");
				return view('testimonial', ['testimonials' => $testimonials]);
			}else{
				$testimonials = DB::table('testimonial')->where('testimonial_name', 'like', '%'.$keyword.'%')->orWhere('testimonial_email', 'like', '%'.$keyword.'%')->orWhere('testimonial_company', 'like', '%'.$keyword.'%')->select('testimonial.*')->orderBy('testimonial_id', 'asc')->paginate((is_numeric(session()->get('selected_option'))) ? session()->get('selected_option') : 10);
				return view('testimonial', ['testimonials' => $testimonials]);
			}
		}
		// exit();
	}
	
}
