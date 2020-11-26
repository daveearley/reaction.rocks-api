<?php

declare(strict_types=1);

namespace App\Queue\Jobs;

use App\DomainObjects\AccountDomainObject;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AccountCreatedJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * @var AccountDomainObject
     */
    private AccountDomainObject $account;

    /**
     * @param AccountDomainObject $account
     */
    public function __construct(AccountDomainObject $account)
    {
        $this->account = $account;
    }

    public function handle()
    {
        Log::alert('hello');
    }
}
