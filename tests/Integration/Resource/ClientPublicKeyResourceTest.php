<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Fixtures;
use Target365\ApiSdk\Tests\Secrets;


class ClientPublicKeyResourceTest extends AbstractTestCase
{
    public function testGet()
    {
        $secrets = new Secrets();

        $apiClient = $this->getApiClient();

        $clientPublicKey = $apiClient->clientPublicKeyResource()->get($secrets->getAuthKeyName());

        $this->assertEquals($secrets->getAuthKeyName(), $clientPublicKey->getName());
    }

    public function testList()
    {
        $secrets = new Secrets();

        $apiClient = $this->getApiClient();

        $clientPublicKeys = $apiClient->clientPublicKeyResource()->list();

        $found = false;
        foreach ($clientPublicKeys as $clientPublicKey) {
            if ($clientPublicKey->getName() == $secrets->getAuthKeyName()) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);

    }
}