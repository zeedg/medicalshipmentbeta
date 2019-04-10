<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;
use Auth;
use Illuminate\Support\Facades\Session;
//use Session;

class LoginController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		
		return view('frontwebsite.login');
		
	}
	
	public function indexlogin(Request $request){
		
		if($request->pid != NULL){
			$arrVal['pid'] = $request->pid;
			return view('frontwebsite.login',$arrVal);
		} else {
			return view('frontwebsite.login');
		}
		
	}
	
	public function checklogin(Request $request){
		$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|alphaNum|min:3',
		]);
		
		$userdata = json_decode(json_encode(DB::select("select * from customer where user_email = '".$request->input('email')."' and
		 user_password =  '".$request->input('password')."' limit 1 ")) , true);
		
		if(count($userdata) > 0 ){
			
			array_map(function($v , $k ){ session()->put($k ,$v ); } , array_values($userdata[0]) , array_keys($userdata[0]));
			
			if($request->input('pid') != '' && $request->input('pid') != 'abandCart'){
				?>
                <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
                <script type="text/javascript">
					$(document).ready(function ($) {
						$.post( "<?php echo url('/'); ?>/cart/ajax", { 
							product_id: <?php echo $request->input('pid'); ?>, 
							cquantity: 1, 
							unit_id: 7, 
							_token : "<?php echo csrf_token(); ?>" 
						} , 
						function( data ) {	
						alert(data);
							if(data == 'login'){
								window.location= '<?php echo url("login_user/".$request->input('pid')); ?>';
							} else {
								window.location= '<?php echo url("addto_cart"); ?>';
							}
						});
					});
				</script>
				<?php
					
              } else {
				//array_map(function($v , $k ){ session()->put($k ,$v ); } , array_values($userdata[0]) , array_keys($userdata[0]));
				//dd(session()->all());
				return redirect('login/successlogin');
			  }
		}
		else
		{
			return back()->with('error', 'Wrong Login Details');
		}
	}
	
	function successlogin(){
		
		return view('frontwebsite.index');
	
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		//
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		//
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		//
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		//
	}
	
	function logout()
	{
		//Auth::logout();
		Session::flush();
		return redirect('login_user');
	}
	
		
}
