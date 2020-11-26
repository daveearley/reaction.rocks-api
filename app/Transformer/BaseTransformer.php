<?php

declare(strict_types=1);

namespace App\Transformer;

use App\DomainObjects\AccountDomainObject;
use App\DomainObjects\CampaignDomainObject;
use App\DomainObjects\Interfaces\DomainObjectInterface;
use App\DomainObjects\ReactionDomainObject;
use App\Exceptions\NoTransformerFoundException;
use App\Service\Common\EagerLoader\EagerLoadResponse;
use App\Service\Common\EagerLoader\EagerLoadService;
use App\Transformer\Interfaces\TransformerInterface;
use App\Transformer\Value\IncludedData;
use Illuminate\Contracts\Container\BindingResolutionException;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\ResourceInterface;
use League\Fractal\Scope;
use League\Fractal\TransformerAbstract;

abstract class BaseTransformer extends TransformerAbstract implements TransformerInterface
{
    public static array $transformerMap = [
        AccountDomainObject::class => AccountTransformer::class,
        CampaignDomainObject::class => CampaignTransformer::class,
        ReactionDomainObject::class => ReactionTransformer::class,
    ];
    private ?IncludedData $includedData = null;
    private array $additionalData = [];
    /**
     * @var array a map of  ['include_key' => Domain Object FCN]
     */
    private array $includesKeyNameMap = [];

    /**
     * Return an array of domain objects which have an associated transformer
     *
     * @return array
     */
    public static function getTransformableDomainObjects(): array
    {
        return array_keys(self::$transformerMap);
    }

    /**
     * Sets included data to be embedded in the response
     *
     * @param IncludedData $includedData
     *
     * @return $this
     */
    public function withIncludedData(IncludedData $includedData): self
    {
        foreach ($includedData->getValue() as $domainObject => $data) {
            $this->includesKeyNameMap[is_iterable($data) ? $domainObject::PLURAL_NAME : $domainObject::SINGULAR_NAME] = $domainObject;
        }

        $this->setDefaultIncludes(array_keys($this->includesKeyNameMap));
        $this->includedData = $includedData;

        return $this;
    }

    /**
     * Arbitrary data that is available to use in the 'transform' method
     *
     * @param array $additionalData
     * @return $this
     */
    public function withAdditionalData(array $additionalData): self
    {
        $this->additionalData = $additionalData;
        return $this;
    }

    public function getAdditionalData(): array
    {
        return $this->additionalData;
    }

    /**
     * This overrides Fractal's callIncludeMethod so we don't have to declare our includes in every transformer.
     * Now we can just set the includes in the controller and this method will handle injecting the data.
     *
     * @param Scope $scope
     * @param string $includeName
     * @param mixed $data
     * @return Collection|Item|ResourceInterface|null
     * @throws NoTransformerFoundException
     * @throws BindingResolutionException
     */
    protected function callIncludeMethod(Scope $scope, $includeName, $data)
    {
        if (!$this->includedData) {
            return parent::callIncludeMethod($scope, $includeName, $data);
        }

        $domainObjectName = (string)$this->includesKeyNameMap[$includeName] ?? null;
        $includedData = $this->includedData->getValue()[$domainObjectName] ?? null;

        if (!$includedData) {
            return null;
        }

        /**
         * @see EagerLoadResponse
         * @see EagerLoadService
         */
        if ($includedData instanceof EagerLoadResponse) {
            $includedData = $includedData->getDomainObjectById($data->getId());
        }

        if (is_iterable($includedData)) {
            return new Collection(
                $includedData,
                self::getTransformerForDomainObject($domainObjectName)
            );
        }

        if ($includedData instanceof DomainObjectInterface) {
            return new Item(
                $includedData,
                self::getTransformerForDomainObject($domainObjectName)
            );
        }

        return null;
    }

    /**
     * Returns the appropriate transformer for a given domain object
     *
     * @param string $domainObjectName FQCN of a domain object
     *
     * @return mixed
     *
     * @throws NoTransformerFoundException
     * @throws BindingResolutionException
     */
    public static function getTransformerForDomainObject(string $domainObjectName)
    {
        $transformer = self::$transformerMap[$domainObjectName] ?? null;

        if (!$transformer) {
            throw new NoTransformerFoundException(sprintf('%s has no transformer.', $domainObjectName));
        }

        /** @var BaseTransformer $transformer */
        $transformer = app()->make($transformer);
        return $transformer;
    }
}
