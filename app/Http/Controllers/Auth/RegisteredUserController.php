<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    // public function __construct(User $user)
    // {
    //     $this->middleware('auth:sanctum');
    // }
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'blood_id' => 'required',
            'age' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'location' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'blood_id' => $request->blood_id,
            'age' => $request->age,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'location' => $request->location,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // $token = $request->user()->createToken($request->token_name);
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user_id' => $user->id]);
        // return response()->json(['token' => 'token'], 200);
    }
}
