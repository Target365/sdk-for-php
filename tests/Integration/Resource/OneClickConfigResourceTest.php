<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Model\OneClickConfig;
use Target365\ApiSdk\Tests\AbstractTestCase;

class OneClickConfigResourceTest extends AbstractTestCase
{
    public function testPut()
    {
        $apiClient = $this->getApiClient();

        $config = new OneClickConfig();

        $config
				->setConfigId('APITEST')
				->setShortNumber('0000')
				->setPrice(99)
				->setMerchantId('mer_test')
				->setBusinessModel('STREX-PAYMENT')
				->setServiceCode('14002')
				->setInvoiceText('Donation test')
				->setOnlineText('(Online)')
				->setOfflineText('(Offline)')
				->setRedirectUrl('https://tempuri.org/php')
				->setRecurring(false)
				->setIsRestricted(false)
				->setAge(0);

        $apiClient->oneClickConfigResource()->put($config);

        $this->assertEquals('APITEST', $config->getConfigId());
    }

    /**
     * @depends testPut
     */
    public function testGet()
    {
        $apiClient = $this->getApiClient();

        $config = $apiClient->oneClickConfigResource()->get('APITEST');

        $this->assertInstanceOf(OneClickConfig::class, $config);

        $this->assertEquals('APITEST', $config->getIdentifier());
    }
}