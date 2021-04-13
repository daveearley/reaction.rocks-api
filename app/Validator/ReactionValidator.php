<?php

namespace App\Validator;

use App\DomainObjects\CampaignDomainObject;

class ReactionValidator extends BaseValidator
{
    private CampaignDomainObject $campaign;

    public function __construct(CampaignDomainObject $campaignDomainObject)
    {
        $this->campaign = $campaignDomainObject;
    }

    public function rules(array $options = []): array
    {
        return [
            'feedback_message' => [$this->campaign->getIsFollowUpMandatory() ? 'required' : '', 'min:3', 'max:1000'],
            'emoji' => ['required', 'max:5'],
//            'referer' => ['url'],
            'user_data' => ['json', 'max:1000']
        ];
    }
}