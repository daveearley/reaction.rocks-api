<?php

namespace App\DomainObjects\Interfaces;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface DomainObjectInterface
 * @package App\DomainObjects\Interfaces
 */
interface DomainObjectInterface
{
    public static function hydrate($data): DomainObjectInterface;

    public static function hydrateFromModel(Model $model): DomainObjectInterface;

    public static function hydrateFromArray(array $array): DomainObjectInterface;

    public function toArray(): array;
}
