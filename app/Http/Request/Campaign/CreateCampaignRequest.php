<?php

namespace App\Http\Request\Campaign;

use App\Http\Request\BaseRequest;
use App\Validator\CampaignValidator;

class CreateCampaignRequest extends BaseRequest
{
    public function rules(CampaignValidator $campaignValidator): array
    {
        return $campaignValidator->rules();
    }
}