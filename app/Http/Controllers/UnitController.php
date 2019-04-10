<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\unit;

class UnitController extends Controller
{
    //
	public function index() {
      //$units = DB::select('select * from unit');
      $units = unit::paginate(10);
	  return view('unit',['units'=>$units]);
   }
   
  public function addunit() {
  	return view('addunit');
  }
  
  public function store(Request $request)
    {
		//print_r($request->input());
		//$result = DB::insert("insert into test(name,email) values(? ,?)",[$request->input('name'),$request->input('email')]);
	    $validator = Validator::make([ 'unit_title'  => $request->input('title'), ], [ 'unit_title'  => 'required|max:100', ]);
	    if($validator->fails()) return back()->withErrors($validator) ->withInput();
	
	
	    $result = DB::insert("insert into unit(unit_title) values(?)",[$request->input('title')]);
		
		return redirect()->to('view-unit');
		
    }
  
  	public function show($id) {
      $units = DB::select('select * from unit where unit_id = ?',[$id]);
      return view('unit_update',['units'=>$units]);
   }
  
  	public function edit(Request $request,$id) {
		  $validator = Validator::make([ 'unit_title'  => $request->input('title'), ], [ 'unit_title'  => 'required|max:100', ]);
		  if($validator->fails()) return back()->withErrors($validator) ->withInput();
		  
		  $title = $request->input('title');
		  
		  DB::update('update unit set unit_title = ? where unit_id = ?',[$title,$id]);
		  return redirect()->to('view-unit');
	}
  
  	public function destroy($id)
	{
		 DB::table('unit')->where('unit_id', '=', $id)->delete();
		 return redirect()->to('view-unit');
	}
	
	public function filter(Request $request){
    //echo "test function"; exit();
    
        if($request->ajax()){
            if ($request->get('selected_option') && ($request->get('keyword') == '')) {
        $selected_option = $request->get('selected_option');
        $request->session()->put('selected_option',$selected_option);
        $op_select = $request->session()->get('selected_option');
        $request->session()->forget('keyword');
      	$units = unit::paginate("$selected_option");
	 	return view('unit',['units'=>$units]);

            }else if ($request->get('keyword')) {      
                $keyword = $request->get('keyword');
                $request->session()->put('keyword',$keyword);
                $selected_option = $request->get('selected_option');
                $request->session()->put('selected_option',$selected_option);
                $op_select = $request->session()->get('selected_option');
                $pg = (isset($op_select))?$op_select:'10';

                 $units = DB::table('unit')
             ->where('unit_title','like','%'.$keyword.'%')
             ->select()
             ->orderBy('unit_id','asc')
             ->paginate("$pg");
     		return view('unit',['units'=>$units]);
            }

        
        }else{
        $keyword = $request->session()->get('keyword');

        if(isset($pg) && !isset($keyword)){
              $units = DB::table('unit')
             ->select('unit.*')
             ->orderBy('unit_id','asc')
             ->paginate("$pg");
     		return view('unit',['units'=>$units]);

        }else if(isset($keyword) && !isset($pg)){
  $units = DB::table('unit')
             ->where('unit_title','like','%'.$keyword.'%')
             ->select('unit.*')
             ->orderBy('unit_id','asc')
             ->paginate(10);
     		return view('unit',['units'=>$units]);

        }else if(isset($pg) && isset($keyword)){

        	echo $pg . " and ". $keyword; exit();

    $units = DB::table('unit')
             ->where('unit_title','like','%'.$keyword.'%')
             ->select('unit.*')
             ->orderBy('unit_id','asc')
             ->paginate("$pg");
     		return view('unit',['units'=>$units]);
        }

        }

         // exit();
    }
	
	
}
