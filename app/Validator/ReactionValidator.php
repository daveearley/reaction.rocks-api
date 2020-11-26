<?php

namespace App\Validator;

class ReactionValidator extends BaseValidator
{
    public function rules(array $options = []): array
    {
        return [
            'feedback_message' => ['required', 'min:3'],
            'emoji' => ['required', 'max:1'],
            'referer' => ['url'],
            'user_data' => ['json', 'max:1000']
        ];
    }
}