<?php

declare(strict_types=1);

namespace App\Http\Request\Account;

use App\Http\Request\BaseRequest;

class CreateAccountRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:8'
        ];
    }
}
