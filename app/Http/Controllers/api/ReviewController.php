<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
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
        $review = ReviewResource::collection($this->review::paginate(12));
        return $review->response()->setStatusCode(200);
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
        $reviewResource = new ReviewResource($review);

        // Return the transformed data as a JSON response with a 201 status code
        return $reviewResource->response()->setStatusCode(201);
    }
}
