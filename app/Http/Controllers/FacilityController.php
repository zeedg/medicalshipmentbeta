<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use App\facility;
use Illuminate\Support\Facades\Input;
use Hash;

class FacilityController extends Controller{
	//
	public function index(){
		//$facilities = DB::select('select * from facility');
		$facilities = facility::paginate(10);
		return view('facility', ['facilities' => $facilities]);
	}
	
	public function addfacility(){
		return view('addfacility');
	}
	
	public function store(Request $request){
		
		$validator = Validator::make([
		 
		 'facility_title'  => $request->input('title'),
		 'facility_status' => $request->input('status'),
		 'facility_image'  => Input::file('file'),
		
		], [
		 
		 'facility_title'  => 'required|max:100',
		 'facility_status' => 'required|max:100',
		 'facility_image'  => 'required|max:10000',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		//get the file
		$file = Input::file('file');
		
		//create a file path
		$path = 'uploads/facility/';
		
		//get the file name
		$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
		
		//save the file to your path
		$file->move($path, $file_name); //( the file path , Name of the file)
		
		$result = DB::insert("insert into facility(facility_title,facility_status,facility_image,facility_detail) values(? ,? ,? ,?)", [$request->input('title'), $request->input('status'), $file_name, '']);
		
		return redirect()->to('view-facility');
	}
	
	public function show($id){
		$facilities = DB::select('select * from facility where facility_id = ?', [$id]);
		return view('facility_update', ['facilities' => $facilities]);
	}
	
	public function edit(Request $request, $id){
		$validator = Validator::make([
		 
		 'facility_title'  => $request->input('title'),
		 'facility_status' => $request->input('status'),
		
		], [
		 
		 'facility_title'  => 'required|max:100',
		 'facility_status' => 'required|max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		if($request->hasFile('file')){
			//get the file
			$file = Input::file('file');
			
			//create a file path
			$path = 'uploads/facility/';
			
			//get the file name
			$file_name = rand(1, 1000000).'_'.$file->getClientOriginalName();
			
			//save the file to your path
			$file->move($path, $file_name); //( the file path , Name of the file)
			
			//unlink previous image
			$file_name2 = $request->input('facility_image');
			$file_path = 'uploads/facility/'.$file_name2;
			unlink($file_path);
		}else{
			$file_name = $request->input('facility_image');
		}
		
		$title = $request->input('title');
		$status = $request->input('status');
		DB::update('update facility set facility_title = ?, facility_status = ?, facility_image = ? where facility_id = ?', [$title, $status, $file_name, $id]);
		return redirect()->to('view-facility');
	}
	
	public function destroy($id){
		$facilities = DB::select('select * from facility where facility_id = ?', [$id]);
		foreach($facilities as $facility){
			$facility_image = $facility->facility_image;
		}
		//unlink previous image
		$file_name2 = $facility_image;
		$file_path = 'uploads/facility/'.$file_name2;
		unlink($file_path);
		
		DB::table('facility')->where('facility_id', '=', $id)->delete();
		return redirect()->to('view-facility');
	}

    public function filter(Request $request){
    //echo "test function"; exit();
    
        if($request->ajax()){
            if ($request->get('selected_option') && ($request->get('keyword') == '')) {
        $selected_option = $request->get('selected_option');
        $request->session()->put('selected_option',$selected_option);
        $op_select = $request->session()->get('selected_option');
        $request->session()->forget('keyword');


        //$products = products::orderBy('product_id','asc')->paginate('15');
       $facilities = DB::table('facility')
             ->select('facility.*')
             ->orderBy('facility_id','asc')
             ->paginate("$selected_option");
      return view('facility',['facilities'=>$facilities]);

            }else if ($request->get('keyword')) {      
                $keyword = $request->get('keyword');
                $request->session()->put('keyword',$keyword);

                $selected_option = $request->get('selected_option');
                $request->session()->put('selected_option',$selected_option);
                $op_select = $request->session()->get('selected_option');

                $pg = (isset($op_select))?$op_select:'10';
                 $facilities = DB::table('facility')
             ->where('facility_title','like','%'.$keyword.'%')
             ->select('facility.*')
             ->orderBy('facility_id','asc')
             ->paginate("$pg");
            return view('facility',['facilities'=>$facilities]);


            }

        
        }else{
        $keyword = $request->session()->get('keyword');

        if(isset($pg) && !isset($keyword)){
            $facilities = DB::table('facility')
             ->select('facility.*')
             ->orderBy('facility_id','asc')
             ->paginate("$pg");
            return view('facility',['facilities'=>$facilities]);

        }else if(isset($keyword) && !isset($pg)){
$facilities = DB::table('facility')
             ->where('facility_title','like','%'.$keyword.'%')
             ->select('facility.*')
             ->orderBy('facility_id','asc')
             ->paginate(10);
            return view('facility',['facilities'=>$facilities]);


        }else if(isset($pg) && isset($keyword)){

  $facilities = DB::table('facility')
             ->where('facility_title','like','%'.$keyword.'%')
             ->select('facility.*')
             ->orderBy('facility_id','asc')
             ->paginate("$pg");
            return view('facility',['facilities'=>$facilities]);

        }

        }

         // exit();
    }
	
}
