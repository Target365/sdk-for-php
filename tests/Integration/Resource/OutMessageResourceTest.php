<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Model\OutMessage;
use Target365\ApiSdk\Model\Properties;
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
            ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
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
            ->setTransactionId(str_replace('.', '-', uniqid((string) time(), true)))
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
        $properties = new Properties();
        $properties->foo = "bar";
        $properties->intValue = 123;
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
            ->setTags(['foo', 'bar'])
            ->setProperties($properties);

        $transactionId = $apiClient->outMessageResource()->post($outMessage);

        $this->assertTrue($transactionId != null);

        return $transactionId;
    }

    /**
     * @depends testPost
     */
    public function testGet($transactionId)
    {
        $apiClient = $this->getApiClient();

        $outMessage = $apiClient->outMessageResource()->get($transactionId);

        $this->assertInstanceOf(OutMessage::class, $outMessage);
        $this->assertEquals($transactionId, $outMessage->getTransactionId());
        $this->assertInstanceOf(Properties::class, $outMessage->getProperties());
        $this->assertEquals("bar", $outMessage->getProperties()->foo);
        $this->assertEquals(123, $outMessage->getProperties()->intValue);
        $this->assertTrue(in_array('foo', $outMessage->getTags()));
        $this->assertTrue(in_array('bar', $outMessage->getTags()));
        
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

        $outMessageChanged = $apiClient->outMessageResource()->get($outMessage->getTransactionId());

        $this->assertEquals($changedUrl, $outMessageChanged->getDeliveryReportUrl());

        return $outMessageChanged;
    }

    /**
     * @depends testPut
     */
    public function testDelete(OutMessage $outMessage)
    {        
        $apiClient = $this->getApiClient();

        $apiClient->outMessageResource()->delete($outMessage->getTransactionId());

        $this->assertTrue(true);

        return $outMessage;
    }

    /**
     * @depends testDelete
     */
    public function testConfirmDelete(OutMessage $outMessage)
    {
        $this->expectException(\Exception::class);

        $apiClient = $this->getApiClient();

        // This should 404 as it should have been deleted
        $result = $apiClient->outMessageResource()->get($outMessage->getTransactionId());
        
        $this.assertEquals($result, null);
    }
}