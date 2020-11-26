<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Http\Request\Campaign\GetCampaignStatisticsRequest;
use App\Service\Handler\Campaign\GetCampaignStatisticsHandler;

class GetCampaignStatisticsAction extends BaseAction
{
    public function __invoke(
        int $campaignId,
        GetCampaignStatisticsHandler $handler,
        GetCampaignStatisticsRequest $request
    )
    {
        return $this
            ->getResponseBuilder()
            ->withData($handler->execute($campaignId, $request->get('start_date'), $request->get('end_date')))
            ->response();
    }
}