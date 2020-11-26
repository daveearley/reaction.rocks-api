<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\Scopes\AccountOwnerScope;
use Illuminate\Database\Eloquent\Model;

trait HasAccount
{
    public static function bootHasAccount(): void
    {
        if (auth()->check()) {
            static::addGlobalScope(new AccountOwnerScope());

            static::creating(
                function (Model $model) {
                    $model->account_id = auth()->user()->id;
                }
            );
        }
    }
}
