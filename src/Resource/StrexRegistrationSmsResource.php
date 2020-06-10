<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ResourceMethodNotAvailableException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\StrexRegistrationSms;

class StrexRegistrationSmsResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'strex/registrationsms';
    }

    protected function getResourceModelFqns(): string
    {
        return StrexRegistrationSms::class;
    }

    public function post(AbstractModel $model)
    {
        $this->forceResourceModel($model);
        $uri = $this->getResourceUri();
        $normalizedData = $model->normalize();
        $response = $this->apiClient->request('post', $uri, $normalizedData);
        return $model->getIdentifier();
    }

    public function list(): array
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function put(AbstractModel $model): void
    {
        throw new ResourceMethodNotAvailableException();
    }

    public function delete(string $identifier): void
    {
        throw new ResourceMethodNotAvailableException();    
		}
}
