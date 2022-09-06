<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
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

    public function resolveRouteBinding($value, $field = null): ?Model
    {
        return $this->where('username', $value)->firstOrFail();
    }

    /**
     * Encrypt password before saving it.
     *
     * @return Attribute
     */
    public function password(): Attribute
    {
        return Attribute::set( fn($value) => is_null($value) ? null : bcrypt($value) );
    }

    /**
     * Get the avatar with the url path.
     *
     * @return Attribute
     */
    public function avatar(): Attribute
    {
        return Attribute::get( fn($value) => url(Storage::url($value)));
    }
}
