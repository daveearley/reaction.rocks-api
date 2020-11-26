<?php

declare(strict_types=1);

namespace App\Http\Actions\Account;

use Illuminate\Http\Response;

class GetAccountAction extends AccountAction
{
    public function __invoke(int $accountId): Response
    {
        $account = $this->accountRepository->findById($accountId);

        return $this
            ->getResponseBuilder()
            ->withData($account)
            ->response();
    }
}
