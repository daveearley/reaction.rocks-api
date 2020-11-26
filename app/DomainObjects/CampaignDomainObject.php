<?php

namespace App\DomainObjects;

class CampaignDomainObject extends Generated\CampaignDomainObject
{
    public const EMOJI_DELIMITER = ',';

    public function getEmojisArray(): array
    {
        return explode(self::EMOJI_DELIMITER, $this->getEmojis());
    }
}