<?php

namespace App\Service\Handler\Campaign;

use App\DomainObjects\CampaignDomainObject;
use App\Repository\Interfaces\CampaignRepositoryInterface;

class UpdateCampaignHandler
{
    private CampaignRepositoryInterface $campaignRepository;

    public function __construct(CampaignRepositoryInterface $campaignRepository)
    {
        $this->campaignRepository = $campaignRepository;
    }

    public function execute(int $campaignId, array $campaignData): CampaignDomainObject
    {
        if (isset($campaignData[CampaignDomainObject::ALLOWED_DOMAINS])) {
            $campaignData[CampaignDomainObject::ALLOWED_DOMAINS] = implode(',', $campaignData[CampaignDomainObject::ALLOWED_DOMAINS]);
        }

        return $this->campaignRepository->updateFromArray($campaignId, $campaignData);
    }
}