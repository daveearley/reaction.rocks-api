<?php

namespace App\Service\Handler\Account;

use App\DomainObjects\AccountDomainObject;
use App\Queue\Dispatcher;
use App\Queue\Jobs\AccountCreatedJob;
use App\Repository\Interfaces\AccountRepositoryInterface;
use Illuminate\Hashing\HashManager;

class UpdateAccountHandler
{
    private AccountRepositoryInterface $accountRepository;
    private Dispatcher $dispatcher;
    private HashManager $hashManager;

    public function __construct(
        AccountRepositoryInterface $accountRepository,
        Dispatcher $dispatcher,
        HashManager $hashManager
    )
    {
        $this->accountRepository = $accountRepository;
        $this->dispatcher = $dispatcher;
        $this->hashManager = $hashManager;
    }

    public function execute(int $accountId, array $accountData): AccountDomainObject
    {
        if (isset($accountData['new_password'])) {
            $accountData['password'] = $this->hashManager->make($accountData['new_password']);
        }

        $account = $this->accountRepository->updateFromArray($accountId, $accountData);

        $this->dispatcher->dispatchJob(new AccountCreatedJob($account));

        return $account;
    }
}
