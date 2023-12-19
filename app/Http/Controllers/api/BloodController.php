<?php

namespace App\Http\Controllers;

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
        $bloods = $this->blood::all();
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
    public function show(Blood $blood)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blood $blood)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $blood = $this->blood::findOrFail($id);
        $blood->update($request->price);
        return $blood;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blood $blood)
    {
        //
    }
}
