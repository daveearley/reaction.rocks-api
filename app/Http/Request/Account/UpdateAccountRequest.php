<?php

declare(strict_types=1);

namespace App\Http\Request\Account;

use App\Http\Request\BaseRequest;

class UpdateAccountRequest extends BaseRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'email' => 'required|email|unique:accounts,email,' . $this->user()->id,
            'password' => 'min:8|password|required_with:new_password',
            'new_password' => 'min:8|required_with:password',
        ];
    }
}
