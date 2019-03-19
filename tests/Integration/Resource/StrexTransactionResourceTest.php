<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Model\StrexTransaction;
use Target365\ApiSdk\Model\StatusCodes;
use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Fixtures;

class StrexTransactionResourceTest extends AbstractTestCase
{
    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $strexTransaction = new StrexTransaction();
        $strexTransaction
            ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
            ->setInvoiceText('Thank you for your donation')
            ->setMerchantId('mer_test')
            ->setPrice(10)
            ->setRecipient('+4798079008')
            ->setServiceCode('14002')
            ->setShortNumber('2001');


        $identifier = $apiClient->strexTransactionResource()->post($strexTransaction);

        $this->assertEquals($strexTransaction->getTransactionId(), $identifier);

        return $identifier;
    }

    /**
     * @depends testPost
     */
    public function testGet($identifier)
    {
        $apiClient = $this->getApiClient();

        $strexTransaction = $apiClient->strexTransactionResource()->get($identifier);

        $this->assertInstanceOf(StrexTransaction::class, $strexTransaction);

        $this->assertEquals($identifier, $strexTransaction->getTransactionId());

        return $strexTransaction;
    }


    /**
     * @depends testGet
     */
    public function testDelete(StrexTransaction $strexTransaction)
    {
        $apiClient = $this->getApiClient();

        $apiClient->strexTransactionResource()->delete($strexTransaction->getTransactionId());

        $this->assertTrue(true);

        return $strexTransaction;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(StrexTransaction $strexTransaction)
    {
        $apiClient = $this->getApiClient();

        $reverseTransaction = $apiClient->strexTransactionResource()->get('-' . $strexTransaction->getTransactionId());
        
        $this->assertInstanceOf(StrexTransaction::class, $reverseTransaction);
        $this->assertEquals($reverseTransaction->getPrice(), -$strexTransaction->getPrice());
        $this->assertEquals($reverseTransaction->getStatusCode(), StatusCodes::REVERSED);
    }
}