<?php

namespace App\Http\Controllers\Api\Auth;

use App\Helpers\UserHelper;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class Login extends Controller
{
    public function authenticate(LoginRequest $request)
    {
//        authenticate the user
        if (!auth()->attempt(['username' => $request->username, 'password' => $request->password])) {
            return $this->failedResponse(message: 'Invalid credentials!');
        }

//        get the user details with the generated token
        $user = UserHelper::generateApiToken();

        return $this->successResponse(data: $user, message: 'Sign in successful!');
    }
}
