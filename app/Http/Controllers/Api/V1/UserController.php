<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
    public function profile() : JsonResponse
    {
        $user_info = Auth::user();

        return $this->sendResponse($user_info, 'User information.');
    }
    
    public function update(Request $request) : JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'bio' => 'required',
            'email' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Error! ', $validator->errors());
        }

        $user = User::find(Auth::id());

        $user->update([
            'name' => $input['name'],
            'bio' => $input['bio'],
            'email' => $input['email'],
        ]);

        $user->save();

        return $this->sendResponse($user, 'User information edited.');
    }
}
