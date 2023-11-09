<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\HospitalUser;
use Illuminate\Http\Request;

class HospitalusersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HospitalUser::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
             $donationRequest = HospitalUser::create([
            'user_id'=>$request->user_id,
            'hospital_id'=>$request->hospital_id,
            'type'=>$request->type
        ]);


        return response()->json($donationRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $request = HospitalUser::where('user_id', $id)->get();
    $gettype = $request->map(function($request){
        if ($request->type == 0){
            return ["type"=>'user donated blood',"request_id"=>$request->id];
        }
        elseif ($request->type == 2){
        return ["type"=>'user requested blood',"request_id"=>$request->id];
        }
        else{
            return ["type"=>'hospital requested blood',"request_id"=>$request->id];
        }
    });
    return response()->json( $gettype);
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HospitalUser $requests_donation)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HospitalUser $requests_donation)
    {
       $requests_donation->delete();
       return response()->json(['message'=> 'User deleted']);
    }
}
