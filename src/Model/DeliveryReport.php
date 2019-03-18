<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Psr\Http\Message\RequestInterface;

class DeliveryReport extends AbstractModel
{
    protected $accountId;
    protected $transactionId;
    protected $correlationId;
    protected $sender;
    protected $recipient;
    protected $operatorId;
    protected $price;
    protected $statusCode;
    protected $detailedStatusCode;
    protected $delivered;
    protected $billed;
    protected $smscTransactionId;
    protected $subMessageInfos;

    /**
     * Creates a Message object from the raw POST data
     *
     * @return DeliveryReport
     * @throws \RuntimeException If the POST data is absent, or not a valid JSON document
     * @throws \InvalidArgumentException
     */
    public static function fromRawPostData(): DeliveryReport
    {
        // Read the raw POST data and JSON-decode it into a message.
        return self::fromJsonString(file_get_contents('php://input'));
    }

    /**
     * Creates a Message object from a PSR-7 Request or ServerRequest object.
     *
     * @param RequestInterface $request
     * @return DeliveryReport
     * @throws \InvalidArgumentException
     */
    public static function fromPsrRequest(RequestInterface $request): DeliveryReport
    {
        return self::fromJsonString($request->getBody()->getContents());
    }

    /**
     * Creates a Message object from a JSON-decodable string.
     *
     * @param string $json
     * @return DeliveryReport
     * @throws \InvalidArgumentException
     */
    public static function fromJsonString(string $json): DeliveryReport
    {
        $data = \GuzzleHttp\json_decode($json, true);
        $dlr = new self();
        $dlr->populate($data);

        return $dlr;
    }

    protected function attributes(): array
    {
        return [
            'accountId',
            'correlationId',
            'transactionId',
            'price',
            'sender',
            'recipient',
            'operatorId',
            'statusCode',
            'detailedStatusCode',
            'delivered',
            'billed',
            'smscTransactionId',
            'subMessageInfos',
        ];
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setAccountId($accountId): void
    {
        $this->accountId = $accountId;
    }

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function setTransactionId($transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    public function getCorrelationId()
    {
        return $this->correlationId;
    }

    public function setCorrelationId($correlationId): void
    {
        $this->correlationId = $correlationId;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): void
    {
        $this->sender = $sender;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient): void
    {
        $this->recipient = $recipient;
    }

    public function getOperatorId()
    {
        return $this->operatorId;
    }

    public function setOperatorId($operatorId): void
    {
        $this->operatorId = $operatorId;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): void
    {
        $this->price = $price;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function getDetailedStatusCode()
    {
        return $this->detailedStatusCode;
    }

    public function setDetailedStatusCode($detailedStatusCode): void
    {
        $this->detailedStatusCode = $detailedStatusCode;
    }

    public function getDelivered()
    {
        return $this->delivered;
    }

    public function setDelivered($delivered): void
    {
        $this->delivered = $delivered;
    }

    public function getBilled()
    {
        return $this->billed;
    }

    public function setBilled($billed): void
    {
        $this->billed = $billed;
    }

    public function getSmscTransactionId()
    {
        return $this->smscTransactionId;
    }

    public function setSmscTransactionId($smscTransactionId): void
    {
        $this->smscTransactionId = $smscTransactionId;
    }

    public function getSubMessageInfos()
    {
        return $this->subMessageInfos;
    }

    public function setSubMessageInfos($subMessageInfos): void
    {
        $this->subMessageInfos = $subMessageInfos;
    }

    public function getIdentifier()
    {
        return $this->getSmscTransactionId();
    }
}
