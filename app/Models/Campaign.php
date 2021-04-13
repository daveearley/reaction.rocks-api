<?php

namespace App\Models;

use App\Models\Traits\HasAccount;

class Campaign extends BaseModel
{
    use HasAccount;

    protected function getGuardedFields(): array
    {
        return [
            'public_id'
        ];
    }
}