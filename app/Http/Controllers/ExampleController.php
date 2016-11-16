<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class ExampleController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function show()
    {
        try {
            $user = JWTAuth::parseToken()->toUser();
            if (! $user) {
                return response()->json(['error' => 'User not found'], 400);
            }
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token is invalid'], 401);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (TokenBlacklistedException $e) {
            return response()->json(['error' => 'Token is blacklisted'], 401);
        }

         return response()->json($user);
    }

    public function getToken()
    {
        $token = JWTAuth::getToken();
        if (! $token) {
            return response()->json(['error' => 'Token is invalid'], 401);
        }
        try {
            $refreshedToken = JWTAuth::refresh($token);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Something went wrong'], 400);
        }

        return response()->json($refreshedToken);
    }

    public function destroy()
    {
        $user = JWTAuth::parseToken()->authenticate();
        if (! $user) {
            return response()->json(['error' => 'Fail the delete provess'], 401);
        }
        $user->delete();
    }
}
