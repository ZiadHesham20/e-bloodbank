<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public $medicine;

    public function __construct(Medicine $medicine)
    {
        $this->medicine = $medicine;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $medicine = MedicineResource::collection($this->medicine::all());
        return $medicine->response()->setStatusCode(200);
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
        $medicine = new $this->medicine;
        $medicine = $this->medicine::create($request->all());
        $medicineResource = new MedicineResource($medicine);

        // Return the transformed data as a JSON response with a 201 status code
        return $medicineResource->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicine = $this->medicine::findOrFail($id);
        $medicineResource = new MedicineResource($medicine);

        // Return the transformed data as a JSON response with a 201 status code
        return $medicineResource->response()->setStatusCode(200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicine $medicine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $medicine = $this->medicine::findOrFail($id);
        $medicine->update($request->all());
        $medicineResource = new MedicineResource($medicine);

        // Return the transformed data as a JSON response with a 201 status code
        return $medicineResource->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->medicine::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted'], 200);
    }
}
