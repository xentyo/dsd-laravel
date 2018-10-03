<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lcobucci\JWT\Parser;
use Validator;
use Auth;

class UserController extends Controller
{
    protected $loginRules = [
        'email' =>  'required|email|exists:users,email',
        'password' => 'required'
    ];

    public function register(Request $request){
        
    }

    public function login(Request $request) {
        $params = $request->only('email', 'password');
        $validator = Validator::make($params, $this->loginRules);
        if($validator->fails())
            return response($validator->messages());
        else {
            $email = $params['email'];
            $password = $params['password'];
            if(!Auth::attempt(['email' => $email, 'password' => $password]))
                return response()->json(['error' => 'Invalid email or Password']);            
            $token = ['token' => Auth::user()->createToken('Laravel Password Grand Client')->accessToken];
            return response($token, 200);            
        }
    }

    public function logout(Request $request) {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getHeader('jti');
        $token = $request->user()->tokens->find($id);
        $token->revoke();

        $response = [ 'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function show(Request $request){
        return response($request->user());
    }
}
