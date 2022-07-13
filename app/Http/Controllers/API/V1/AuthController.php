<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function signin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $authUser = Auth::user();
            $success['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
            $success['name'] = $authUser->name;

            return $this->sendResponse($success, 'User signed in');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function signup(Request $request)
    {
        $validator = $this->getValidationFactory()
            ->make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User($input);
        $user->save();
        $success['token'] = $user->createToken('MyAuthApp')->plainTextToken;
        $success['name'] = $user->name;

        return $this->sendResponse($success, 'User created successfully.');
    }

}
