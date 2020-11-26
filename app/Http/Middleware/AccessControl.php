<?php

namespace App\Http\Middleware;

use App\Models\Account;
use App\Models\Event;
use App\Models\Order;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AccessControl
{
    private array $paramToModelMap = [
        'event_id' => [
            'model' => Event::class,
            'column' => 'account_id'
        ],
        'account_id' => [
            'model' => Account::class,
            'column' => 'id'
        ],
        'order_id' => [
            'model' => Order::class,
            'relation' => Event::class,
            'column' => 'account_id'
        ]
    ];

    public function handle(Request $request, Closure $next)
    {
        $accountId = auth()->user()->account_id;
        foreach ($request->route()->parameters() as $parameterName => $parameterId) {
            if (isset($this->paramToModelMap[$parameterName])) {
                /** @var Model $model */
                $model = app($this->paramToModelMap[$parameterName]['model'])->findOrFail($parameterId);

                if (isset($this->paramToModelMap[$parameterName]['relation'])) {
                    //$model = app()->make($this->paramToModelMap[$parameterName]['relation'])->findOrFail();
                }

                if ($model->{$this->paramToModelMap[$parameterName]['column']} !== $accountId) {
                    throw new AuthenticationException();
                }
            }
        }

        return $next($request);
    }
}
