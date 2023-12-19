<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\HospitalUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HospitalUserController extends Controller
{
    public $request;

    public function __construct(HospitalUser $request)
    {
        $this->middleware('auth:sanctum')->only('requestBloods', 'showDonorUser', 'MyHospitalRequests', 'MyHospitalUsersRequests', 'myUserRequests', 'requestDonate', 'hospitalPayment', 'requestUserDone', 'hospitalFinishRequest');
        $this->middleware('HospitalAdmin')->only('requestBloods', 'showDonorUser', 'hospitalFinishRequest');
        $this->middleware('Employee')->only('requestBloods', 'showDonorUser', 'hospitalFinishRequest', 'MyHospitalRequests', 'MyHospitalUsersRequests', 'requestUserDone', 'hospitalPayment', 'hospitalFinishRequest');
        $this->request = $request;
    }

    // ziad
    public function index()
    {
        return $this->request::paginate(12);
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
        // if user donatable is 1 and last dontion > 6 months can do it
        {
            // Check if the user is marked as donatable
            if ($user->donatable == 1) {
                // Check if the last donation was more than 6 months ago
                $lastDonation = Carbon::parse($user->donation_date); // Assuming you have a 'donations' relationship

                if ($lastDonation->addMonths(6)->isPast()) {
                    $hospitalId = intval($request->hospital_id);
                    $blood_id = intval($request->blood_id);
                    $request = new $this->request;

                    $request->type = 0;
                    $request->user_id = $user->id;
                    $request->hospital_id = $hospitalId;
                    $request->blood_id = $blood_id;

                    $request->save();

                    return $request;
                    // User can donate blood
                }
            }
            return response()->json(['message' => 'you can not donate now'], 200); // User cannot donate blood
        }
    }
    // ??
    public function showDonorUser()
    {
        $user = Auth::user();
        $hasRequsets = $this->request->where('user_id', $user->id)->count();
        if ($user->hospital_id != null && $hasRequsets > 0) {
            $hospitalId = $user->hospital_id;
            $request = $this->request->where('hospital_id', $hospitalId)->where('done', 1)->where('type', 0)->get();
            $userId = $request->user_id;
            $user = User::findOrFail($userId);
            return $user;
        }
        elseif($hasRequsets == 0) {
            return response()->json(['error' => 'you must be a donar to see this page'], 422);
        }
        else {
            return 404;
        }
    }
    //
    public function showUsersRequest()
    {
        $usersRequset = $this->request->where('type', 0)->get();
        return $usersRequset;
    }

    //
    public function showHospitalsRequest()
    {
        $hospitalsRequset = $this->request->where('type', 1)->get();
        return $hospitalsRequset;
    }

    //anyOne
    public function showRequest($id)
    {
        $request = $this->request->where('id', $id);
        return $request;
    }

    //hospital employee  policy
    public function MyHospitalRequests()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 1)->where('hospital_id', $hospitalId)->get();
        return $request;
    }

    //hospital employee policy
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
    // policy   ---- emp in hosp
    public function destroy($id)
    {
        $user = Auth::user();
        $req = $this->request::findOrFail($id);
        if($req->user_id = $user->id || $user->role > 1) {
            $req->delete();
            return response()->json(['message' => 'deleted'], 200);
        }
    }

    // make user request done = 1 after donate  ---- emp in hosp
    public function requestUserDone($id)
    {
        $hospitalEmp = auth()->user();
        $requestId = $this->request::findOrFail($id);

        if ($hospitalEmp->hospital_id == $requestId->hospital_id && $requestId->done == 0 && $requestId->type == 0){

            $requestId->done = 1;
            $requestId->save();
            $donor = User::findOrFail($requestId->user_id);
            $donor->points += 500;
            $donor->donation_date = Carbon::now();
            $donor->save();
            return $requestId;

        } else {

            return 404;

        }
    }

    // show payments   ---- emp in hosp
    public function hospitalPayment()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 2)->where('hospital_id', $hospitalId)->where('done', 1)->get();
        return $request;
    }

    // make hospital request done = 1 when finish
    public function hospitalFinishRequest($id)
    {
        $hospitalEmp = auth()->user();
        $Request = $this->request::findOrFail($id);
        if($hospitalEmp->hospital_id == $Request->hospital_id && $Request->type == 1) {
            $Request->done = 1;
            $Request->save();
            return $Request;
        }
        else {
            return ['error' => 'you are not authorized'];
        }
    }

    // search requset by id
    public function search(Request $request)
    {
        $Request = $this->request::where('id', $request->term)->get();
        return $Request;
    }
}
