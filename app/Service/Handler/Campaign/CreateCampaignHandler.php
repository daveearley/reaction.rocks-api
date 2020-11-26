<?php

namespace App\Service\Handler\Campaign;

use App\DomainObjects\CampaignDomainObject;
use App\Repository\Interfaces\CampaignRepositoryInterface;
use Illuminate\Support\Str;

class CreateCampaignHandler
{
    private CampaignRepositoryInterface $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function execute(array $campaignData): CampaignDomainObject
    {
        if (isset($campaignData[CampaignDomainObject::ALLOWED_DOMAINS])) {
            $campaignData[CampaignDomainObject::ALLOWED_DOMAINS] = implode(',', $campaignData[CampaignDomainObject::ALLOWED_DOMAINS]);
        }
        $campaignData[CampaignDomainObject::PUBLIC_ID] = Str::random(10);

        return $this->campaignRepository->create($campaignData);
    }
}