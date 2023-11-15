<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\HospitalUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalUserController extends Controller
{
    public $request;

    public function __construct(HospitalUser $request)
    {
        $this->middleware('auth.basic.once')->only('requestBloods', 'showDonorUser', 'MyHospitalRequests', 'MyHospitalUsersRequests', 'myUserRequests', 'requestDonate');
        $this->middleware('HospitalAdmin')->only('requestBloods', 'showDonorUser');
        $this->request = $request;
    }

    // ziad
    public function index()
    {
        return $this->request::all();
    }

    public function requestBloods($id)
    {
        // add num of bloods need ?
        $user = Auth::user();
        $hospitalId = $user->hospital_id;
        $request = new $this->request;

        $request->type = 1;
        $request->user_id = $user->id;
        $request->hospital_id = $hospitalId;
        $request->blood_id = intval($id);

        $request->save();

        return $request;
    }
    // moamen
    public function requestDonate(Request $request)
    {
        $user = Auth::user();
        $hospitalId = intval($request->hospital_id);
        $blood_id = intval($request->blood_id);
        $request = new $this->request;

        $request->type = 0;
        $request->user_id = $user->id;
        $request->hospital_id = $hospitalId;
        $request->blood_id = $blood_id;

        $request->save();

        return $request;
    }

    public function showDonorUser()
    {
        $user = Auth::user();
        if ($user->hospital_id != null) {
            $hospitalId = $user->hospital_id;
            $request = $this->request->where('hospital_id', $hospitalId)->where('done', 1)->where('type', 0)->first();
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
            return $user;
        } else {
            return 404;
        }
    }
    //admin
    public function showUsersRequest()
    {
        $usersRequset = $this->request->where('type', 0)->get();
        return $usersRequset;
    }

    // //admin
    public function showHospitalsRequest()
    {
        $hospitalsRequset = $this->request->where('type', 1)->get();
        return $hospitalsRequset;
    }

    //anyOne
    public function showRequest($id)
    {
        $request = $this->request->where('id', $id)->first();
        return $request;
    }

    //hospital employee
    public function MyHospitalRequests()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 1)->where('hospital_id', $hospitalId)->get();
        return $request;
    }

    //hospital employee
    public function MyHospitalUsersRequests()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 0)->where('hospital_id', $hospitalId)->get();
        return $request;
    }

    // user request
    public function myUserRequests()
    {
        $userId = auth()->user()->id;
        $request = $this->request->where('type', 0)->where('user_id', $userId)->get();
        return $request;
    }

    public function destroy($id)
    {
        $this->request::findOrFail($id)->delete();
        return response()->noContent();
    }
}
