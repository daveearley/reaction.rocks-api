<?php

namespace App\Http\Actions\Auth;

use App\Http\Actions\BaseAction;

abstract class AbstractAuthAction extends BaseAction
{
    protected function respondWithToken(string $token)
    {
        $account = auth()->user();

        return $this
            ->getResponseBuilder()
            ->withData(
                [
                    'token' => $token,
                    'token_type' => 'bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                    'user' => [
                        'id' => $account->id,
                        'first_name' => $account->first_name,
                        'last_name' => $account->last_name,
                        'email' => $account->email
                    ]
                ]
            )
            ->response();
    }
}
