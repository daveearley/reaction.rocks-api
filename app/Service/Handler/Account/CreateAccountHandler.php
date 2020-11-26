<?php

declare(strict_types=1);

namespace App\Service\Handler\Account;

use App\DomainObjects\AccountDomainObject;
use App\Queue\Dispatcher;
use App\Queue\Jobs\AccountCreatedJob;
use App\Repository\Interfaces\AccountRepositoryInterface;
use Illuminate\Hashing\HashManager;

class CreateAccountHandler
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

    public function execute(array $accountData): AccountDomainObject
    {
        $passwordHash = $this->hashManager->make($accountData['password']);
        $account = $this->accountRepository->create(
            array_merge($accountData, ['password' => $passwordHash])
        );

        $this->dispatcher->dispatchJob(new AccountCreatedJob($account));

        return $account;
    }
}
