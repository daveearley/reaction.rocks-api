<?php

declare(strict_types=1);

namespace App\Http\Actions\Account;

use App\Http\Request\Account\CreateAccountRequest;
use App\Service\Handler\Account\CreateAccountHandler;
use Illuminate\Http\Response;

class CreateAccountAction extends AccountAction
{
    public function __invoke(CreateAccountRequest $request, CreateAccountHandler $service): Response
    {
        $accountData = $service->execute($request->all());

        return $this
            ->getResponseBuilder()
            ->withData($accountData)
            ->createdResponse();
    }
}
