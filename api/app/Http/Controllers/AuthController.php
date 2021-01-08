<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\DestroyProfileRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ProfileUpdateRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Resources\Auth\UserResource;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\UnauthorizedException;

class AuthController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['login', 'register']);
    }

    /**
     * Get currently loggedin user via access_token
     * @return UserResource
     */
    public function me()
    {
        return new UserResource(auth()->user());
    }


    /**
     * Register
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create($request->all());
        event(new Registered($user));
        return response()->json(['message' => 'Successfully registered', 'data' => $user], 200);
    }


    /**
     * Login
     * @param LoginRequest $request
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function login(LoginRequest $request)
    {

        if (!auth()->attempt($request->only('email', 'password'))) throw new UnauthorizedException();

        return [
            "token" => auth()->user()->createToken("user-token-" . auth()->id())->plainTextToken
        ];
    }

    /**
     * Logout user
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully'], 200);
    }

    /**
     * Update user profile
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(ProfileUpdateRequest $request)
    {
        auth()->user()->update($request->all());

        return response()->json([
            'message' => 'Profile update successfully'
        ], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->all());
        return response()->json(['message' => 'Password updated'], 200);
    }

    public function destroy(DestroyProfileRequest $request)
    {
        $request->user()->delete();
        return response()->json(['message' => 'Profile deleted'], 200);
    }
}
