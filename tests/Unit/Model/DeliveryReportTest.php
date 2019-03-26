<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Tests\Unit\Model;

use GuzzleHttp\Psr7\Request;
use Target365\ApiSdk\Model\DeliveryReport;
use Target365\ApiSdk\Tests\AbstractTestCase;
use Target365\ApiSdk\Tests\Secrets;

class DeliveryReportTest extends AbstractTestCase
{
    protected const DELIVERY_REPORT_OK_PAYLOAD = '{   
                                                      "correlationId": null,
                                                      "transactionId": "client-specified-id-5c88e736bb4b8",
                                                      "price": null,
                                                      "sender": "Target365",
                                                      "recipient": "+4798079008",
                                                      "operatorId": "no.telenor",
                                                      "statusCode": "Ok",
                                                      "detailedStatusCode": "Delivered",
                                                      "delivered": true,
                                                      "smscMessageParts": 1,
                                                      "billed": null,
                                                      "smscTransactionId": "16976c7448d"
                                                    }';

    public function testFromPsrRequest(): void
    {
        $secrets = new Secrets();
        $request = new Request('POST', $secrets->getDomainUri(), [], self::DELIVERY_REPORT_OK_PAYLOAD);

        try {
            $dlr = DeliveryReport::fromPsrRequest($request);

            $dlrData = \GuzzleHttp\json_decode($request->getBody(), true);
            $this->assertEquals($dlr->getTransactionId(), $dlrData['transactionId']);

            $deliveryReportAttributes = $this->invokePrivateMethod($dlr, 'attributes');
            foreach ($deliveryReportAttributes as $key)  {
                $methodName = 'get' . ucfirst($key);
                $this->assertEquals($dlr->$methodName(), $dlrData[$key]);
            }
        } catch (\InvalidArgumentException $e) {
            $this->fail($e->getMessage());
        }
    }
}
