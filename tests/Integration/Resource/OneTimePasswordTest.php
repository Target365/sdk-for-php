<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\OneTimePassword;
use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Fixtures;

class OneTimePasswordTest extends AbstractTestCase
{

    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $oneTimePassword = new OneTimePassword();
        $oneTimePassword
            ->setTransactionId(Fixtures::getFixedRandomTransactionId())
            ->setMerchantId('mer_test')
            ->setRecipient('+4798079008')
            ->setSender('Test')
            ->setRecurring(false);

        $apiClient->oneTimePasswordResource()->post($oneTimePassword);

        $this->assertTrue(true);
    }


    /**
     * @depends testPost
     */
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $oneTimePassword = $apiClient->oneTimePasswordResource()->get(Fixtures::getFixedRandomTransactionId());

        $this->assertEquals(Fixtures::getFixedRandomTransactionId(), $oneTimePassword->getTransactionId());
        $this->assertEquals('mer_test', $oneTimePassword->getMerchantId());
    }
}