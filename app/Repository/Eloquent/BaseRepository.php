<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use App\Models\BaseModel;
use App\Repository\Interfaces\RepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Application;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * @todo Caching
 */
abstract class BaseRepository implements RepositoryInterface
{
    /** @var Model|BaseModel|Builder */
    protected $model;

    protected Application $app;

    protected DatabaseManager $db;

    public function __construct(Application $application, DatabaseManager $db)
    {
        $this->app = $application;
        $this->model = $this->initModel();
        $this->db = $db;
    }

    /**
     * Returns a FQCL of the model
     *
     * @return string
     */
    abstract protected function getModel(): string;

    public function all(array $columns = self::DEFAULT_COLUMNS): Collection
    {
        return $this->handleResults($this->model->all($columns));
    }

    public function paginate(
        int $limit = null,
        $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator
    {
        $results = $this->model->paginate($this->getPaginationPerPag($limit), $columns);
        $this->resetModel();

        return $this->handleResults($results);
    }

    public function paginateWhere(
        array $where,
        int $limit = null,
        $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator
    {
        $this->applyConditions($where);
        $results = $this->model->paginate($this->getPaginationPerPag($limit), $columns);
        $this->resetModel();

        return $this->handleResults($results);
    }

    public function paginateEloquentRelation(
        Relation $relation,
        int $limit = null,
        array $columns = self::DEFAULT_COLUMNS
    ): LengthAwarePaginator
    {
        return $this->handleResults($relation->paginate($this->getPaginationPerPag($limit), $columns));
    }

    public function findById(int $id, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface
    {
        return $this->handleSingleResult($this->model->findOrFail($id, $columns));
    }

    public function findFirstByField(
        string $field,
        string $value = null,
        array $columns = ['*']
    ): ?DomainObjectInterface
    {
        $model = $this->model->where($field, '=', $value)->first($columns);
        $this->resetModel();

        return $this->handleSingleResult($model);
    }

    public function findFirst(int $id, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface
    {
        return $this->handleSingleResult($this->model->findOrFail($id, $columns));
    }

    public function findWhere(array $where, array $columns = self::DEFAULT_COLUMNS): Collection
    {
        $this->applyConditions($where);
        $model = $this->model->get($columns);
        $this->resetModel();

        return $this->handleResults($model);
    }

    public function findFirstWhere(array $where, array $columns = self::DEFAULT_COLUMNS): ?DomainObjectInterface
    {
        $this->applyConditions($where);
        $model = $this->model->first($columns);
        $this->resetModel();

        return $this->handleSingleResult($model);
    }

    public function findWhereIn(string $field, array $values, $columns = self::DEFAULT_COLUMNS): Collection
    {
        $model = $this->model->whereIn($field, $values)->get($columns);
        $this->resetModel();

        return $this->handleResults($model);
    }

    public function createFromDomainObject(DomainObjectInterface $domainObject): DomainObjectInterface
    {
        return $this->create($domainObject->toArray());
    }

    public function create(array $attributes): DomainObjectInterface
    {
        $model = $this->model->newInstance(collect($attributes)->forget('attributes')->toArray());
        $model->save();
        $this->resetModel();

        return $this->handleSingleResult($model);
    }

    public function insert(array $inserts): bool
    {
        // When doing a bulk insert Eloquent doesn't autofill the updated/created dates
        // so we need to do it manually
        foreach ($inserts as $index => $insert) {
            if (!isset($insert['created_at'], $insert['updated_at'])) {
                $now = Carbon::now();
                $inserts[$index]['created_at'] = $now;
                $inserts[$index]['updated_at'] = $now;
            }
        }
        $insert = $this->model->insert($inserts);
        $this->resetModel();

        return $insert;
    }

    public function updateFromDomainObject(int $id, DomainObjectInterface $domainObject): DomainObjectInterface
    {
        return $this->updateFromArray($id, $domainObject->toArray());
    }

    public function updateFromArray(int $id, array $attributes): DomainObjectInterface
    {
        $model = $this->model->findOrFail($id);
        $model->fill($attributes);
        $model->save();
        $this->resetModel();

        return $this->handleSingleResult($model);
    }

    public function deleteById(int $id): bool
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function orderBy($column, $direction = 'asc')
    {
        $this->model = $this->model->orderBy($column, $direction);

        return $this;
    }

    public function deleteWhere(array $conditions): int
    {
        $this->applyConditions($conditions);
        $deleted = $this->model->delete();
        $this->resetModel();

        return $deleted;
    }

    protected function initModel(string $model = null): Model
    {
        return $this->app->make($model ?: $this->getModel());
    }

    protected function applyConditions(array $where): void
    {
        foreach ($where as $field => $value) {
            if (isset($value['whereMethod'], $value['parameters'])) {
                $this->model = $this->model->{$value['whereMethod']}(...$value['parameters']);
            } else {
                $this->model = $this->model->where($field, '=', $value);
            }
        }
    }

    protected function handleResults($results, string $domainObjectOverride = null)
    {
        $domainObjects = [];
        foreach ($results as $result) {
            if ($result && $domainObject = $this->handleSingleResult($result, $domainObjectOverride)) {
                $domainObjects[] = $domainObject;
            }
        }

        if ($results instanceof LengthAwarePaginator) {
            return $results->setCollection(collect($domainObjects));
        }

        return collect($domainObjects);
    }

    protected function handleSingleResult(
        ?BaseModel $model,
        string $domainObjectOverride = null
    ): ?DomainObjectInterface
    {
        if (!$model) {
            return null;
        }

        return $this->hydrateDomainObjectFromModel($model, $domainObjectOverride);
    }

    private function getPaginationPerPag(?int $perPage): int
    {
        if (is_null($perPage)) {
            $perPage = $_REQUEST['per_page'] ?? self::DEFAULT_PAGINATE_LIMIT;
        }

        return (int)min($perPage, self::MAX_PAGINATE_LIMIT);
    }

    private function resetModel(): void
    {
        $model = $this->getModel();
        $this->model = new $model();
    }

    /**
     * @param BaseModel $model
     * @param string|null $domainObjectOverride A FQCN of a DO
     *
     * @return DomainObjectInterface
     *
     * @todo use hydrate method from AbstractDomainObject
     */
    private function hydrateDomainObjectFromModel(
        BaseModel $model,
        string $domainObjectOverride = null
    ): DomainObjectInterface
    {
        $object = $domainObjectOverride ? $domainObjectOverride : $this->getDomainObject();
        $object = new $object();

        foreach ($model->toArray() as $attribute => $value) {
            $method = 'set' . ucfirst(Str::camel($attribute));
            if (is_callable(array($object, $method))) {
                $object->$method($value);
            }
        }

        return $object;
    }
}
