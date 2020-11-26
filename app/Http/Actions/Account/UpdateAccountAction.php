<?php

namespace App\Http\Actions\Account;

use App\Http\Request\Account\UpdateAccountRequest;
use App\Service\Handler\Account\UpdateAccountHandler;
use Illuminate\Http\Response;

class UpdateAccountAction extends AccountAction
{
    public function __invoke(UpdateAccountRequest $request, UpdateAccountHandler $service): Response
    {
        $accountData = $service->execute(auth()->id(), $request->all());

        return $this
            ->getResponseBuilder()
            ->withData($accountData)
            ->createdResponse();
    }
}
