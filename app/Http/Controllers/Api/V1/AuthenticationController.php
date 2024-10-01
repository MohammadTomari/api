<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|min:11|max:12',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Error! ', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $result['name'] = $user->name;
        $result['token'] = $user->createToken('api')->accessToken;

        return $this->sendResponse($result, 'User registered.');
    }

    public function login(Request $request) : JsonResponse
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]))
        {
            $user = Auth::user();
            $result['name'] = $user->name;
            $result['token'] = $user->createToken('api')->accessToken;

            return $this->sendResponse($result, 'User logged in.');
        }
        else
        {
            return $this->sendError('Unauthorized.', ['error' => 'Authentication failed!']);
        }
    }
}
