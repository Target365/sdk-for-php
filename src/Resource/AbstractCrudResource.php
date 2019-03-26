<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Model\AbstractModel;

abstract class AbstractCrudResource extends AbstractResource
{
    /**
     * GET /{resource}
     */
    public function list(): array
    {
        return $this->listBase();
    }

    protected function listBase(array $queryStringData = []): array
    {
        $uri = $this->getResourceUri();

        if (array_filter($queryStringData)) {
            $uri = $uri . '?' . http_build_query(array_filter($queryStringData));
        }

        $response = $this->apiClient->request('get', $uri);
        $responseData = $this->decodeResponseJson($response);
        $returnObjects = [];

        foreach ($responseData as $item) {
            $returnObjects[] = $this->instantiateModel($item);
        }

        return $returnObjects;
    }

    /**
     * GET /{resource}/{identifier}
     *
     * @param string $identifier
     * @return AbstractModel
     * @throws ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function get(string $identifier): AbstractModel
    {
        $uri = $this->getResourceUri() . '/' . $identifier;
        $response = $this->apiClient->request('get', $uri);
        $responseData = $this->decodeResponseJson($response);
        return $this->instantiateModel($responseData);
    }

    /**
     * POST /{resource}
     *
     * @param AbstractModel $model
     * @return mixed
     * @throws ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function post(AbstractModel $model)
    {
        $this->forceResourceModel($model);
        $uri = $this->getResourceUri();
        $normalizedData = $model->normalize();
        $response = $this->apiClient->request('post', $uri, $normalizedData);
        $locationHeaders = $response->getHeader('Location');
        $locationHeader = reset($locationHeaders);
        return $this->parseIdentifierFromLocationHeader($locationHeader);
    }

    /**
     * PUT /{resource}/{identifier}
     *
     * @param AbstractModel $model
     * @throws ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function put(AbstractModel $model): void
    {
        $this->forceResourceModel($model);

        if ($model->getIdentifier() === null) {
            throw new ApiClientException(get_class($this) . ' missing identifier');
        }

        $uri = $this->getResourceUri() . '/' . $model->getIdentifier();
        $normalizedData = $model->normalize();
        $this->apiClient->request('put', $uri, $normalizedData);
    }

    /**
     * DELETE /{resource}/{identifier}
     *
     * @param string $identifier
     * @throws ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function delete(string $identifier): void
    {
        $uri = $this->getResourceUri() . '/' . $identifier;
        $this->apiClient->request('delete', $uri);
    }
}
