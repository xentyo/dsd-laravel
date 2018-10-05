<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Parser;
use Validator;

class UserController extends Controller
{
    protected $loginRules = [
        'email' => 'required|email|exists:users,email',
        'password' => 'required',
    ];
    protected $registerRules = [
        'name' => 'required|min:2|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|max:255',
        'confirmation_password' => 'required|min:8|max:255',
    ];

    public function register(Request $request)
    {
        $params = $request->only('name', 'email', 'password', 'confirmation_password');
        $validator = Validator::make($params, $this->registerRules);
        if (!$validator->fails()) {
            $user = new User([
                'name' => $params['name'],
                'email' => $params['email'],
                'password' => Hash::make($params['password']),
            ]);
            $user->save();
            return response($user, 200);
        } else {
            return response(['errors' => $validator->messages()], 401);
        }
    }

    public function login(Request $request)
    {
        $params = $request->only('email', 'password');
        $validator = Validator::make($params, $this->loginRules);
        if ($validator->fails()) {
            return response($validator->messages());
        } else {
            $email = $params['email'];
            $password = $params['password'];
            if (!Auth::attempt(['email' => $email, 'password' => $password])) {
                return response()->json(['error' => 'Invalid email or Password']);
            }

            $token = ['token' => Auth::user()->createToken('Laravel Password Grand Client')->accessToken];
            return response($token, 200);
        }
    }

    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();

        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function show(Request $request)
    {
        return response($request->user());
    }
}
