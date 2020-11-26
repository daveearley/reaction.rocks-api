<?php

namespace App\Http\Actions\Auth;

use App\DomainObjects\AccountDomainObject;

class MeAction extends AbstractAuthAction
{
    public function __invoke()
    {
        return $this
            ->getResponseBuilder()
            ->withData(AccountDomainObject::hydrate(auth()->user()))
            ->response();
    }
}
