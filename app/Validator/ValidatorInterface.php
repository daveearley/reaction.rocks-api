<?php

namespace App\Validator;

interface ValidatorInterface
{
    public const RULE_DELIMITER = '|';

    public function rules(array $options = []): array;
}
