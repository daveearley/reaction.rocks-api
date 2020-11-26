<?php

namespace App\Transformer;

use App\DomainObjects\Interfaces\DomainObjectInterface;

class CampaignTransformer extends BaseTransformer
{
    public function transform(DomainObjectInterface $domainObject): array
    {
        // todo - need to handle private/public response
        return $domainObject->toArray();
    }
}