<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class StrexTransaction extends StrexData
{
    protected $transactionId;
    protected $sessionId;
    protected $correlationId;
    protected $shortNumber;
    protected $recipient;
    protected $content;
    protected $oneTimePassword;
    protected $deliveryMode;
    protected $tags;
    protected $properties;    
    protected $statusCode;
    protected $detailedStatusCode;
    protected $smscTransactionId;
    protected $created;
    protected $lastModified;

    protected function attributes(): array
    {
        return array_merge(
            parent::attributes(),
        [
            'transactionId',
            'sessionId',
            'correlationId',
            'shortNumber',
            'recipient',
            'content',
            'oneTimePassword',
            'deliveryMode',
            'tags',
            'properties',
            'statusCode',
            'detailedStatusCode',
            'smscTransactionId',
            'created',
            'lastModified',
        ]
        );
    }

    public function getIdentifier(): string
    {
        return $this->getTransactionId();
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;
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

    public function getCorrelationId(): ?string
    {
        return $this->correlationId;
    }

    public function setCorrelationId(?string $correlationId): self
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function getShortNumber(): string
    {
        return $this->shortNumber;
    }

    public function setShortNumber(string $shortNumber): self
    {
        $this->shortNumber = $shortNumber;
        return $this;
    }

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }
    
    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getOneTimePassword(): ?string
    {
        return $this->oneTimePassword;
    }

    public function setOneTimePassword(?string $oneTimePassword): self
    {
        $this->oneTimePassword = $oneTimePassword;
        return $this;
    }

    public function getDeliveryMode(): ?string
    {
        return $this->deliveryMode;
    }

    public function setDeliveryMode(?string $deliveryMode): self
    {
        $this->deliveryMode = $deliveryMode;
        return $this;
    }
    
    public function getTags(): ?array
    {
        return $this->tags;
    }
    
    public function setTags(?array $tags): self
    {
        $this->tags = $tags;
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
    
    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    public function setStatusCode(?string $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getDetailedStatusCode(): ?string
    {
        return $this->detailedStatusCode;
    }

    public function setDetailedStatusCode(?string $detailedStatusCode): self
    {
        $this->detailedStatusCode = $detailedStatusCode;
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

    public function getLastModified(): ?DateTimeAttribute
    {
        return $this->lastModified;
    }

    /**
     * @param string $lastModified
     * @return StrexTransaction
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function setLastModified(string $lastModified): self
    {
        $this->lastModified = new DateTimeAttribute($lastModified);
        return $this;
    }

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return StrexTransaction
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
        return $this;
    }
}
