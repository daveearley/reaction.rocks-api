<?php

namespace App\Service\Common\EagerLoader;

use App\Repository\Interfaces\RepositoryInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class EagerLoadService
{
    /**
     * This service eager loads data from a related repository. This
     * is useful for including nested data in responses as it prevents
     * N + 1 queries
     *
     * @param LengthAwarePaginator $items
     * @param RepositoryInterface $relatedRepo
     * @param string $column The column on items we need to extract IDs from
     *
     * @return EagerLoadResponse
     *
     * @throws Exception
     */
    public static function handleOneToOne(
        LengthAwarePaginator $items,
        RepositoryInterface $relatedRepo,
        string $column
    ): EagerLoadResponse
    {
        // Create a map of Domain Object ID => relation ID
        $ids = [];
        foreach ($items as $item) {
            $ids[$item->getId()] = $item->{'get' . Str::studly($column)}();
        }

        // Find all the relations
        $relatedItems = $relatedRepo->findWhereIn('id', $ids);
        $relatedItemMap = [];
        foreach ($relatedItems as $relatedItem) {
            $relatedItemMap[$relatedItem->getId()] = $relatedItem;
        }

        // Build a map of Domain Object ID => $domainObject
        $response = new EagerLoadResponse();
        foreach ($ids as $domainObjectId => $relationId) {
            if (isset($relatedItemMap[$relationId])) {
                $resultMap[$domainObjectId] = $relatedItemMap[$relationId];
                $response->setValue($domainObjectId, $relatedItemMap[$relationId]);
            }
        }

        return $response;
    }

    public static function handleOneToMany(
        LengthAwarePaginator $items,
        RepositoryInterface $relatedRepo,
        string $column
    ): array
    {
        $ids = [];
        foreach ($items as $item) {
            $ids[] = $item->getId();
        }

        $relatedItems = $relatedRepo->findWhereIn($column, $ids);
        $resultMap = [];
        foreach ($relatedItems as $relatedItem) {
            $resultMap[$relatedItem->{'get' . Str::studly($column)}()][$relatedItem->getId()] = $relatedItem;
        }

        return $resultMap;
    }
}
