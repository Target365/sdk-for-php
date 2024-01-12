<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Psr\Http\Message\RequestInterface;
use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Exception\ApiClientException;

class DeliveryReport extends AbstractModel implements DynamicPropertiesInterface
{
    protected $transactionId;
    protected $correlationId;
    protected $sessionId;
    protected $sender;
    protected $recipient;
    protected $operatorId;
    protected $price;
    protected $statusCode;
    protected $detailedStatusCode;
    protected $statusDescription;
    protected $delivered;
    protected $billed;
    protected $smscTransactionId;
    protected $smscStatus;
    protected $smscMessageParts;
    protected $received;
    protected $properties;

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
            'correlationId',
            'sessionId',
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
            'smscMessageParts',
            'properties',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return null;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getCorrelationId(): ?string
    {
        return $this->correlationId;
    }

    public function setCorrelationId(?string $correlationId): self
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getOperatorId(): ?string
    {
        return $this->operatorId;
    }

    public function setOperatorId(?string $operatorId): self
    {
        $this->operatorId = $operatorId;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getStatusCode(): string
    {
        return $this->statusCode;
    }

    public function setStatusCode(string $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getDetailedStatusCode(): string
    {
        return $this->detailedStatusCode;
    }

    public function setDetailedStatusCode(string $detailedStatusCode): self
    {
        $this->detailedStatusCode = $detailedStatusCode;
        return $this;
    }

    public function getStatusDescription(): string
    {
        return $this->statusDescription;
    }

    public function setStatusDescription(string $statusDescription): self
    {
        $this->statusDescription = $statusDescription;
        return $this;
    }

    public function getDelivered(): ?bool
    {
        return $this->delivered;
    }

    public function setDelivered(?bool $delivered): self
    {
        $this->delivered = $delivered;
        return $this;
    }

    public function getBilled(): ?bool
    {
        return $this->billed;
    }

    public function setBilled(?bool $billed): self
    {
        $this->billed = $billed;
        return $this;
    }

    public function getSmscTransactionId(): ?string
    {
        return $this->smscTransactionId;
    }

    public function setSmscTransactionId(?string $smscTransactionId): self
    {
        $this->smscTransactionId = $smscTransactionId;
        return $this;
    }

    public function getSmscStatus(): ?string
    {
        return $this->smscStatus;
    }

    public function setSmscTransactionId(?string $smscStatus): self
    {
        $this->smscStatus = $smscStatus;
        return $this;
    }
    public function getSmscMessageParts(): int
    {
        return $this->smscMessageParts;
    }

    public function setSmscMessageParts(int $smscMessageParts): self
    {
        $this->smscMessageParts = $smscMessageParts;
        return $this;
    }

    public function getReceived(): ?DateTimeAttribute
    {
        return $this->received;
    }

    public function setReceived(string $recevied): self
    {
        $this->received = new DateTimeAttribute($received);
        return $this;
    }

    public function getProperties(): ?Properties
    {
        return $this->properties;
    }

    public function setProperties(?Properties $properties): self
    {
        $this->properties = $properties;
        return $this;
    }
}
