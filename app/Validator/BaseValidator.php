<?php

declare(strict_types=1);

namespace App\Validator;

use App\DomainObjects\Enums\BaseEnum;
use Illuminate\Validation\Factory;
use InvalidArgumentException;

abstract class BaseValidator implements ValidatorInterface
{
    protected array $data;

    protected Factory $validator;

    public function __construct(Factory $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Attach data required to generate validation rules
     *
     * @param array $data
     * @return ValidatorInterface
     */
    public function withData(array $data): ValidatorInterface
    {
        $this->data = $data;

        return $this;
    }

    protected function emumValidator(string $enumFqcn): string
    {
        if (!is_subclass_of($enumFqcn, BaseEnum::class)) {
            throw new InvalidArgumentException(sprintf('%s must extend %s', $enumFqcn, BaseEnum::class));
        }

        return 'in:' . implode(',', $enumFqcn::getConstants());
    }
}
