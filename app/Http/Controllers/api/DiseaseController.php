<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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
        $disease = $this->disease::all();
        return $disease;
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
        return $disease;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $disease = $this->disease::findOrFail($id);
        return $disease;
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
        return $disease;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->disease::findOrFail($id)->delete();
        return 204;
    }
}
