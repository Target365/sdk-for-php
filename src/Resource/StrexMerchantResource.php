<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\ApiClientException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\StrexMerchant;

class StrexMerchantResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'strex/merchants';
    }

    protected function getResourceModelFqns(): string
    {
        return StrexMerchant::class;
    }

    public function post(AbstractModel $model)
    {
        throw new ApiClientException('This method is not available for this resource');
    }


}