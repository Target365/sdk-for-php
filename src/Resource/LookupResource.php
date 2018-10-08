<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\Lookup;
use Target365\ApiSdk\Model\StrexMerchant;

class LookupResource extends AbstractResource // intentionally not extending AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'lookup';
    }

    protected function getResourceModelFqns(): string
    {
        return Lookup::class;
    }


    /**
     * GET /lookup?msisdn={phoneNumber}
     *
     * @param string $phoneNumber international phone number in E.164 format
     */
    public function get(string $phoneNumber): AbstractModel
    {

        $queryStringData = [
            'msisdn' => $phoneNumber,
        ];

        $uri = $this->getResourceUri() . '?' . http_build_query($queryStringData);

        try {
            $response = $this->apiClient->request('get', $uri);
        } catch (ApiClientException $e) {
            dd(get_class($e));
        }

        $responseData = $this->decodeResponseJson($response);

        return $this->instantiateModel($responseData);
    }

}