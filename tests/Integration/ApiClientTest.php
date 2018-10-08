<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration;

use Target365\ApiSdk\ApiClientException;
use Target365\ApiSdk\Tests\AbstractTestCase;

class ApiClientTest extends AbstractTestCase
{

    public function testRequest()
    {
        $apiClient = $this->getApiClient();


        $response = $apiClient->request(
            'get',
//            'https://test.target365.io/api/public-key/2017-11-17'
            'ping'
        );

        $this->assertEquals(
            '"pong"',
            $response->getBody()->__toString()
        );

    }


    public function testRequestFail()
    {
        $this->expectException(ApiClientException::class);

        $apiClient = $this->getApiClient();


        $apiClient->request(
            'get',
            'https://httpstat.us/400'
        );
    }
}