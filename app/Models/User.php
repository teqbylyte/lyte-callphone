<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function password(): Attribute
    {
        return Attribute::set( fn($value) => bcrypt($value) );
    }

    public function generateApiToken(): array
    {
        // create token for this user.
        $tokenObject = $this->createToken("$this->username personal token", ['*']);

        // save user token
        $tokenObject->token->save();

        $access_token = [
            'token' => $tokenObject->accessToken,
            'type' => 'Bearer',
            'expires_at' => Carbon::parse($tokenObject->token->expires_at)->toDateTimeString()
        ];

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'username'  => $this->username,
            'email'     => $this->email,
            'auth'      => $access_token,
        ];
    }
}
