<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\CampaignRepositoryInterface;

class GetCampaignAction extends BaseAction
{
    public function __invoke(int $campaignId, CampaignRepositoryInterface $campaignRepository)
    {
        return $this
            ->getResponseBuilder()
            ->withData($campaignRepository->findFirst($campaignId))
            ->response();
    }
}