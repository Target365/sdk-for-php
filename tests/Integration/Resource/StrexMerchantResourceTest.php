<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\ApiClientException;
use Target365\ApiSdk\Model\StrexMerchant;
use Target365\ApiSdk\Tests\AbstractTestCase;

class StrexMerchantResourceTest extends AbstractTestCase
{

    public function testPost()
    {
        $this->expectException(ApiClientException::class);

        $apiClient = $this->getApiClient();

        $strexMerchant = new StrexMerchant();

        // Expecting an exception as this resource does not support POST
        $apiClient->strexMerchantResource()->post($strexMerchant);
    }


    public function testPut()
    {
        $apiClient = $this->getApiClient();

        $strexMerchant = new StrexMerchant();

        $identifer = uniqid((string) time(), true);

        $strexMerchant->setMerchantId($identifer);
        $strexMerchant->setShortNumberId('NO-0000');
        $strexMerchant->setEncryptedPassword('abcdef');

        $apiClient->strexMerchantResource()->put($strexMerchant);

        $this->assertTrue(true);

        return $identifer;

    }

    /**
     * @depends testPut
     */
    public function testList($identifer)
    {
        $apiClient = $this->getApiClient();

        $strexMerchants = $apiClient->strexMerchantResource()->list();

        // expecting at least 1 item as we just posted one
        $this->assertGreaterThanOrEqual(1, count($strexMerchants));

        foreach ($strexMerchants as $strexMerchant) {
            $this->assertInstanceOf(StrexMerchant::class, $strexMerchant);
        }
    }

    /**
     * @depends testPut
     */
    public function testGet($identifier)
    {
        $apiClient = $this->getApiClient();

        $strexMerchant = $apiClient->strexMerchantResource()->get($identifier);

        $this->assertInstanceOf(StrexMerchant::class, $strexMerchant);

        $this->assertEquals($identifier, $strexMerchant->getIdentifier());

        return $strexMerchant;
    }


    /**
     * @depends testGet
     */
    public function testDelete(StrexMerchant $strexMerchant)
    {
        $apiClient = $this->getApiClient();

        $apiClient->strexMerchantResource()->delete($strexMerchant->getIdentifier());

        $this->assertTrue(true);

        return $strexMerchant;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(StrexMerchant $strexMerchant)
    {
        $this->expectException(ApiClientException::class);

        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $apiClient->strexMerchantResource()->get($strexMerchant->getIdentifier());
    }


}