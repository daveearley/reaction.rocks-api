<?php

namespace App\Http\Request\Reaction;

use App\Http\Request\BaseRequest;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use App\Validator\ReactionValidator;

class CreateReactionRequest extends BaseRequest
{
    public function rules(CampaignRepositoryInterface $campaignRepository)
    {
        $campaign = $campaignRepository->findById($this->route()->parameter('campaign_id'));
        return (new ReactionValidator($campaign))->rules();
    }
}