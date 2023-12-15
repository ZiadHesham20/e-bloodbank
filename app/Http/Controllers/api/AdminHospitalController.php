<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $this->middleware(['auth.basic.once', 'HospitalAdmin']);
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function indexEmployee()
    {
        $adminHospitalId = auth()->user()->hospital_id;
        return $this->user::where('hospital_id', $adminHospitalId)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // make role = 0 and hospital = null
        //
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

            return $user;

            } else {
                return 404;
            }
    }

    public function bloods($id, $type)
    {
        $bloods = Hospital::findOrFail($id)->bloods()->where('type', $type)->orderBy('created_at', 'desc')->get();
        return $bloods;
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
            return $user;
        } else {
            return 404;
        }
        } else {
            return response()->json(['message' => 'can\'t add this user']);
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
            return $user;
        } else {
            return 404;
        }
    }

    //search for emp by name
    public function searchByName(Request $request)
    {
        $authUser = Auth::user();
        $hospitalId = $authUser->hospital_id;
        $user = $this->user::where('name', $request->name)->where('hospital_id', $hospitalId)->get();
        return response()->json($user);
    }

    // feed 

}
