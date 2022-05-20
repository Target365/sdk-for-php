<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration\Resource;

use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Model\OutMessage;
use Target365\ApiSdk\Model\StrexData;
use Target365\ApiSdk\Model\Properties;
use Target365\ApiSdk\Tests\AbstractTestCase;

class OutMessageResourceTest extends AbstractTestCase
{
    /**
     * @return string e.g. '2018-04-12T13:27:50+00:00'
     * @throws \Target365\ApiSdk\Exception\ApiClientException
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

    public function testPostWithStrexData()
    {
        $strex = new StrexData();
        $strex
          ->setInvoiceText('Thank you for your donation')
          ->setMerchantId('mer_target365_as')
          ->setAge(18)
          ->setPrice(10)
          ->setTimeout(10)
          ->setServiceCode('14002');

        $apiClient = $this->getApiClient();

        $outMessage = new OutMessage();

        $outMessage
            ->setSender('0000')
            ->setRecipient('+4798079008')
            ->setContent('Hi, this is the message :)')
            ->setSendTime($this->getSendTime())
            ->setTimeToLive(120)
            ->setPriority('Normal')
            ->setDeliveryMode('AtMostOnce')
            ->setStrex($strex);

        $transactionId = $apiClient->outMessageResource()->post($outMessage);

        $this->assertTrue($transactionId != null);

        return $transactionId;
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

    /**
     * @return OutMessage
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function testSendScheduledSMS(): OutMessage
    {
        $dateTime = new \DateTime();
        $dateTime->add(\DateInterval::createFromDateString('1 hours'));
        $sendTime = (new DateTimeAttribute($dateTime->format(\DateTime::ATOM)))->__toString();

        $transactionId = uniqid((string) time(), true);
        $outMessage = new OutMessage();
        $outMessage
            ->setTransactionId($transactionId)
            ->setSendTime($sendTime)
            ->setSender('Target365')
            ->setRecipient('+4798079008')
            ->setContent('Hello World from SMS!');

        $apiClient = $this->getApiClient();
        $responseId = $apiClient->outMessageResource()->post($outMessage);

        $this->assertEquals($transactionId, $responseId);

        return $outMessage;
    }

    /**
     * @depends testSendScheduledSMS
     * @param OutMessage $outMessage
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \InvalidArgumentException
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     * @throws \Exception
     */
    public function testUpdateScheduledOutMessage(OutMessage $outMessage): void
    {
        $outMessage->getSendTime()->add(\DateInterval::createFromDateString('10 minutes'));
        $apiClient = $this->getApiClient();
        $apiClient->outMessageResource()->put($outMessage);
        $this->assertTrue(true);
    }

    public function testGetExport()
    {
        $apiClient = $this->getApiClient();
        $from = new DateTimeAttribute('2020-08-20T00:00:00+00:00');
        $to = new DateTimeAttribute('2020-08-21T00:00:00+00:00');
        $csv = $apiClient->outMessageResource()->getExport($from, $to);
        $find = 'SendTime,Sender,Recipient,RecipientPrefix,MessageParts,StatusCode,DetailedStatusCode,Operator,Tags';
        $this->assertEquals(0, substr_compare($csv, $find, 0, strlen($find)));
    }
}
