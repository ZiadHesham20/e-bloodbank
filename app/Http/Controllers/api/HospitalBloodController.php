<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BloodResource;
use App\Http\Resources\HospitalBloodResource;
use App\Models\Hospital;
use App\Models\HospitalBlood;
use App\Models\HospitalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalBloodController extends Controller
{
    public $hospitalBlood;

    public function __construct(HospitalBlood $hospitalBlood)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('Admin')->only('addBlood');
        $this->hospitalBlood = $hospitalBlood;
    }
    public function addBlood(Request $request) {
        $blood_id = $request->blood_id;
        $count = $request->count;
        $user = Auth::user();
        for($x = 0; $x < $count; $x++)
        {
            $hospitalBlood = new $this->hospitalBlood;
            $hospitalBlood->hospital_id = $user->hospital_id;
            $hospitalBlood->blood_id = $blood_id;
            $hospitalBlood->save();
        }
        return response()->json(['status' => 'success', 'message'=>'Added Blood Successfully'],201);
    }

    // payment method then blood decrease 1 from latest
    public function payBlood($id)
    {
        $authUser = auth()->user();
        $Request = HospitalUser::findOrFail($id);
        $RequestBlood = $Request->blood_id;
        $RequestHospital = $Request->hospital_id;
        $stock = $this->hospitalBlood->where('blood_id', $RequestBlood)->where('hospital_id', $RequestHospital)->get();
        if ($stock->count() >= 1 && $authUser->hospital_id == $RequestHospital && $Request->done == 0) {
            $stock->first()->delete();
            $Request->done = 1;
            $Request->update();
            return response()->json(['status' => 'success'], 200);
        }
        elseif ($Request->done == 1) {
            return response()->json(['error' => 'This request has been processed'], 200);
        }
        elseif ($stock->count() == 0) {
            return response()->json(['error' => 'No more stock available in this hospital'], 200);
        }
        elseif ($authUser->hospital_id != $RequestHospital) {
            return response()->json(['error' => 'You are not authorized to process this request'], 200);
        }
        else {
            return response()->json(['message' => 'error'], 404);
        }
    }


    // delete expire bloods
    public function deleteExpiredBloods($id)
    {
        $user = Auth::user();
        $blood = $this->hospitalBlood::findOrFail($id);
        if ($user->hospital_id == $blood->hospital_id){
            $blood->delete();
            return response()->json(['message' => 'deleted'], 200);
        }
        else {
            return response()->json(['message' => 'you not allow to do this!'], 404);
        }
    }

    public function index()
    {
        $user = Auth::user();
        $bloods = HospitalBloodResource::collection($this->hospitalBlood::where('hospital_id', $user->hospital_id)->get());
        return $bloods->response()->setStatusCode(200);
    }

    public function bloods($id)
    {
        // $bloods = Hospital::findOrFail($id)->bloods()->where('type', $type)->orderBy('created_at', 'desc')->get();
        // // Create a new UserResource instance
        // $bloodsResource = BloodResource::collection($bloods);

        // // Return the transformed data as a JSON response with a 201 status code
        // return $bloodsResource->response()->setStatusCode(200);

        $authUser = Auth::user();
        $bloods = $this->hospitalBlood::where('hospital_id', $authUser->hospital_id)->where('blood_id', $id)->get();
        $bloodsResource = HospitalBloodResource::collection($bloods);

        // Return the transformed data as a JSON response with a 201 status code
        return $bloodsResource->response()->setStatusCode(200);
    }

}
