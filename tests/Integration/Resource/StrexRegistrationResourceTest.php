<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\StrexRegistrationSms;
use Target365\ApiSdk\Model\UserValidity;
use Target365\ApiSdk\Tests\AbstractTestCase;

class StrexRegistrationResourceTest extends AbstractTestCase
{
    public function testPost()
    {
        $apiClient = $this->getApiClient();
        $transactionId = str_replace('.', '-', uniqid((string) time(), true));
        $registrationSms = new StrexRegistrationSms();

        $registrationSms
				    ->setMerchantId('mer_target365_as')
				    ->setTransactionId($transactionId)
            ->setRecipient('+4798079008')
				    ->setSmsText('Please register.');

        $identifier = $apiClient->strexRegistrationResource()->post($registrationSms);

        $this->assertEquals($registrationSms->getTransactionId(), $identifier);
    }

    public function testUserValidity()
    {
        $apiClient = $this->getApiClient();

        $validity = $apiClient->strexRegistrationResource()->getUserValidity('mer_target365_as', '+4798079008');

        $this->assertEquals(UserValidity::FULL, $validity);
		}
}