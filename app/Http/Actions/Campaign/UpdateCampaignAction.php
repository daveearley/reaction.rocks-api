<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Http\Request\Campaign\UpdateCampaignRequest;
use App\Service\Handler\Campaign\UpdateCampaignHandler;

class UpdateCampaignAction extends BaseAction
{
    private UpdateCampaignHandler $handler;

    public function __construct(UpdateCampaignHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(UpdateCampaignRequest $request, int $campaignId)
    {
        return $this
            ->getResponseBuilder()
            ->withData($this->handler->execute($campaignId, $request->all()))
            ->createdResponse();
    }
}