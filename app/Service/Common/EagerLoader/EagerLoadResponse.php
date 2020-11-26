<?php

namespace App\Service\Common\EagerLoader;

use App\DomainObjects\Interfaces\DomainObjectInterface;

/**
 * Stores eager loaded results
 * @todo This only handles one-to-one
 */
class EagerLoadResponse
{
    private array $values = [];

    public function setValue(int $entityId, DomainObjectInterface $domainObject): void
    {
        $this->values[$entityId] = $domainObject;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getDomainObjectById(int $id): DomainObjectInterface
    {
        return $this->values[$id];
    }
}