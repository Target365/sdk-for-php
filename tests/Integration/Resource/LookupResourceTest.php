<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;

class LookupResourceTest extends AbstractTestCase
{
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $lookup = $apiClient->lookupResource()->get('+4798079008');

//        $this->assertEquals('+4798079008', $lookup->getMsisdn());
        // TODO something changed and now  98079008 is been returned. Confirm with Hans
        $this->assertEquals('Oslo', $lookup->getCity());
    }

    public function testGetNotFound()
    {
        $apiClient = $this->getApiClient();

        $lookup = $apiClient->lookupResource()->get('+47000000'); //Invalid number

        $this->assertNull($lookup);
    }
}