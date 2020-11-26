<?php

namespace App\Transformer\Value;

use App\Transformer\BaseTransformer;
use InvalidArgumentException;

/**
 * Used to house data to be included in a transformer response
 */
class IncludedData
{
    private array $includedData;

    /**
     * @param array $includedData a map of [Domain Object FQCN => $data]
     */
    public function __construct(array $includedData)
    {
        $this->includedData = $includedData;
        $this->validate();
    }

    private function validate(): void
    {
        $domainObjects = array_flip(BaseTransformer::getTransformableDomainObjects());
        foreach ($this->includedData as $domainObjectFqcn => $datum) {
            if (!isset($domainObjects[$domainObjectFqcn])) {
                throw new InvalidArgumentException(
                    sprintf(
                        '%s is not a valid domain object or there is no transformer available.',
                        $domainObjectFqcn
                    )
                );
            }
        }
    }

    public function getValue(): array
    {
        return $this->includedData;
    }
}
