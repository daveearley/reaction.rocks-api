<?php

namespace App\DomainObjects;

use App\DomainObjects\Enums\CampaignTypeEnum;

class CampaignDomainObject extends Generated\CampaignDomainObject
{
    public const EMOJI_DELIMITER = ',';

    public function getEmojisArray(): array
    {
        return explode(self::EMOJI_DELIMITER, $this->getEmojis());
    }

    public function isNpsCampaign(): bool
    {
        return $this->getType() === CampaignTypeEnum::NPS;
    }
}