<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Model\StrexMerchant;
use Target365\ApiSdk\Tests\AbstractTestCase;

class StrexMerchantResourceTest extends AbstractTestCase
{
    public function testPut()
    {
        $apiClient = $this->getApiClient();
        $strexMerchant = new StrexMerchant();
        $merchantId = str_replace('.', '-', uniqid((string) time(), true));
        $strexMerchant->setMerchantId($merchantId);
        $strexMerchant->setShortNumberIds(['NO-0000']);
        $strexMerchant->setPassword('super_secure');

        $apiClient->strexMerchantResource()->put($strexMerchant);

        $this->assertTrue(true);
        return $merchantId;
    }

    /**
     * @depends testPut
     */
    public function testGet($merchantId)
    {
        $apiClient = $this->getApiClient();
        
        $strexMerchant = $apiClient->strexMerchantResource()->get($merchantId);

        $this->assertInstanceOf(StrexMerchant::class, $strexMerchant);
        $this->assertEquals($merchantId, $strexMerchant->getMerchantId());
        return $merchantId;
    }

    /**
     * @depends testGet
     */
    public function testList($merchantId)
    {
        $apiClient = $this->getApiClient();

        $strexMerchants = $apiClient->strexMerchantResource()->list();

        // expecting at least 1 item as we just posted one
        $this->assertGreaterThanOrEqual(1, count($strexMerchants));
        foreach ($strexMerchants as $strexMerchant)
        {
            $this->assertInstanceOf(StrexMerchant::class, $strexMerchant);
        }
        
        return $merchantId;
    }
    
    /**
     * @depends testGet
     */
    public function testDelete(string $merchantId)
    {
        $apiClient = $this->getApiClient();
        
        $apiClient->strexMerchantResource()->delete($merchantId);

        $this->assertTrue(true);
        return $merchantId;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(string $merchantId)
    {
        $this->expectException(\Exception::class);
        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $apiClient->strexMerchantResource()->get($merchantId);
    }
}