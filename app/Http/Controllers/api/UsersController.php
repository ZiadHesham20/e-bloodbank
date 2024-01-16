<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UsersResource;
use App\Models\EmergencyDonate;
use App\Models\EmergencyRequest;
use App\Models\Hospital;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('auth:sanctum');
        $this->middleware('Admin')->except('show', 'index', 'update', 'destroy');
        $this->middleware('SuperAdmin')->only('destroy');
        $this->middleware('HospitalAdmin')->only('makeUserEmergencyDonor', 'deleteUserEmergencyDonor');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = UserResource::collection($this->user::paginate(12));
        return $users->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new $this->user;

        $user = $this->user::create([
            'name' => $request->namee,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'blood_id' => $request->blood_id,
            //'hospital_id' => $request->hospital_id,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'location' => $request->location,
        ]);

        $usersResource = new UserResource($user);

        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $usersResource = new UserResource($user);

        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(200);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = $this->user::findOrFail($id);
        $user->update($request->all());

        $usersResource = new UserResource($user);

        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'deleted'], 200);
    }

    // block user - hospital
    public function BlockUser($id)
    {
        $user = $this->user::findOrFail($id);
        if ($user->block == 0)
        {
            $user->block = 1;
            $user->save();
            $usersResource = new UserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $usersResource->response()->setStatusCode(200);
        }
        elseif ($user->block == 1) {
            $user->block = 0;
            $user->save();
            $usersResource = new UserResource($user);

            // Return the transformed data as a JSON response with a 201 status code
            return $usersResource->response()->setStatusCode(200);
        }
        else
        {
            return response('This action is unavailable', 409);
        }
    }

    // change user role
    public function changeRoleToAdmin($id)
    {
        $user = $this->user::findOrFail($id);
        $user->role = 2;
        $user->save();

        // // Create a new UserResource instance
        // $userResource = new UserResource($user);

        // // Return the transformed data as a JSON response with a 201 status code
        // return $userResource->response()->setStatusCode(200);

        $usersResource = new UserResource($user);

        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(200);
    }

    public function changeRoleToSuperAdmin($id)
    {
        $user = $this->user::findOrFail($id);
        $user->role = 3;
        $user->save();

        // // Create a new UserResource instance
        // $userResource = new UserResource($user);

        // // Return the transformed data as a JSON response with a 201 status code
        // return $userResource->response()->setStatusCode(200);
        $usersResource = new UserResource($user);

        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(200);
    }

    // function make user role = 0
    public function changeRoleToDefualtUser($id)
    {
        $user = $this->user::findOrFail($id);
        $user->role = 0;
        $user->save();
        $usersResource = new UserResource($user);
        // Return the transformed data as a JSON response with a 201 status code
        return $usersResource->response()->setStatusCode(200);
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'profile_photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // image|mimes:jpeg,png,jpg,gif|max:2048
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
            $user->save();
        }

        return response()->json(['success' => 'Profile photo updated successfully.'], 200);
    }

    // add emergency donor to users table
    public function makeUserEmergencyDonor($id) {
        $user = $this->user::findOrFail($id);
        $user->emergency_donor = 1;
        $user->save();
        return response()->json(['message' => 'done'], 200);
    }

    public function deleteUserEmergencyDonor($id) {
        $user = $this->user::findOrFail($id);
        $user->emergency_donor = 0;
        $user->save();
        return response()->json(['message' => 'done'], 200);
    }

    public function showEmergencyDonors()
    {
        $users = UserResource::collection($this->user::where('emergency_donor', 1)->paginate(12));
        return $users->response()->setStatusCode(200);
    }

}

