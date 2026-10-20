<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use Target365\ApiSdk\ApiClient;
use Target365\ApiSdk\Tests\AbstractTestCase;

class ApiClientTest extends AbstractTestCase
{
    /**
     * Guzzle 8 sends the method as given, and Guzzle 7.11+ deprecates passing it in lowercase
     */
    public function testRequestSendsUppercaseMethod(): void
    {
        $key = openssl_pkey_new(['private_key_type' => OPENSSL_KEYTYPE_EC, 'curve_name' => 'prime256v1']);

        if ($key === false) {
            throw new \RuntimeException('openssl_pkey_new() failed: ' . openssl_error_string());
        }

        openssl_pkey_export($key, $privateKey);

        $history = [];
        $handlerStack = HandlerStack::create(new MockHandler([new Response(200), new Response(200)]));
        $handlerStack->push(Middleware::history($history));

        $apiClient = new class('https://test.target365.io/', 'TestKey', $privateKey, $handlerStack) extends ApiClient {
            /** @var HandlerStack */
            private $handlerStack;

            public function __construct(string $domainUri, string $authKeyName, string $privateKey, HandlerStack $handlerStack)
            {
                parent::__construct($domainUri, $authKeyName, $privateKey);
                $this->handlerStack = $handlerStack;
            }

            protected function getHttpClient(): Client
            {
                return new Client(['handler' => $this->handlerStack]);
            }
        };

        $apiClient->request('get', 'api/ping');
        $apiClient->request('post', 'api/out-messages', ['content' => 'test']);

        $this->assertSame(['GET', 'POST'], array_map(static fn (array $transaction) => $transaction['request']->getMethod(), $history));
    }
}
