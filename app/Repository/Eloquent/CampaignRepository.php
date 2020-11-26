<?php

namespace App\Repository\Eloquent;

use App\DomainObjects\CampaignDomainObject;
use App\Models\Campaign;
use App\Repository\Interfaces\CampaignRepositoryInterface;

class CampaignRepository extends BaseRepository implements CampaignRepositoryInterface
{
    public function getDomainObject(): string
    {
        return CampaignDomainObject::class;
    }

    protected function getModel(): string
    {
        return Campaign::class;
    }
}