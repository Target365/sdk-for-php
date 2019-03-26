<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration;

use Target365\ApiSdk\Tests\AbstractTestCase;

class ApiClientTest extends AbstractTestCase
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testRequest(): void
    {
        $apiClient = $this->getApiClient();

        $response = $apiClient->request(
            'get',
            'ping'
        );

        $this->assertEquals(
            '"pong"',
            $response->getBody()->__toString()
        );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testRequestFail(): void
    {
        $this->expectException(\Exception::class);

        $apiClient = $this->getApiClient();


        $apiClient->request(
            'get',
            'https://httpstat.us/400'
        );
    }
}