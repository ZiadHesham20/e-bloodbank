<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Http\Resources\UsersResource;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Users::all();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        $user = Users::create($request->validated());
        return UsersResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = Users::findOrFail($id);
        return response()->json($user);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, Users $ebloodbankuser)
    {
        $ebloodbankuser->update($request->all());

        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Users $ebloodbankuser)
    {
        $ebloodbankuser->delete();
        return response()->noContent();
    }
}
