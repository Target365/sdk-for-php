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
    protected $statusCode;
    protected $detailedStatusCode;
    protected $smscTransactionId;
    protected $created;
    protected $lastModified;

    protected function attributes(): array
    {
        return array_merge(parent::attributes(),
        [
            'transactionId',
            'sessionId',
            'correlationId',
            'shortNumber',
            'recipient',
            'content',
            'oneTimePassword',
            'deliveryMode',
            'statusCode',
            'detailedStatusCode',
            'smscTransactionId',
            'created',
            'lastModified',
        ]);
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

    public function getRecipient(): string
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

    public function setLastModified(string $lastModified): self
    {
        $this->lastModified = new DateTimeAttribute($lastModified);
        return $this;
    }

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
        return $this;
    }
}
