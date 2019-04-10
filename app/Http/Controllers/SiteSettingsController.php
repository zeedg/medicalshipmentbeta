<?php

namespace App\Http\Controllers;

use App\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		
		$record = SiteSettings::get()->toArray();
		return view('siteSettings', compact('record'));
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
		
		$status = SiteSettings::create($request->except(['_token']));
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
		$data = SiteSettings::where('c_id', $id)->firstOrFail();
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
		
		
		
		
		if(($request->input('data'))){
			foreach($request->input('data') as $k => $r){
				$preData = SiteSettings::where('id', $k)->first();
				$preData->where('id', $k)->update(['value' => $r]);
			}
		}
		if($preData->save()){
			return back()->with('msg', 'your record have been updated successfuly');
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
