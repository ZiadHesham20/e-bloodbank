<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BloodResource;
use App\Models\Blood;
use Illuminate\Http\Request;

class BloodController extends Controller
{
    public $blood;

    public function __construct(Blood $blood)
    {
        $this->blood = $blood;
        $this->middleware(['Admin', 'auth:sanctum']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bloods = BloodResource::collection($this->blood::all());
        return $bloods->response()->setStatusCode(200);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blood = $this->blood::findOrFail($id);
        $blood->price = $request->price;
        $blood->save();
        // Create a new UserResource instance
        $bloodResource = new BloodResource($blood);

        // Return the transformed data as a JSON response with a 201 status code
        return $bloodResource->response()->setStatusCode(200);
    }
}
