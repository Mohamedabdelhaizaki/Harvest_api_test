<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\API;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\Api\LoginResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $loginCredentials = $request->safe()->only(['email', 'password']);
        if (Auth::attempt($loginCredentials)) {
            $user = Auth::user();
            $token =  $user->createToken('HarvestSanctumAuth')->plainTextToken;
            data_set($user, 'token', $token);

            return (new API)
                ->isOk('Successful Login')
                ->setData((new LoginResource($user)))
                ->build();
        } else {

            return (new API)
                ->isError('Invalid login credentials')
                ->setStatus(403)
                ->build();
        }
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return (new API)
            ->isOk('Successful Logout')
            ->build();
    }
}
