<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;

class LookupResourceTest extends AbstractTestCase
{
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $lookup = $apiClient->lookupResource()->getOne('+4798079008');

        $this->assertEquals('+4798079008', $lookup->getMsisdn());
        $this->assertEquals('Oslo', $lookup->getCity());
    }
}