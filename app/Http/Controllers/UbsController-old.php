<?php

namespace App\Http\Controllers;

use App\ubs;
use Illuminate\Http\Request;

class UbsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //echo "testttting"; exit();
        $billshipaddress = ubs::orderBy('bsa_id','asc')->paginate('15');
        return view('ubs')->with('billshipaddress',$billshipaddress);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('addubs');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address' => 'required',
            'address_type' => 'required',
            'shipping_directions' => 'required',
            'make_default' => 'required'
       ]);

       $ubs = new ubs;

       $ubs->user_id = 2;
       $ubs->bsa_fname = $request->input('first_name');
       $ubs->bsa_lname = $request->input('last_name');
       $ubs->bsa_phone = $request->input('phone_number');
	   $ubs->bsa_address = $request->input('address');
	   $ubs->bsa_zip = $request->input('zip_code');
	   $ubs->bsa_city = $request->input('city');
	   $ubs->bsa_state = $request->input('state');
	   $ubs->bsa_country = $request->input('state');
	   $ubs->bsa_type = $request->input('type');
       $ubs->bsa_address_type = $request->input('address_type');
       $ubs->bsa_ship_dir = $request->input('shipping_directions');
       $ubs->bsa_default = $request->input('make_default');
       $ubs->bsa_date = date('Y-m-d H:i:s');
       $ubs->save();
       return redirect('/ubs');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\manufacturers  $manufacturers
     * @return \Illuminate\Http\Response
     */
    public function show(manufacturers $manufacturers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\manufacturers  $manufacturers
     * @return \Illuminate\Http\Response
     */
    public function edit(manufacturers $manufacturers)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\manufacturers  $manufacturers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, manufacturers $manufacturers)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\manufacturers  $manufacturers
     * @return \Illuminate\Http\Response
     */
    public function destroy(manufacturers $manufacturers)
    {
        //
    }
}
