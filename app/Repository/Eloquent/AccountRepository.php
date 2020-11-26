<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\DomainObjects\AccountDomainObject;
use App\Models\Account;
use App\Repository\Interfaces\AccountRepositoryInterface;

class AccountRepository extends BaseRepository implements AccountRepositoryInterface
{
    public function getDomainObject(): string
    {
        return AccountDomainObject::class;
    }

    protected function getModel(): string
    {
        return Account::class;
    }
}
