<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\slider;
use Illuminate\Support\Facades\Input;
use Hash;

class SliderController extends Controller
{
    //
	public function index() {
      //$sliders = DB::select('select * from slider');
      $sliders = slider::paginate(50);
	  return view('slider',['sliders'=>$sliders]);
   }
   
  public function addSlider() {
	  
	  return view('addslider');
  }
  
  public function store(Request $request)
    {
		//get the file
    	$file = Input::file('file');

		//create a file path
		$path = 'uploads/slider/';
		
		//get the file name
		$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
		
		//save the file to your path
		$file->move($path , $file_name); //( the file path , Name of the file)
		
		$result = DB::insert("insert into slider(slider_title,slider_redirect,slider_image,slider_detail) values(? ,? ,? ,?)",[$request->input('title'),$request->input('url'),$file_name,'']);
		
		return redirect()->to('view-slider');
		
    }
 
 	public function show($id) {
	  $sliders = DB::select('select * from slider where slider_id = ?',[$id]);
      return view('slider_update',['sliders'=>$sliders]);
   }
 	
	public function edit(Request $request,$id) {
		
		if($request->hasFile('file')){
			//get the file
			$file = Input::file('file');
			
			//create a file path
			$path = 'uploads/slider/';
		
			//get the file name
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			
			//save the file to your path
			$file->move($path , $file_name); //( the file path , Name of the file)
			
			//unlink previous image
			$file_name2 = $request->input('slider_image');
			$file_path = 'uploads/slider/'.$file_name2;
			@unlink($file_path);
		} else {	
			$file_name = $request->input('slider_image');
		}
		
		  $title = $request->input('title');
		  $url = $request->input('url');
		  
		  DB::update('update slider set slider_title = ?, slider_redirect = ?, slider_image = ? where slider_id = ?',[$title,$url,$file_name,$id]);
		  return redirect()->to('view-slider');
	}
	
	public function destroy($id)
	{	
		 $sliders = DB::select('select * from slider where slider_id = ?',[$id]);
		 foreach($sliders as $slider){
		 	$slider_image = $slider->slider_image;
		 }
		 //unlink previous image
		 $file_name2 = $slider_image;
		 $file_path = 'uploads/slider/'.$file_name2;
		 unlink($file_path);	
			
		 DB::table('slider')->where('slider_id', '=', $id)->delete();
		 return redirect()->to('view-slider');
	}
	
}
