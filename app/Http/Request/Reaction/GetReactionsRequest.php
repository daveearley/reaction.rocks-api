<?php

namespace App\Http\Request\Reaction;

use App\DomainObjects\ReactionDomainObject;
use App\Http\Request\BaseRequest;

class GetReactionsRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'order_by' => sprintf('in:%s', implode(',', ReactionDomainObject::ORDER_COLUMNS)),
            'search_query' => 'max:30'
        ];
    }
}