<?php

namespace App\DomainObjects;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

abstract class AbstractDomainObject implements DomainObjectInterface
{
    /**
     * @param Model|array $data
     *
     * @return DomainObjectInterface
     */
    public static function hydrate($data): DomainObjectInterface
    {
        if ($data instanceof Model) {
            return self::hydrateFromModel($data);
        }

        if (is_array($data)) {
            return self::hydrateFromArray($data);
        }

        throw new InvalidArgumentException(sprintf('Cannot hydrate from type %s', gettype($data)));
    }

    /**
     * @param Model $model
     *
     * @return DomainObjectInterface
     */
    public static function hydrateFromModel(Model $model): DomainObjectInterface
    {
        return self::hydrateFromArray($model->toArray());
    }

    /**
     * @param array $array
     *
     * @return DomainObjectInterface
     */
    public static function hydrateFromArray(array $array): DomainObjectInterface
    {
        $domainObject = new static();
        foreach ($array as $key => $value) {
            $domainObject->{$key} = $value;
        }

        return $domainObject;
    }
}
