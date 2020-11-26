<?php

namespace App\Transformer\Interfaces;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use App\Transformer\Value\IncludedData;

interface TransformerInterface
{
    public function transform(DomainObjectInterface $domainObject): array;

    public function withIncludedData(IncludedData $includedData): self;
}
