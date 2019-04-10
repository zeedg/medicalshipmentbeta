<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;
use App\User;
use Illuminate\Support\Facades\Input;
use Hash;

class AdminuserController extends Controller{
	//
	public function index(){
		//$users = DB::select('select * from admins where id != ?', ['1']);
		
		$users = DB::table('admins')
        ->select('*')
        ->where('id','!=', 1)
        ->paginate(10);
		
		return view('adminuser', ['users' => $users]);
	}
	
	public function addadminuser(){
		return view('addadminuser');
	}
	
	public function store(Request $request){
		//print_r($request->input());
		//$result = DB::insert("insert into test(name,email) values(? ,?)",[$request->input('name'),$request->input('email')]);
		
		
		
		
		/*validation */
		$validator = Validator::make([
		 
		 'user_fname'  => $request->input('first_name'),
		 'user_lname'  => $request->input('last_name'),
		 'user_name'   => $request->input('user_name'),
		 'email'  => $request->input('user_email'),
		 'password'    => $request->input('password'),
		 'user_status' => $request->input('status'),
		
		], [
		 
		 'user_fname'  => 'max:50',
		 'user_lname'  => 'max:50',
		 'user_name'   => 'max:50',
		 'email'  => 'required|unique:admins|max:100',
		 'password'    => 'required|max:50',
		 'user_status' => 'required',
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator) ->withInput();
		
		$password = Hash::make($request->input('password'));
		
		$result = DB::insert("insert into admins(user_fname,user_lname,user_name,email,password,user_status,created_at) values(? ,? ,? ,? ,? ,? ,?)", [$request->input('first_name'), $request->input('last_name'), $request->input('user_name'), $request->input('user_email'), $password, $request->input('status'), '2018-01-11 21:46:01']);
		
		return redirect()->to('view-adminusers');
	}
	
	public function show($id){
		$users = DB::select('select * from admins where id = ?', [$id]);
		return view('adminuser_update', ['users' => $users]);
	}
	
	public function edit(Request $request, $id){
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$user_name = $request->input('user_name');
		$email = $request->input('email');
		$password = $request->input('password');
		$status = $request->input('status');
		
		$validator = Validator::make([
		 
		 'user_fname'  => $first_name,
		 'user_lname'  => $last_name,
		 'user_name'   => $user_name,
		 'user_email'  => $email,
		 'password'    => $password,
		 'user_status' => $status
		
		], [
		 
		 'user_fname'  => 'max:50',
		 'user_lname'  => 'max:50',
		 'user_name'   => 'max:50',
		 'user_email'  => 'required|unique:user|max:100',
		 'password'    => 'max:50',
		 'user_status' => 'required',
		
		]);
		if($validator->fails()) return back()->withErrors($validator) ->withInput();
		
		
		DB::update('update admins set user_fname = ?, user_lname = ?, user_name = ?, email = ?, password = ?, user_status = ?, created_at = ? where id = ?', [$first_name, $last_name, $user_name, $email, $password, $status, '2018-01-11 21:46:01', $id]);
		return redirect()->to('view-adminusers');
	}
	
	public function showadmin($id){
		$users = DB::select('select * from admins where id = ?', [$id]);
		return view('superadmin_update', ['users' => $users]);
	}
	
	public function editadmin(Request $request, $id){
		$first_name = $request->input('first_name');
		$last_name = $request->input('last_name');
		$user_name = $request->input('user_name');
		$email = $request->input('email');
		
		if($request->input('password') != NULL){
			$password = Hash::make($request->input('password'));
		} else {
			$password = $request->input('old_password');
		}
		
		$status = $request->input('status');
		
		/*validation */
		$validator = Validator::make([
		 
		 'user_fname'  => $first_name,
		 'user_lname'  => $last_name,
		 'user_name'   => $user_name,
		 'user_email'  => $email,
		 'password'    => $password,
		 'user_status' => $status
		
		], [
		 
		 'user_fname'  => 'max:50',
		 'user_lname'  => 'max:50',
		 'user_name'   => 'max:50',
		 'user_email'  => 'required|unique:user|max:100',
		 //'password'    => 'max:50',
		 'user_status' => 'required'
		
		]);
		
		if($validator->fails()) return back()->withErrors($validator) ->withInput();
		
		
		
		DB::update('update admins set user_fname = ?, user_lname = ?, user_name = ?, email = ?, password = ?, user_status = ?, created_at = ? where id = ?', [$first_name, $last_name, $user_name, $email, $password, $status, '2018-01-11 21:46:01', $id]);
		return redirect()->to('superadminshow/'.$id);
	}
	
	public function destroy($id){
		DB::table('admins')->where('id', '=', $id)->delete();
		return redirect()->to('view-adminusers');
	}
	
	public function filter(Request $request){
    //echo "test function"; exit();
    
        if($request->ajax()){
            if ($request->get('selected_option') && ($request->get('keyword') == '')) {
        $selected_option = $request->get('selected_option');
        $request->session()->put('selected_option',$selected_option);
        $op_select = $request->session()->get('selected_option');
        $request->session()->forget('keyword');
      	$users = category::paginate("$selected_option");
	 	return view('adminuser',['users'=>$users]);

            }else if ($request->get('keyword')) {      
                $keyword = $request->get('keyword');
                $request->session()->put('keyword',$keyword);
                $selected_option = $request->get('selected_option');
                $request->session()->put('selected_option',$selected_option);
                $op_select = $request->session()->get('selected_option');
                $pg = (isset($op_select))?$op_select:'15';

                 $users = DB::table('admins')
             ->where('user_name','like','%'.$keyword.'%')
             ->select()
             ->orderBy('id','asc')
             ->paginate("$pg");
     		return view('adminuser',['users'=>$users]);
            }

        
        }else{
        $keyword = $request->session()->get('keyword');

        if(isset($pg) && !isset($keyword)){
              $users = DB::table('admins')
             ->select('admins.*')
             ->orderBy('id','asc')
             ->paginate("$pg");
     		return view('adminuser',['users'=>$users]);

        }else if(isset($keyword) && !isset($pg)){
  $users = DB::table('admins')
             ->where('user_name','like','%'.$keyword.'%')
             ->select('admins.*')
             ->orderBy('id','asc')
             ->paginate(15);
     		return view('adminuser',['users'=>$users]);

        }else if(isset($pg) && isset($keyword)){

        	echo $pg . " and ". $keyword; exit();

    $users = DB::table('admins')
             ->where('user_name','like','%'.$keyword.'%')
             ->select('admins.*')
             ->orderBy('id','asc')
             ->paginate("$pg");
     		return view('adminuser',['users'=>$users]);
        }

        }

         // exit();
    }
	
}
