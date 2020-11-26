<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\CampaignRepositoryInterface;

class GetCampaignsAction extends BaseAction
{
    public function __invoke(CampaignRepositoryInterface $campaignRepository)
    {
        $campaigns = $campaignRepository->paginate();
        return $this
            ->getResponseBuilder()
            ->withData($campaigns)
            ->response();
    }
}