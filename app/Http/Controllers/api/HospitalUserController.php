<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HospitalUserResource;
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
        $this->middleware('auth:sanctum');

        $this->middleware('HospitalAdmin')->only('requestBloods', 'hospitalFinishRequest');
        $this->middleware('Employee')->only('showDonorUser', 'MyHospitalRequests', 'MyHospitalUsersRequests', 'requestUserDone', 'hospitalPayment', 'hospitalFinishRequest', 'showUserRequestBloodsInHospital', 'UserRequestBloodsDone');
        $this->middleware('Admin')->only('showUserRequestBloods', 'showHospitalsRequest', 'showUsersRequest', 'showRequest');
        $this->request = $request;
    }
    // ->only('requestBloods', 'showDonorUser', 'MyHospitalRequests', 'MyHospitalUsersRequests', 'myUserRequests', 'requestDonate', 'hospitalPayment', 'requestUserDone', 'hospitalFinishRequest');

    // ziad
    public function index()
    {
        $req = HospitalUserResource::collection($this->request::paginate(12));
        return $req->response()->setStatusCode(200);
    }

    // type -> 1 hospital need blood
    public function requestBloods(Request $request)
    {
        $user = Auth::user();
        $hospitalId = $user->hospital_id;
        $req = new $this->request;

        $req->type = 1;
        $req->user_id = $user->id;
        $req->hospital_id = $hospitalId;
        $req->blood_id = $request->blood_id;
        $req->count = $request->count;;

        $req->save();

        // Create a new UserResource instance
        $reqResource = new HospitalUserResource($req);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(201);
    }

    //
    public function showHospitalsRequest()
    {
        $hospitalsRequset = $this->request->where('type', 1)->get();
        // Create a new UserResource instance
        $reqResource = new HospitalUserResource($hospitalsRequset);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }

    //hospital employee  policy
    public function MyHospitalRequests()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 1)->where('hospital_id', $hospitalId)->get();
        // Create a new UserResource instance
        $reqResource = new HospitalUserResource($request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }

    // make hospital request done = 1 when finish
    public function hospitalFinishRequest($id)
    {
        $hospitalEmp = auth()->user();
        $Request = $this->request::findOrFail($id);
        if($hospitalEmp->hospital_id == $Request->hospital_id && $Request->type == 1) {
            $Request->done = 1;
            $Request->save();
            // Create a new UserResource instance
            $reqResource = new HospitalUserResource($Request);

            // Return the transformed data as a JSON response with a 201 status code
            return $reqResource->response()->setStatusCode(200);
        }
        else {
            return response()->json(['message' => 'you are not authorized!'], 404);
        }
    }

    // type 0 -> user need donate
    public function requestDonate(Request $request)
    {
        $user = Auth::user();
        // if user donatable is 1 and last dontion > 6 months can do it
        // Check if the user is marked as donatable
        if ($user->donatable == 1) {
            // Check if the last donation was more than 6 months ago
            $lastDonation = Carbon::parse($user->donation_date); // Assuming you have a 'donations' relationship

            if ($lastDonation->addMonths(6)->isPast()) {
                $hospitalId = intval($request->hospital_id);
                $blood_id = intval($request->blood_id);
                $req = new $this->request;

                $req->type = 0;
                $req->user_id = $user->id;
                $req->hospital_id = $hospitalId;
                $req->blood_id = $blood_id;

                $req->save();
                // Create a new UserResource instance
                $reqResource = new HospitalUserResource($req);

                // Return the transformed data as a JSON response with a 201 status code
                return $reqResource->response()->setStatusCode(201);
            }
        }
        return response()->json(['message' => 'you can not donate now'], 200); // User cannot donate blood
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
            // Create a new UserResource instance
            $userResource = new HospitalUserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $userResource->response()->setStatusCode(200);
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
        $usersRequest = $this->request->where('type', 0)->get();
        // Create a new UserResource collection instance
        $usersRequestResource = HospitalUserResource::collection($usersRequest);

        // Return the transformed data as a JSON response with a 200 status code
        return $usersRequestResource->response()->setStatusCode(200);
    }


    //anyOne
    public function showRequest($id)
    {
        $request = $this->request->where('id', $id);
        $reqResource = new HospitalUserResource($request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }


    //hospital employee policy
    public function MyHospitalUsersRequests()
    {
        $hospitalId = auth()->user()->hospital_id;
        $request = $this->request->where('type', 0)->where('hospital_id', $hospitalId)->get();
        $reqResource = new HospitalUserResource($request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }

    // user request
    public function myUserRequests()
    {
        $userId = auth()->user()->id;
        $request = $this->request->where('type', 0)->where('user_id', $userId)->get();
        $reqResource = new HospitalUserResource($request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
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
            $reqResource = new HospitalUserResource($requestId);

            // Return the transformed data as a JSON response with a 201 status code
            return $reqResource->response()->setStatusCode(200);

        } else {

            return 404;

        }
    }

    // show payments   ---- emp in hosp
    // public function hospitalPayment()
    // {
    //     $hospitalId = auth()->user()->hospital_id;
    //     $request = $this->request->where('type', 2)->where('hospital_id', $hospitalId)->where('done', 1)->get();
    //     return $request;
    // }


    // search requset by id
    public function search(Request $request)
    {
        $Request = $this->request::where('id', $request->term)->get();
        $reqResource = new HospitalUserResource($Request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }


    // type -> 2 users need blood

    // make request
    public function userRequestBloods(Request $request)
    {
        // add num of bloods need ??
        $user = Auth::user();
        $userRequest = new $this->request;

        $userRequest->type = 2;
        $userRequest->user_id = $user->id;
        $userRequest->hospital_id = $request->hospital_id;
        $userRequest->blood_id = $request->blood_id;
        $userRequest->count = $request->count;

        $userRequest->save();

        $reqResource = new HospitalUserResource($userRequest);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(201);
    }

    // show all requests
    public function showUserRequestBloods()
    {
        $usersRequset = $this->request->where('type', 2)->get();
        $reqResource = new HospitalUserResource($usersRequset);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }

    // show all requests
    public function showUserRequestBloodsInHospital()
    {
        $hospitalId = Auth::user()->hospital_id;
        $usersRequset = $this->request->where('type', 2)->where('hospital_id', $hospitalId)->get();
        $reqResource = new HospitalUserResource($usersRequset);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }


    // show my request
    public function myUserRequestBloods()
    {
        $user = auth()->user();
        $request = $this->request->where('type', 2)->where('user_id', $user->id)->get();
        $reqResource = new HospitalUserResource($request);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
    }

    // delete this request
    public function destroymyUserRequestBloods($id)
    {
        $request = $this->request::findOrFail($id);
        $user = auth()->user();
        if ($user->id == $request->user_id || $user->role >= 2) {
            $request->delete();
            return response()->json(['message' => 'deleted'], 200);
        }
        else {
            return response()->json(['message' => 'you not allow to delete this request'], 404);
        }
    }

    // request done
    public function UserRequestBloodsDone($id)
    {
        $hospitalEmp = auth()->user();
        $requestId = $this->request::findOrFail($id);

        if ($hospitalEmp->hospital_id == $requestId->hospital_id && $requestId->done == 0 && $requestId->type == 2){

            $requestId->done = 1;
            $requestId->save();
            $reqResource = new HospitalUserResource($requestId);

            // Return the transformed data as a JSON response with a 201 status code
            return $reqResource->response()->setStatusCode(200);

        }
        else {

            return response()->json(['message' => 'you not allow to do this'], 404);

        }
    }
}
