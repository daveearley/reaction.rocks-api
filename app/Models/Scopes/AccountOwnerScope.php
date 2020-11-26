<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Models\Account;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class AccountOwnerScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model instanceof Account ? 'id' : 'account_id', auth()->user()->id);
    }
}
