<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ResourceMethodNotAvailableException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\PublicKey;

class ServerPublicKeyResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'server/public-keys';
    }

    protected function getResourceModelFqns(): string
    {
        return PublicKey::class;
    }

    public function post(AbstractModel $model)
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function put(AbstractModel $model): void
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function list(): array
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function delete($identifier): void
    {
        throw new ResourceMethodNotAvailableException();
    }
}
