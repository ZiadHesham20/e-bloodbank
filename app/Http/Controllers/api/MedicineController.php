<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $medicine = $this->medicine::all();
        return $medicine;
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
        return $medicine;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicine = $this->medicine::findOrFail($id);
        return $medicine;
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
        return $medicine;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->medicine::findOrFail($id)->delete();
        return 204;
    }
}
