<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;

class InMessageResourceTest extends AbstractTestCase
{
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $inMessage = $apiClient->inMessageResource()->get('NO-0000', '79f35793-6d70-423c-a7f7-ae9fb1024f3b');

        $this->assertEquals('79f35793-6d70-423c-a7f7-ae9fb1024f3b', $inMessage->getTransactionId());
    }
}