<?php

declare(strict_types=1);

namespace App\Http\Actions\Account;

use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\AccountRepositoryInterface;

abstract class AccountAction extends BaseAction
{
    protected AccountRepositoryInterface $accountRepository;

    public function __construct(AccountRepositoryInterface $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }
}
