<?php

namespace App\Http\Actions\Auth;

class LogoutAction
{
    public function __invoke()
    {
        auth()->logout();

        return response()->json(['message' => __('Successfully logged out')]);
    }
}
