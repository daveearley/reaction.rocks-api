<?php

namespace App\Repository\Interfaces;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use Exception;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RepositoryInterface
{
    /** @var array */
    public const DEFAULT_COLUMNS = ['*'];

    /** @var int */
    public const DEFAULT_PAGINATE_LIMIT = 15;

    /** @var int */
    public const MAX_PAGINATE_LIMIT = 100;

    /**
     * Return the FQCL of the domain object associated with this repository
     *
     * @return string
     */
    public function getDomainObject(): string;

    /**
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = self::DEFAULT_COLUMNS): Collection;

    /**
     * @param int $limit
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(
        int $limit = self::DEFAULT_PAGINATE_LIMIT,
        $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator;

    /**
     * @param array $where
     * @param int $limit
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginateWhere(
        array $where,
        int $limit = self::DEFAULT_PAGINATE_LIMIT,
        $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator;

    /**
     * @param Relation $relation
     * @param int $limit
     * @param array $columns
     * @return LengthAwarePaginator|null
     */
    public function paginateEloquentRelation(
        Relation $relation,
        int $limit = self::DEFAULT_PAGINATE_LIMIT,
        array $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator;

    /**
     * @param int $id
     * @param array $columns
     * @return object|null
     */
    public function findById(int $id, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface;

    /**
     * @param int $id
     * @param array $columns
     * @return object|null
     */
    public function findFirst(int $id, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface;

    /**
     * @param array $where
     * @param array $columns
     * @return mixed
     */
    public function findWhere(array $where, array $columns = self::DEFAULT_COLUMNS): Collection;

    /**
     * @param array $where
     * @param array $columns
     * @return DomainObjectInterface|null
     */
    public function findFirstWhere(array $where, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface;

    /**
     * @param string $field
     * @param string|null $value
     * @param array $columns
     * @return mixed
     */
    public function findFirstByField(
        string $field,
        string $value = null,
        array $columns = ['*']
    ): ?DomainObjectInterface;

    /**
     * @param string $field
     * @param array $values
     * @param array $columns
     * @return Collection
     * @throws Exception
     */
    public function findWhereIn(string $field, array $values, $columns = self::DEFAULT_COLUMNS): Collection;

    /**
     * @param array $attributes
     * @return DomainObjectInterface
     */
    public function create(array $attributes): DomainObjectInterface;

    /**
     * @param DomainObjectInterface $domainObject
     * @return DomainObjectInterface
     */
    public function createFromDomainObject(DomainObjectInterface $domainObject): DomainObjectInterface;

    /**
     * @param array $inserts
     * @return bool
     */
    public function insert(array $inserts): bool;

    /**
     * @param DomainObjectInterface $domainObject
     * @param int $id
     * @return DomainObjectInterface|null
     */
    public function updateFromDomainObject(int $id, DomainObjectInterface $domainObject): DomainObjectInterface;

    /**
     * @param array $attributes
     * @param int $id
     * @return DomainObjectInterface|null
     */
    public function updateFromArray(int $id, array $attributes): DomainObjectInterface;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

    /**
     * @param array $conditions
     * @return int
     */
    public function deleteWhere(array $conditions): int;

    /**
     * @param string $column
     * @param string $direction
     * @return mixed
     */
    public function orderBy(string $column, $direction = 'asc');
}
