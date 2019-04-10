<?php

namespace App\Http\Controllers;

use App\OscoSettings;
use Illuminate\Http\Request;
use Validator;

class OscoSettingsController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$record = OscoSettings::first()->toArray();
		
		return view('oscosettings', compact('record'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		return view('admin.clients.clients-add');
	}
	
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	
	public function store(Request $request){
		
		$status = OscoSettings::create($request->except(['_token']));
		if($status->save()){
			return redirect(action("admin\site\ClientController@index"));
		}else{
			return abort(404);
		}
	}
	
	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		
	}
	
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		$data = OscoSettings::where('c_id', $id)->firstOrFail();
		return view('admin.clients.clients-add', compact('data'));
	}
	
	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		
		$validator = Validator::make([
		 
		 'user_name'             => $request->input('user_name'),
		 'password'              => $request->input('password'),
		 'shipper_number'        => $request->input('shipper_number'),
		 'access_license_number' => $request->input('access_license_number'),
		 'markup_value'          => $request->input('markup_value'),
		
		], [
		 
		 'user_name'             => 'required|max:100',
		 'password'              => 'max:40',
		 'shipper_number'        => 'required|max:100',
		 'access_license_number' => 'max:100',
		 'markup_value'          => 'max:100',
		
		]);
		if($validator->fails()) return back()->withErrors($validator)->withInput();
		
		$preData = OscoSettings::where('id', $id)->firstOrFail();
		$preData->where('id', $id)->update($request->except(['_token', '_method', 'add_customer']));
		if($preData->save()){
			return redirect()->to(app('url')->previous().'?' .  http_build_query(['msg' => urlencode('record has been updated')]));
		}else{
			return abort(404);
		}
	}
	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		dd('delete '.$id);
	}
}
