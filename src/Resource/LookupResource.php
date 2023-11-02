<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Resource;

use GuzzleHttp\Exception\RequestException;
use Target365\ApiSdk\Model\Lookup;

class LookupResource extends AbstractCrudResource
{
    protected function getResourceUri(): string
    {
        return 'lookup/freetext';
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
    public function msisdnLookup(string $phoneNumber): ?Lookup
    {
        $queryStringData = [
            'msisdn' => $phoneNumber,
        ];

        $uri = 'lookup?' . http_build_query($queryStringData);

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

    /**
     * GET /lookup/freetext?input={freetext}
     *
     * @param string $freetext free text like a name or an address
     */
    public function freetextLookup(string $freetext): array {
        $queryStringData = [
            'input' => $freetext,
        ];

        return parent::listBase($queryStringData);
    }
}
