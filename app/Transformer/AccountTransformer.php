<?php

declare(strict_types=1);

namespace App\Transformer;

use App\DomainObjects\AccountDomainObject;
use App\DomainObjects\Interfaces\DomainObjectInterface;

class AccountTransformer extends BaseTransformer
{
    /**
     * @param AccountDomainObject|DomainObjectInterface $account
     * @return array
     */
    public function transform(DomainObjectInterface $account): array
    {
        return [
            'id' => $account->getId(),
            'email' => $account->getEmail(),
            'first_name' => $account->getFirstName(),
            'last_name' => $account->getLastName()
        ];
    }
}
