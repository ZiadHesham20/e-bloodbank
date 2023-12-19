<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Resources\UsersResource;
use App\Models\EmergencyDonate;
use App\Models\EmergencyRequest;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->middleware('Admin')->except('show', 'index', 'update', 'destroy');
        $this->middleware('SuperAdmin')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return $this->user::paginate(12);
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

        // return UsersResource::make($user);
        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, User $user)
    {
        $user->update($request->all());

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    // approve or not to create hospital -- super admin
    public function Approved($id)
    {
        $hospital = Hospital::findOrFail($id);
        if ($hospital->approved == 0)
        {
            $hospital->approved = 1;
            $hospital->save();
            return response()->json($hospital, 200);
        }
        elseif ($hospital->approved == 1) {
            $hospital->approved = 0;
            $hospital->save();
            return response()->json($hospital, 200);
        }
        else
        {
            return response('This action is unavailable', 409);
        }
    }


    // block user - hospital
    public function BlockUser($id)
    {
        $user = $this->user::findOrFail($id);
        if ($user->block == 0)
        {
            $user->block = 1;
            $user->save();
            return response()->json($user, 200);
        }
        elseif ($user->block == 1) {
            $user->block = 0;
            $user->save();
            return response()->json($user, 200);
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

        return response()->json($user, 200);
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
        return response()->json($user, 200);
    }

    // function make user role = 0
    public function changeRoleToDefualtUser($id)
    {
        $user = $this->user::findOrFail($id);
        $user->role = 0;
        $user->save();

        // // Create a new UserResource instance
        // $userResource = new UserResource($user);

        // // Return the transformed data as a JSON response with a 201 status code
        // return $userResource->response()->setStatusCode(200);
        return response()->json($user, 200);
    }

    // emergency donor with cash
    // the user how need blood can send request to emergencies donor and send what blood he need and dateTime and location
}

