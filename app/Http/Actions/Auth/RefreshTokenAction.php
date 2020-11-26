<?php

namespace App\Http\Actions\Auth;

class RefreshTokenAction extends AbstractAuthAction
{
    public function __invoke()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
