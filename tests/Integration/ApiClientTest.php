<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Integration;

use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Model\OutMessage;
use Target365\ApiSdk\Tests\AbstractTestCase;

class ApiClientTest extends AbstractTestCase
{
    public function testRequest(): void
    {
        $apiClient = $this->getApiClient();

        $response = $apiClient->request(
            'get',
            'ping'
        );

        $this->assertEquals(
            '"pong"',
            $response->getBody()->__toString()
        );
    }

    public function testRequestFail(): void
    {
        $this->expectException(\Exception::class);

        $apiClient = $this->getApiClient();


        $apiClient->request(
            'get',
            'https://httpstat.us/400'
        );
    }

    public function testSendSMS(): void
    {
        $transactionId = uniqid((string) time(), true);
        $outMessage = new OutMessage();
        $outMessage
            ->setTransactionId($transactionId)
            ->setSender('Target365')
            ->setRecipient('+4798079008')
            ->setContent('Hello World from SMS!');

        $apiClient = $this->getApiClient();
        $responseId = $apiClient->outMessageResource()->post($outMessage);

        $this->assertEquals($transactionId, $responseId);
    }

    public function testSendScheduledSMS(): void
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
    }
}