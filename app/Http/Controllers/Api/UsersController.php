<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    public function uploadAvatar(UserRequest $request, User $user)
    {
        try {
            $path = FileHelper::processFileUpload(file: $request->image, name: $user->username, dir: 'users');

//            if it fails to upload
            if (!$path) return $this->failedResponse(message: 'Image upload failed');

//            if upload is successful
            else {
                $user->avatar = $path;
                $user->save();

                return $this->successResponse(data: ['avatar' => $user->avatar], message: 'Image upload successful!');
            }
        }
        catch (\Exception $e) {
            return $this->failedResponse(message: $e->getMessage());
        }
    }
}
