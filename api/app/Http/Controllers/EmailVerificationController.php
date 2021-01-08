<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * EmailVerificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('throttle:5,1');
        $this->middleware('auth:sanctum')->only('resend');
        $this->middleware('signed')->only('verify');
    }

    public function verify(Request $request)
    {
        auth()->loginUsingId($request->id);

        if (auth()->user()->hasVerifiedEmail()) {
            abort(403, 'You have already verified your email');
        }

        if (!hash_equals((string)$request->hash, sha1(auth()->user()->getEmailForVerification()))) {
            abort(403, 'Invalid email verification token');
        }

        $request->user()->markEmailAsVerified();

        return redirect()->to(env('CLIENT_URL'));
    }

    public function resend(Request $request)
    {
        if (!auth()->user()->hasVerifiedEmail()) {
            auth()->user()->sendEmailVerificationNotification();
            return response()->json(['message' => 'Verification mail resent'], 202);
        }

        abort(403, 'Email already verified');
    }
}
