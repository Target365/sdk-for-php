<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Tests\AbstractTestCase;

class LookupResourceTest extends AbstractTestCase
{
    public function testMsisdnLookup()
    {
        $apiClient = $this->getApiClient();

        $lookup = $apiClient->lookupResource()->msisdnLookup('+4798079008');

        $this->assertEquals('+4798079008', $lookup->getMsisdn());
        $this->assertEquals('Hans', $lookup->getFirstName());
        $this->assertEquals('Stjernholm', $lookup->getLastName());
        $this->assertEquals('Oslo', $lookup->getCity());
    }

    public function testFreetextLookup()
    {
        $apiClient = $this->getApiClient();

        $lookups = $apiClient->lookupResource()->freetextLookup('+4798079008');

        // We know there is at least 1 item as we just posted one
        $this->assertGreaterThanOrEqual(1, count($lookups));
        $this->assertEquals('+4798079008', $lookups[0]->getMsisdn());
        $this->assertEquals('Hans', $lookups[0]->getFirstName());
        $this->assertEquals('Stjernholm', $lookups[0]->getLastName());
        $this->assertEquals('Oslo', $lookups[0]->getCity());

        // This time expecting one unsuccessful result
        $lookups = $apiClient->lookupResource()->freetextLookup('xyz-no-results-expected');
        $this->assertEquals(0, count($lookups));
    }
}