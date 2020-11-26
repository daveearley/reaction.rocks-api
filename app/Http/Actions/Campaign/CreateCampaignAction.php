<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Http\Request\Campaign\CreateCampaignRequest;
use App\Service\Handler\Campaign\CreateCampaignHandler;

class CreateCampaignAction extends BaseAction
{
    private CreateCampaignHandler $handler;

    public function __construct(CreateCampaignHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(CreateCampaignRequest $request)
    {
        return $this
            ->getResponseBuilder()
            ->withData($this->handler->execute($request->all()))
            ->createdResponse();
    }
}