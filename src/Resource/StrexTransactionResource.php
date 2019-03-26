<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ResourceMethodNotAvailableException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\StrexTransaction;

class StrexTransactionResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'strex/transactions';
    }

    protected function getResourceModelFqns(): string
    {
        return StrexTransaction::class;
    }

    public function list(): array
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function put(AbstractModel $model): void
    {
        throw new ResourceMethodNotAvailableException();
    }
    
    /**
     * @deprecated 1.3.0 Please use reverse instead.
     */
    public function delete(string $identifier): void
    {
        $this->reverse($identifier);
    }
    
    /**
     * @param string $identifier
     * @throws ApiClientException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     */
    public function reverse(string $identifier): string
    {
        $uri = $this->getResourceUri() . '/' . $identifier;
        $response = $this->apiClient->request('delete', $uri);
        $locationHeaders = $response->getHeader('Location');
        $locationHeader = reset($locationHeaders);
        return $this->parseIdentifierFromLocationHeader($locationHeader);
    }
}
