<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit\Resource;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Target365\ApiSdk\ApiClient;
use Target365\ApiSdk\Model\Lookup;
use Target365\ApiSdk\Tests\AbstractTestCase;

class LookupResourceTest extends AbstractTestCase
{
    public function testMsisdnLookupReturnsLookup(): void
    {
        $apiClient = self::apiClientWithResponses([
            new Response(200, [], '{"msisdn":"+4798079008","firstName":"Test"}'),
        ]);

        $lookup = $apiClient->lookupResource()->msisdnLookup('+4798079008');

        $this->assertInstanceOf(Lookup::class, $lookup);
        $this->assertSame('+4798079008', $lookup->getMsisdn());
    }

    public function testMsisdnLookupReturnsNullOn404(): void
    {
        $apiClient = self::apiClientWithResponses([new Response(404)]);

        $this->assertNull($apiClient->lookupResource()->msisdnLookup('+4798079008'));
    }

    public function testMsisdnLookupThrowsOnOtherErrors(): void
    {
        $apiClient = self::apiClientWithResponses([new Response(500)]);

        $this->expectException(ServerException::class);

        $apiClient->lookupResource()->msisdnLookup('+4798079008');
    }

    /**
     * @param Response[] $responses
     */
    private static function apiClientWithResponses(array $responses): ApiClient
    {
        $key = openssl_pkey_new(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1']);

        if ($key === false) {
            throw new \RuntimeException('openssl_pkey_new() failed: ' . openssl_error_string());
        }

        openssl_pkey_export($key, $privateKey);

        return new class('https://test.target365.io/', 'TestKey', $privateKey, $responses) extends ApiClient {
            /** @var Response[] */
            private $responses;

            /**
             * @param Response[] $responses
             */
            public function __construct(string $domainUri, string $authKeyName, string $privateKey, array $responses)
            {
                parent::__construct($domainUri, $authKeyName, $privateKey);
                $this->responses = $responses;
            }

            protected function getHttpClient(): Client
            {
                return new Client(['handler' => HandlerStack::create(new MockHandler($this->responses))]);
            }
        };
    }
}
