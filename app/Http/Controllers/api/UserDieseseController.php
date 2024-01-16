<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\UserDiesese;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDieseseController extends Controller
{
    public $userDiesese;

    public function __construct(UserDiesese $userDiesese)
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->userDiesese::all();
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
        $user = Auth::user();
        $this->validate($request, [
            'hasDisese' => 'required'
        ]);
        $userDiesese = new $this->userDiesese;
        $userDiesese->user_id = $user->id;
        $userDiesese->hasDisese = $request->hasDisese;
        $userDiesese->save();

        if ($request->hasDisese == 1) {
            $user->donatable = 0;
            $user->save();
            return response()->json(['message' => 'you can donate now', 'data' => $userDiesese], 201);
        } else {
            $user->donatable = 1;
            $user->save();
            return response()->json(['message' => 'you can not donate now', 'data' => $userDiesese], 201);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userD = $this->userDiesese::findOrFail($id);
        return $userD;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserDiesese $userDiesese)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userD = $this->userDiesese::findOrFail($id);

        $this->validate($request,[
            'hasDisese' => 'required'
        ]);

        $userD->hasDisese = $request->hasDisese;
        $userD->save();
        return response()->json(['message' => 'updated successfuly', 'data' => $userD], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->userDiesese::findOrFail($id)->delete();
        return response()->json(['message' => 'deleted successfuly'], 200);
    }
}
