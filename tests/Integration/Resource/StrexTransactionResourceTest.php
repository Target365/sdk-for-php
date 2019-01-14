<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Model\StrexTransaction;
use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Fixtures;

class StrexTransactionResourceTest extends AbstractTestCase
{

    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $strexTransaction = new StrexTransaction();
        $strexTransaction
            ->setTransactionId(Fixtures::getFixedRandomTransactionId())
            ->setInvoiceText('Thank you for your donation')
            ->setMerchantId('mer_test')
            ->setPrice(10)
            ->setRecipient('+4798079008')
            ->setServiceCode('14002')
            ->setShortNumber('2001');


        $returnedStrexTransactionId = $apiClient->strexTransactionResource()->post($strexTransaction);

        $this->assertEquals(Fixtures::getFixedRandomTransactionId(), $returnedStrexTransactionId);

        return $returnedStrexTransactionId;
    }

    /**
     * @depends testPost
     */
    public function testGet($identifier)
    {
        $apiClient = $this->getApiClient();

        $strexTransaction = $apiClient->strexTransactionResource()->get($identifier);

        $this->assertInstanceOf(StrexTransaction::class, $strexTransaction);

        $this->assertEquals($identifier, $strexTransaction->getIdentifier());

        return $strexTransaction;
    }


    /**
     * @depends testGet
     */
    public function testDelete(StrexTransaction $strexTransaction)
    {
        $apiClient = $this->getApiClient();

        $apiClient->strexTransactionResource()->delete($strexTransaction->getIdentifier());

        $this->assertTrue(true);

        return $strexTransaction;
    }

    /**
     * TODO should not be skipping this test
     * @group skip
     * @depends testDelete
     */
    public function testConfirmDelete(StrexTransaction $strexTransaction)
    {
        $this->expectException(\Exception::class);

        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $apiClient->strexTransactionResource()->get($strexTransaction->getIdentifier());
    }


}