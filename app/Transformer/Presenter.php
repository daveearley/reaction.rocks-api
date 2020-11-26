<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Transformer\Interfaces\TransformerInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Collection;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection as FractalCollection;
use League\Fractal\Resource\Item;

class Presenter
{
    private Manager $manager;

    private ?TransformerInterface $transformer = null;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param TransformerInterface $transformer
     * @return Presenter
     */
    public function setTransformer(TransformerInterface $transformer): self
    {
        $this->transformer = $transformer;

        return $this;
    }

    /**
     * @param  $data
     * @return Collection
     */
    public function present($data): Collection
    {
        if ($data instanceof Collection) {
            $data = $this->transformCollection($data);
        } elseif ($data instanceof AbstractPaginator) {
            $data = $this->transformPaginator($data);
        } else {
            $data = $this->transformItem($data);
        }

        return collect($this->manager->createData($data)->toArray());
    }

    /**
     * @param Collection $data
     * @return FractalCollection
     */
    protected function transformCollection(Collection $data)
    {
        return new FractalCollection($data, $this->getTransformer());
    }

    /**
     * @return TransformerInterface
     */
    private function getTransformer(): ?TransformerInterface
    {
        return $this->transformer;
    }

    /**
     * @param AbstractPaginator|LengthAwarePaginator $paginator
     * @return FractalCollection
     */
    protected function transformPaginator(AbstractPaginator $paginator)
    {
        $resource = new FractalCollection($paginator->getCollection(), $this->getTransformer());
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;
    }

    /**
     * @param $data
     *
     * @return Item
     */
    protected function transformItem($data)
    {
        return new Item($data, $this->getTransformer());
    }
}
