<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\StrexRegistrationSms;
use Target365\ApiSdk\Tests\AbstractTestCase;

class StrexRegistrationSmsResourceTest extends AbstractTestCase
{
    public function testPost()
    {
        $apiClient = $this->getApiClient();
        $transactionId = str_replace('.', '-', uniqid((string) time(), true));
        $registrationSms = new StrexRegistrationSms();

        $registrationSms
				    ->setMerchantId('mer_test')
				    ->setTransactionId($transactionId)
            ->setRecipient('+4798079008')
				    ->setSmsText('Please register.');

        $identifier = $apiClient->strexRegistrationSmsResource()->post($registrationSms);

        $this->assertEquals($registrationSms->getTransactionId(), $identifier);
    }
}