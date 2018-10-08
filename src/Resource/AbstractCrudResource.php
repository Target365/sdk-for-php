<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

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

    protected function listBase(array $queryStringData = null): array
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
     */
    public function get($identifier): AbstractModel
    {
        $uri = $this->getResourceUri() . '/' . $identifier;

        $response = $this->apiClient->request('get', $uri);

        $responseData = $this->decodeResponseJson($response);

        return $this->instantiateModel($responseData);
    }

    /**
     * POST /{resource}
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
     */
    public function put(AbstractModel $model): void
    {
        $this->forceResourceModel($model);

        $uri = $this->getResourceUri() . '/' . $model->getIdentifier();

        $normalizedData = $model->normalize();

        $response = $this->apiClient->request('put', $uri, $normalizedData);
    }

    /**
     * DELETE /{resource}/{identifier}
     */
    public function delete($identifier): void
    {
        $uri = $this->getResourceUri() . '/' . $identifier;

        $response = $this->apiClient->request('delete', $uri);
    }
}
