<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $this->middleware('auth.basic.once');
        $this->hospitalBlood = $hospitalBlood;
    }
    public function addBlood(Request $request) {
        $bloodId = $request->id;
        $count = $request->count;
        $hospitalId = Auth::user()->hospital_id;
        for($x = 0; $x < $count; $x++)
        {
            $hospitalBlood = new $this->hospitalBlood;
            $hospitalBlood->hospital_id = $hospitalId;
            $hospitalBlood->blood_id = $bloodId;
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
            return 200;
        }
        elseif ($Request->done == 1) {
            return ['error' => 'This request has been processed'];
        }
        elseif ($stock->count() == 0) {
            return ['error' => 'No more stock available in this hospital'];
        }
        elseif ($authUser->hospital_id != $RequestHospital) {
            return ['error' => 'You are not authorized to process this request'];
        }
        else {
            return 404;
        }
    }


    // delete expire bloods
}
