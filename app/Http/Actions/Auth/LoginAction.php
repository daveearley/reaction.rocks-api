<?php

declare(strict_types=1);

namespace App\Http\Actions\Auth;

use App\Http\ResponseCodes;
use Illuminate\Http\Request;

class LoginAction extends AbstractAuthAction
{
    public function __invoke(Request $request)
    {
        $credentials = request(['email', 'password']);

        if ($token = (string)auth()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }

        return $this->getResponseBuilder()
            ->withData(['error' => __('Username or Password are incorrect')])
            ->withResponseCode(ResponseCodes::HTTP_UNAUTHORIZED)
            ->response();
    }
}
