<?php

declare(strict_types=1);

namespace App\Http\Request;

use App\Repository\Interfaces\RepositoryInterface;
use App\Validator\ValidatorInterface;
use Illuminate\Foundation\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
}
