<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as BaseCollection;

class PaginatorCollection extends BaseCollection
{
    /**
     * @param int $perPage
     * @param int|null $total
     * @param int|null $page
     * @param string $pageName
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage, int $total = null, int $page = null, string $pageName = 'page')
    {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }
}
