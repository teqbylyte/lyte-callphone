<?php

namespace App\Helpers;

use Carbon\Carbon;

class UserHelper
{
    /**
     * Create the api access token for the authenticated user to be used in authenticating api requests
     *
     * @return array An array containing the auth user details and the generated token
     */
    public static function generateApiToken(): array
    {
        $user = auth()->user();

        // create token for this user.
        $tokenObject = $user->createToken("$user->username personal token", ['*']);

        // save user token
        $tokenObject->token->save();

        $access_token = [
            'token' => $tokenObject->accessToken,
            'type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenObject->token->expires_at)->toDateTimeString()
        ];

        $user = $user->only('id', 'name', 'username', 'email', 'avatar');
        $user['auth'] = $access_token;

        return $user;
    }
}
