<?php

namespace App\Http\Request\Reaction;

use App\Http\Request\BaseRequest;
use App\Validator\ReactionValidator;

class CreateReactionRequest extends BaseRequest
{
    public function rules(ReactionValidator $validator): array
    {
        return $validator->rules();
    }
}