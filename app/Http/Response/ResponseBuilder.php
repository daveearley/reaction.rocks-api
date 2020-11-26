<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\DomainObjects\Interfaces\DomainObjectInterface;
use App\Exceptions\NoTransformerFoundException;
use App\Http\ResponseCodes;
use App\Transformer\BaseTransformer;
use App\Transformer\Presenter;
use App\Transformer\Value\IncludedData;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\HeaderBag;

class ResponseBuilder
{
    private int $responseCode = ResponseCodes::HTTP_OK;

    private $data;

    private ?IncludedData $includedData = null;

    private ?HeaderBag $headers = null;

    private array $cookies = [];

    private array $additionalData = [];

    public function withCookie(string $name, string $value, ...$opts): self
    {
        $this->cookies[] = new Cookie($name, $value, ...$opts);

        return $this;
    }

    public function withData($data, array $additionalData = []): self
    {
        if ($additionalData) {
            $this->withAdditionalData($additionalData);
        }

        $this->data = $data;

        return $this;
    }

    private function withAdditionalData(array $additionalData)
    {
        $this->additionalData = $additionalData;

        return $this;
    }

    public function withIncludedData(array $data): self
    {
        $this->includedData = new IncludedData($data);

        return $this;
    }

    public function withHeaders(array $headers): self
    {
        $this->headers = new HeaderBag($headers);

        return $this;
    }

    public function createdResponse()
    {
        $this->withResponseCode(ResponseCodes::HTTP_CREATED);
        return $this->response();
    }

    public function withResponseCode(int $code): self
    {
        $this->responseCode = $code;

        return $this;
    }

    public function response()
    {
        $response = response(
            $this->data ? $this->transform($this->data, $this->includedData) : null,
            $this->responseCode,
            $this->headers ? $this->headers->all() : []
        );

        if ($this->cookies) {
            foreach ($this->cookies as $cookie) {
                $response->withCookie($cookie);
            }
        }

        return $response;
    }

    /**
     * @param DomainObjectInterface|Collection|LengthAwarePaginator|array $data
     * @param IncludedData|null $includedData
     *
     * @return array|Collection
     *
     * @throws BindingResolutionException
     * @throws NoTransformerFoundException
     */
    protected function transform($data, IncludedData $includedData = null)
    {
        // If the data is an array return it without transformation
        if (is_array($data)) {
            return $this->wrapInEnvelope($data);
        }

        /** @var Presenter $presenter */
        $presenter = app()->make(Presenter::class);
        $domainObject = $data instanceof DomainObjectInterface ? $data : $data->first();

        if ($data instanceof LengthAwarePaginator && $data->isEmpty()) {
            return $presenter->present($data);
        }

        if (!$domainObject) {
            return $this->wrapInEnvelope([]);
        }

        /** @var BaseTransformer $transformer */
        $transformer = BaseTransformer::getTransformerForDomainObject(get_class($domainObject));
        if ($includedData) {
            $transformer->withIncludedData($includedData);
        }

        if ($this->additionalData) {
            $transformer->withAdditionalData($this->additionalData);
        }

        $presenter->setTransformer($transformer);

        return $presenter->present($data);
    }

    /**
     * @param $data mixed
     * @return array
     */
    private function wrapInEnvelope($data): array
    {
        return ['data' => $data];
    }

    public function notFoundResponse()
    {
        $this->withResponseCode(ResponseCodes::HTTP_NOT_FOUND);
        return $this->response();
    }

    public function noContentResponse()
    {
        $this->withResponseCode(ResponseCodes::HTTP_NO_CONTENT);
        return $this->response();
    }
}
