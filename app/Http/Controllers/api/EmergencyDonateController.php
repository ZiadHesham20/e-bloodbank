<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\EmergencyDonate;
use App\Models\EmergencyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyDonateController extends Controller
{
    public $emergencyDonate;

    public function __construct(EmergencyDonate $emergencyDonate)
    {
        $this->emergencyDonate = $emergencyDonate;
        $this->middleware('auth.basic.once');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = $this->emergencyDonate::paginate(12);
        return response()->json($req, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $req = $this->emergencyDonate::findOrFail($id);
        return response()->json($req, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmergencyDonate $emergencyDonate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmergencyDonate $emergencyDonate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->emergencyDonate::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted successfuly'], 200);
    }

    public function emergencyDonate($id)
    {
        $emergencyRequest = EmergencyRequest::findOrFail($id);
        $user = Auth::user();

        $donate = new $this->emergencyDonate;
        $donate->user_id = $user->id; // Use the user's ID
        $donate->emergency_id = $emergencyRequest->id;
        $donate->save();

        return response()->json($donate, 200);
    }

    public function history()
    {
        $user = Auth::user();
        $myDonate = $this->emergencyDonate->where('user_id', $user->id)->get();
        return response()->json($myDonate, 200);
    }
}
