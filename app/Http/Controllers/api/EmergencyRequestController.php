<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\EmergencyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyRequestController extends Controller
{
    public $emergencyRequest;

    public function __construct(EmergencyRequest $emergencyRequest)
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
        $this->emergencyRequest = $emergencyRequest;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $req = $this->emergencyRequest::paginate(12);
        return response()->json($req, 200);
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
        $this->validate($request, [
            'blood_id' => 'required',
            'phone' => 'required',
            'quantity' => 'required',
            'dateTime' => 'required|date|after:now',
            'city' => 'required',
            'location' => 'required',
        ]);

        $req = new $this->emergencyRequest;

        $req = $this->emergencyRequest::create([
            'user_id' => Auth::User()->id,
            'blood_id' => $request->blood_id,
            'phone' => $request->phone,
            'quantity' => $request->quantity,
            'dateTime' => $request->dateTime,
            'city' => $request->city,
            'location' => $request->location,
        ]);

        return response()->json($req, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $req = $this->emergencyRequest::findOrFail($id);
        return response()->json($req, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmergencyRequest $emergencyRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'blood_id' => 'required',
            'phone' => 'required',
            'quantity' => 'required',
            'dateTime' => 'required|date|after:now',
            'city' => 'required',
            'location' => 'required',
        ]);

        $req = $this->emergencyRequest::findOrfail($id);

        $req->update([
            'blood_id' => $request->blood_id,
            'phone' => $request->phone,
            'quantity' => $request->quantity,
            'dateTime' => $request->dateTime,
            'city' => $request->city,
            'location' => $request->location,
        ]);

        return response()->json($req, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->emergencyRequest::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted successfuly'], 200);
    }

    public function done($id)
    {
        $req = $this->emergencyRequest::findOrFail($id);
            $authUser = Auth::user();
        if ($authUser->id == $req->user_id){
            if ($req->done == 0){
                $req->update(['done'=>1]);
            } elseif ($req->done == 1){
                $req->update(['done'=>0]);
            }
            $req->save();

            return $req;

            } else {
                return 404;
            }
    }

    public function myRequest()
    {
        $user = Auth::user();
        $myDonate = $this->emergencyRequest::where('user_id', $user->id)->get();
        return response()->json($myDonate, 200);
    }
}
