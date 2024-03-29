<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmergencyDonateResource;
use App\Models\EmergencyDonate;
use App\Models\EmergencyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyDonateController extends Controller
{
    public $emergencyDonate;

    public function __construct(EmergencyDonate $emergencyDonate)
    {
        $this->middleware('auth:sanctum');
        $this->emergencyDonate = $emergencyDonate;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = $this->emergencyDonate::paginate(12);
        $reqResource = EmergencyDonateResource::collection($req);
        return $reqResource->response()->setStatusCode(200);
        // return $req;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $req = $this->emergencyDonate::findOrFail($id);
        // Create a new UserResource instance
        $reqResource = new EmergencyDonateResource($req);

        // Return the transformed data as a JSON response with a 201 status code
        return $reqResource->response()->setStatusCode(200);
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
        $emergencyRequest->quantity-= 1;
        if ($emergencyRequest->quantity == 0) {
            $emergencyRequest->done = 1;
        }
        $emergencyRequest->save();

        // Create a new UserResource instance
        $donateResource = new EmergencyDonateResource($$donate);

        // Return the transformed data as a JSON response with a 201 status code
        return $donateResource->response()->setStatusCode(201);
    }

    public function history()
    {
        $user = Auth::user();
        $myDonate = $this->emergencyDonate->where('user_id', $user->id)->get();
        // Create a new UserResource instance
        $myDonateResource = EmergencyDonateResource::collection($myDonate);

        // Return the transformed data as a JSON response with a 201 status code
        return $myDonateResource->response()->setStatusCode(200);
    }
}
