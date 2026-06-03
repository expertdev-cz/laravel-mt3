<?php

namespace App\Models\AuthorizedAccess;

use App\Notifications\AuthorizedAccessVerifyEmail;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AuthorizedAccessUser extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory;
    use MustVerifyEmail;
    use Notifiable;

    protected $fillable = [
        'name',
        'surname',
        'company',
        'email',
        'phone',
        'login',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
    ];

    public function getFullNameAttribute(): string
    {
        return trim($this->name . ' ' . $this->surname);
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new AuthorizedAccessVerifyEmail());
    }
}