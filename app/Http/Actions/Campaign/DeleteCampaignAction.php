<?php

namespace App\Http\Actions\Campaign;

use App\Http\Actions\BaseAction;
use App\Repository\Interfaces\CampaignRepositoryInterface;

class DeleteCampaignAction extends BaseAction
{
    public function __invoke(int $campaignId, CampaignRepositoryInterface $campaignRepository)
    {
        $campaignRepository->deleteById($campaignId);
        return $this
            ->getResponseBuilder()
            ->response();
    }
}