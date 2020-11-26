<?php

namespace App\Http\Request\Campaign;

use App\Http\Request\BaseRequest;
use App\Validator\CampaignValidator;

class UpdateCampaignRequest extends BaseRequest
{
    public function rules(CampaignValidator $campaignValidator): array
    {
        return $campaignValidator->rules();
    }
}