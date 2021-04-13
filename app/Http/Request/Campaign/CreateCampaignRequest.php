<?php

namespace App\Http\Request\Campaign;

use App\Http\Request\BaseRequest;
use App\Validator\CampaignValidator;

class CreateCampaignRequest extends BaseRequest
{
    public function rules(): array
    {
        return (new CampaignValidator())->rules();
    }
}