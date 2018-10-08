<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use GuzzleHttp\Exception\RequestException;
use Target365\ApiSdk\Model\AbstractModel;
use Target365\ApiSdk\Model\Lookup;

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
    public function get(string $phoneNumber): ?AbstractModel
    {

        $queryStringData = [
            'msisdn' => $phoneNumber,
        ];

        $uri = $this->getResourceUri() . '?' . http_build_query($queryStringData);

        try {
            $response = $this->apiClient->request('get', $uri);
        } catch (RequestException $e) {
            // Specifically to the lookup endpoint, we do not want to throw an Exception on 404
            if ($e->getResponse()->getStatusCode() == 404) {
                return null;
            } else {
                throw $e;
            }
        }

        $responseData = $this->decodeResponseJson($response);

        return $this->instantiateModel($responseData);
    }

}