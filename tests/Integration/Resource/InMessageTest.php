<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Fixtures;

class InMessageResourceTest extends AbstractTestCase
{
    /**
     * @group testnow
     */
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $inMessage = $apiClient->inMessageResource()->get(Fixtures::getShortNumberId(), Fixtures::getTransactionId());

        $this->assertEquals(Fixtures::getTransactionId(), $inMessage->getTransactionId());
    }
}