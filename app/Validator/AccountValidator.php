<?php

namespace App\Validator;

class AccountValidator extends BaseValidator
{
    public function rules(array $options = []): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:8'
        ];
    }
}