<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\HospitalBlood;
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
}
