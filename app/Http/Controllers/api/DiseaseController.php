<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiseaseResource;
use App\Models\Disease;
use Illuminate\Http\Request;

class DiseaseController extends Controller
{
    public $disease;

    public function __construct(Disease $disease)
    {
        $this->disease = $disease;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disease = DiseaseResource::collection($this->disease::all());
        return $disease->response()->setStatusCode(200);
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
        $disease = new $this->disease;
        $disease = $this->disease::create($request->all());
        // Create a new UserResource instance
        $diseaseResource = new DiseaseResource($disease);

        // Return the transformed data as a JSON response with a 201 status code
        return $diseaseResource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $disease = $this->disease::findOrFail($id);
        // Create a new UserResource instance
        $diseaseResource = new DiseaseResource($disease);

        // Return the transformed data as a JSON response with a 201 status code
        return $diseaseResource->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disease $disease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $disease = $this->disease::findOrFail($id);
        $disease->update($request->all());
        // Create a new UserResource instance
        $diseaseResource = new DiseaseResource($disease);

        // Return the transformed data as a JSON response with a 201 status code
        return $diseaseResource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->disease::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted'], 200);
    }
}
