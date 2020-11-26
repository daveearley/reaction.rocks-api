<?php

namespace App\Transformer;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use App\DomainObjects\ReactionDomainObject;
use App\Helpers\Geo\GeoHelper;

class ReactionTransformer extends BaseTransformer
{
    public function transform(DomainObjectInterface $domainObject): array
    {
        $transformed =  $domainObject->toArray();
        if ($transformed[ReactionDomainObject::COUNTRY_CODE]) {
            $transformed['country'] = GeoHelper::countryCodeToCountry($transformed[ReactionDomainObject::COUNTRY_CODE]);
        }

        return $transformed;
    }
}