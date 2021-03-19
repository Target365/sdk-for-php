<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\OneTimePassword;
use Target365\ApiSdk\Tests\AbstractTestCase;

class OneTimePasswordTest extends AbstractTestCase
{
    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $oneTimePassword = new OneTimePassword();
        $oneTimePassword
            ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
            ->setMerchantId('mer_test')
            ->setRecipient('+4798079008')
            ->setSender('Test')
            ->setMessagePrefix('prefix')
            ->setMessageSuffix('suffix')
            ->setRecurring(false);

        $apiClient->oneTimePasswordResource()->post($oneTimePassword);

        $this->assertTrue(true);

        return $oneTimePassword->getTransactionId();
    }

    /**
     * @depends testPost
     */
    public function testGet($identifier)
    {
        $apiClient = $this->getApiClient();

        $oneTimePassword = $apiClient->oneTimePasswordResource()->get($identifier);

        $this->assertEquals($identifier, $oneTimePassword->getTransactionId());
        $this->assertEquals('mer_test', $oneTimePassword->getMerchantId());
        $this->assertEquals('+4798079008', $oneTimePassword->getRecipient());
        $this->assertEquals('Test', $oneTimePassword->getSender());
        $this->assertEquals('prefix', $oneTimePassword->getMessagePrefix());
        $this->assertEquals('suffix', $oneTimePassword->getMessageSuffix());
        $this->assertEquals(false, $oneTimePassword->getRecurring());
    }
}