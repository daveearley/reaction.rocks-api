<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\AccountOwnerScope;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Account extends BaseModel implements JWTSubject, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Notifiable;
    use \Illuminate\Auth\Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use MustVerifyEmail;

    protected static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            static::addGlobalScope(new AccountOwnerScope);
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
