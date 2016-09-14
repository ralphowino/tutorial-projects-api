<?php

namespace App\Http\Controllers\Api;

use App\Data\Models\User;
use App\Exceptions\Auth\InvalidCredentialsException;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create(
            [
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);
        return $user;
    }

    public function login(Request $request)
    {
        //Retrieve user based on the credentials provided
        $user = $this->authenticateUser($request);
        //Generate a token for the user and return it
        $token = app(JWTAuth::class)->fromUser($user);
        return ['token' => $token];
    }


    private function authenticateUser($request)
    {
        //Validate request data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Check if a user with this credentials exist, throw error if not
        if (!\Auth::guard()->attempt($request->only('email', 'password'))) {
            throw new InvalidCredentialsException('Invalid email/password combination');
        }

        //Retrieve the user details and return
        return User::where('email', $request->email)->first();
    }
}
