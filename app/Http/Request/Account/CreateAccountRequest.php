<?php

declare(strict_types=1);

namespace App\Http\Request\Account;

use App\Http\Request\BaseRequest;
use App\Validator\AccountValidator;

class CreateAccountRequest extends BaseRequest
{
    public function rules(): array
    {
        return (new AccountValidator())->rules();
    }
}
