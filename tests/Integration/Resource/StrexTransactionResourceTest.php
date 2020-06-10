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
            ->setTimeout(10)
            ->setRecipient('+4798079008')
            ->setServiceCode('14002')
            ->setShortNumber('0000');

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
        $this->assertEquals(10, $strexTransaction->getTimeout());

        return $strexTransaction;
    }


    /**
     * @depends testGet
     */
    public function testReverse(StrexTransaction $strexTransaction)
    {
        $apiClient = $this->getApiClient();

        $reversalId = $apiClient->strexTransactionResource()->reverse($strexTransaction->getTransactionId());

        $this->assertEquals($reversalId, "-" . $strexTransaction->getTransactionId());

        return $reversalId;
    }

    /**
     * @depends testReverse
     */
    public function testConfirmReversed(string $reversalId)
    {
        $apiClient = $this->getApiClient();

        $reverseTransaction = $apiClient->strexTransactionResource()->get($reversalId);
        
        $this->assertInstanceOf(StrexTransaction::class, $reverseTransaction);
        $this->assertEquals($reverseTransaction->getStatusCode(), StatusCodes::REVERSED);
    }
}