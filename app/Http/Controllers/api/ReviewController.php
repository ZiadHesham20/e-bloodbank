<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public $review;

    public function __construct(Review $review)
    {
        $this->middleware('auth:sanctum');
        $this->review = $review;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->review::paginate(12);
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
        if ($request->user()->reviews()->whereHospital_id($request->hospital_id)->exists()) {
            // return response()->json('fail', 200);
            return 404;
        }
        $review = $this->review::create($request->all()+ ['user_id' => auth()->id()]);
        // return response()->json(['review' => $review], 201);
        return $review;
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
