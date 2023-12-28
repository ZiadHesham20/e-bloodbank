<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HospitalResource;
use App\Models\Hospital;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HospitalController extends Controller
{
    public $hospital;

    public function __construct(Hospital $hospital)
    {
        $this->middleware('auth:sanctum')->except('index', 'show');
        $this->middleware('HospitalAdmin')->only('update');
        $this->middleware('SuperAdmin')->only('destroy', 'Approved', 'BlockHospital');
        $this->hospital = $hospital;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // where approved
        $hospitals = HospitalResource::collection($this->hospital::where('approved', 1)->where('block', 0)->paginate(12));
        return $hospitals->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'cover_image' => 'image|required',
        //     'about' => 'required',
        //     'email' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        // ]);

        $hospital = new $this->hospital;

        // $hospital->name = $request->name;
        // // $hospital->cover_image = $this->uploadImage( $request->cover_image );
        // $hospital->about = $request->about;
        // $hospital->email = $request->email;
        // $hospital->phone = $request->phone;
        // $hospital->address = $request->address;
        // $hospital->latitude = $request->latitude;
        // $hospital->longitude = $request->longitude;
        // $hospital->save();

        $hospital = $this->hospital::create($request->all());
        // the user create hospital his role = 1
        // Update the authenticated user
        $user = Auth::user();
        $user->role = 1;
        $user->hospital_id = $hospital->id;
        $user->save();

        // Create a new UserResource instance
        $hospitalResource = new HospitalResource($hospital);

        // Return the transformed data as a JSON response with a 201 status code
        return $hospitalResource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $hospital = $this->hospital::find($id);
        if ($hospital->approved == 1 && $hospital->block ==0) {
            // Create a new UserResource instance
            $hospitalResource = new HospitalResource($hospital);

            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        else {
            return response()->json(['message' => 'this hospital not available'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $hospital = $this->hospital::findOrFail($id);
        // $this->validate($request, [
        //     'name' => 'required',
        //     'cover_image' => 'image|required',
        //     'about' => 'required',
        //     'email' => 'required',
        //     'phone' => 'required',
        //     'address' => 'required',
        // ]);


        // $hospital->name = $request->name;
        // if ($request->has('cover_image')){
        //     Storage::disk('public')->delete($hospital->cover_image);
        //     $hospital->cover_image = $this->uploadImage($request->cover_image);
        // }

        // $hospital->about = $request->about;
        // $hospital->email = $request->email;
        // $hospital->phone = $request->phone;
        // $hospital->address = $request->address;
        // $hospital->latitude = $request->latitude;
        // $hospital->longitude = $request->longitude;
        // $hospital->save();

        $hospital->update($request->all());

        // Create a new UserResource instance
        $hospitalResource = new HospitalResource($hospital);

        // Return the transformed data as a JSON response with a 201 status code
        return $hospitalResource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->hospital::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted'], 200);
    }

    // search by name
    public function searchByName($name)
    {
        $hospital = $this->hospital::where('name','LIKE',$name)->get();
        if ($hospital->approved == 1 && $hospital->block == 0) {
            // Create a new UserResource instance
            $hospitalResource = HospitalResource::collection($hospital);
            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        else {
            return response()->json(['message' => 'this hospital not available'], 404);
        }
    }

    // search by location
    public function searchByaddress($address)
    {
        $hospital = $this->hospital::where('address','LIKE',$address)->get();
        if ($hospital->approved == 1  && $hospital->block == 0) {
            // Create a new UserResource instance
            $hospitalResource = HospitalResource::collection($hospital);
            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        else {
            return response()->json(['message' => 'this hospital is not available'], 404);
        }
    }

    // by default show hospitals in my locaton
    public function getdafaulthospitals()
    {
        $user = User::find(Auth::user()->id);
        $hospital = $this->hospital::where('address','LIKE',$user->location)->where('approved', 1)->where('block', 0)->get();
        // Create a new UserResource instance
        $hospitalResource = HospitalResource::collection($hospital);
        // Return the transformed data as a JSON response with a 201 status code
        return $hospitalResource->response()->setStatusCode(200);
    }

    // approve or not to create hospital -- super admin
    public function Approved($id)
    {
        $hospital = $this->hospital::findOrFail($id);
        if ($hospital->approved == 0)
        {
            $hospital->approved = 1;
            $hospital->save();
            $hospitalResource = new HospitalResource($hospital);

            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        elseif ($hospital->approved == 1) {
            $hospital->approved = 0;
            $hospital->save();
            $hospitalResource = new HospitalResource($hospital);

            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        else
        {
            return response('This action is unavailable', 409);
        }
    }

    public function BlockHospital($id)
    {
        $hospital = $this->hospital::findOrFail($id);
        if ($hospital->block == 0)
        {
            $hospital->block = 1;
            $hospital->save();
            $hospitalResource = new HospitalResource($hospital);

            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        elseif ($hospital->block == 1) {
            $hospital->block = 0;
            $hospital->save();
            $hospitalResource = new HospitalResource($hospital);

            // Return the transformed data as a JSON response with a 201 status code
            return $hospitalResource->response()->setStatusCode(200);
        }
        else
        {
            return response('This action is unavailable', 409);
        }
    }
}
