<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;


class ServerPublicKeyResourceTest extends AbstractTestCase
{
    /**
     * TODO should get this test working
     * @group skip
     */
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $serverPublicKey = $apiClient->clientPublicKeyResource()->get('2017-11-17');

        $this->assertEquals(8, $serverPublicKey->getAccountId());
    }

}