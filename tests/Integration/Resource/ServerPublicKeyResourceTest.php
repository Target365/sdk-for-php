<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\PublicKey;
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

        $serverPublicKey = $apiClient->serverPublicKeyResource()->get('2017-11-17');

        $this->assertInstanceOf(PublicKey::class, $serverPublicKey);
        $this->assertSame('2017-11-17', $serverPublicKey->getName());
    }

}