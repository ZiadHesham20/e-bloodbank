<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BloodResource;
use App\Http\Resources\UserResource;
use App\Models\Hospital;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHospitalController extends Controller
{

    public $user;

    public function __construct(User $user)
    {
        $this->middleware('auth:sanctum');
        $this->middleware('HospitalAdmin')->except('searchByName');
        $this->middleware('Employee')->only('searchByName');
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function indexEmployee()
    {
        $adminHospitalId = auth()->user()->hospital_id;
        $users = UserResource::collection($this->user::where('hospital_id', $adminHospitalId)->get());
        return $users->response()->setStatusCode(200);
    }

    public function changeRole($id)
    {
        $user = $this->user::findOrFail($id);
            $authUser = Auth::user();
        if ($authUser->hospital_id == $user->hospital_id){
            if ($user->role == 0){
                $user->update(['role'=>1]);
            } elseif ($user->role == 1){
                $user->update(['role'=>0]);
            }
            $user->save();

            // Create a new UserResource instance
            $userResource = new UserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $userResource->response()->setStatusCode(200);

            } else {
                return response()->json(['message' => 'error', 404]);
            }
    }

    public function addEmployee($id)
    {
        $user = $this->user::findOrFail($id);
        if ($user->hospital_id == null) {
            $authUser = auth()->user();
        if ($authUser->role == 1 && $user != $authUser) {
            $user = $this->user->findOrFail($id);
            $user->hospital_id = $authUser->hospital_id;
            $user->save();
            // Create a new UserResource instance
            $userResource = new UserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $userResource->response()->setStatusCode(200);

        } else {
            return response()->json(['message' => 'error']);
        }
        } else {
            return response()->json(['message' => 'can\'t add this user'], 404);
        }

    }

    public function deleteEmployee($id)
    {
        $authUser = auth()->user();
        $user = $this->user->findOrFail($id);
        if ($authUser->role == 1 && $authUser->hospital_id == $user->hospital_id && $user != $authUser) {
            $user->hospital_id = Null;
            $user->role = 0;
            $user->save();
            // Create a new UserResource instance
            $userResource = new UserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $userResource->response()->setStatusCode(200);
        } else {
            return 404;
        }
    }

    //search for emp by name
    public function searchByName(Request $request)
    {
        $authUser = Auth::user();
        $hospitalId = $authUser->hospital_id;
        if($authUser && $hospitalId) {
            $user = $this->user::where('name', 'like', "%$request->name%")->where('hospital_id', $hospitalId)->get();
            // Create a new UserResource instance
            $userResource = UserResource::collection($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $userResource->response()->setStatusCode(200);
        }
        else {
            return response()->json(['message' => "error"], 404);
        }
    }
}
