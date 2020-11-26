<?php

namespace App\DomainObjects;

class ReactionDomainObject extends Generated\ReactionDomainObject
{
    public const ORDER_COLUMNS = [
        self::SCORE,
        self::CREATED_AT
    ];
}