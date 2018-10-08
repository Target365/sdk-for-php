<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\ApiClientException;
use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Model\OutMessage;
use Target365\ApiSdk\Tests\AbstractTestCase;

class OutMessageResourceTest extends AbstractTestCase
{

    /**
     * @return string e.g. '2018-04-12T13:27:50+00:00'
     */
    private function getSendTime(): string
    {
        $dateTime = new \DateTime();
        $dateInterval = \DateInterval::createFromDateString('5 days');

        $dateTime->add($dateInterval);

        // Using the DateTimeAttribute just to ensure the format is correct
        $dateTimeAttribute = new DateTimeAttribute($dateTime->format(\DateTime::ATOM));

        return $dateTimeAttribute->__toString();
    }

    public function testPrepareMsisdns()
    {
        $apiClient = $this->getApiClient();

        $apiClient->outMessageResource()->prepareMsisdns(['+4798079008']);

        $this->assertTrue(true);
    }


    public function testPostBatch()
    {
        $this->getSendTime();


        $apiClient = $this->getApiClient();

        $outMessage1 = new OutMessage();
        $outMessage1
            ->setTransactionId(uniqid((string) time(), true))
            ->setCorrelationId('12345')
            ->setSender('0000')
            ->setRecipient('+4798079008')
            ->setContent('Hi, this is the message :)')
            ->setSendTime($this->getSendTime())
            ->setTimeToLive(120)
            ->setPriority('Normal')
            ->setDeliveryMode('AtMostOnce')
            ->setDeliveryReportUrl('https://tempuri.org')
            ->setTags(['foo', 'bar']);

        $outMessage2 = new OutMessage();
        $outMessage2
            ->setTransactionId(uniqid((string) time(), true))
            ->setCorrelationId('19999')
            ->setSender('0000')
            ->setRecipient('+4798079008')
            ->setContent('Hi, this is another message :)')
            ->setSendTime($this->getSendTime())
            ->setTimeToLive(120)
            ->setPriority('Normal')
            ->setDeliveryMode('AtMostOnce')
            ->setDeliveryReportUrl('https://tempuri.org')
            ->setTags(['foo', 'bar']);

        $outMessages = [
            $outMessage1,
            $outMessage2,
        ];

        $apiClient->outMessageResource()->postBatch($outMessages);

        $this->assertTrue(true);
    }

    public function testPost()
    {
        $apiClient = $this->getApiClient();

        $outMessage = new OutMessage();

        $outMessage
            ->setCorrelationId('12345')
            ->setSender('0000')
            ->setRecipient('+4798079008')
            ->setContent('Hi, this is the message :)')
            ->setSendTime($this->getSendTime())
            ->setTimeToLive(120)
            ->setPriority('Normal')
            ->setDeliveryMode('AtMostOnce')
            ->setDeliveryReportUrl('https://tempuri.org')
            ->setTags(['foo', 'bar']);


        $identifier = $apiClient->outMessageResource()->post($outMessage);

        // The format of the identifier in the API coudl change at any time.
        // Hence just checking the legnth is greater/equal to 1
        $this->assertGreaterThanOrEqual(1, strlen((string) $identifier));

        return $identifier;
    }

    /**
     * @depends testPost
     */
    public function testGet($identifier)
    {
        $apiClient = $this->getApiClient();

        $outMessage = $apiClient->outMessageResource()->get($identifier);

        $this->assertInstanceOf(OutMessage::class, $outMessage);

        $this->assertEquals($identifier, $outMessage->getIdentifier());

        return $outMessage;
    }

    /**
     * @depends testGet
     */
    public function testPut(OutMessage $outMessage)
    {
        $apiClient = $this->getApiClient();

        $changedUrl = 'https://tempuri-changed.org';

        $outMessage
            ->setDeliveryReportUrl($changedUrl);

        $apiClient->outMessageResource()->put($outMessage);

        $outMessageChanged = $apiClient->outMessageResource()->get($outMessage->getIdentifier());

        $this->assertEquals($changedUrl, $outMessageChanged->getDeliveryReportUrl());

        return $outMessageChanged;
    }

    /**
     * @depends testPut
     */
    public function testDelete(OutMessage $outMessage)
    {
        $apiClient = $this->getApiClient();

        $apiClient->outMessageResource()->delete($outMessage->getIdentifier());

        $this->assertTrue(true);

        return $outMessage;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(OutMessage $outMessage)
    {
        $this->expectException(ApiClientException::class);

        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $apiClient->outMessageResource()->get($outMessage->getIdentifier());
    }

}