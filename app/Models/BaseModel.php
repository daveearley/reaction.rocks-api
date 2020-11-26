<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class BaseModel extends Model
{
    /**
     * @todo This should be a whitelist
     * @var array|string[]
     */
    protected $guarded = [
        'id',
        'account_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function __construct(array $attributes = [])
    {
        $this->timestamps = $this->getTimestampsEnabled();
        $this->guarded = array_merge($this->guarded, $this->getGuardedFields());

        parent::__construct($attributes);
    }

    protected function getTimestampsEnabled(): bool
    {
        return true;
    }

    protected function getGuardedFields(): array
    {
        return [];
    }
}
