<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;
use Target365\ApiSdk\Attribute\DateTimeAttribute;

class OneTimePassword extends AbstractModel
{
    protected $transactionId;
    protected $merchantId;
    protected $recipient;
    protected $sender;
    protected $recurring;
    protected $message;
    protected $timeToLive;
    protected $created;
    protected $delivered;

    protected function attributes(): array
    {
        return [
            'transactionId',
            'merchantId',
            'recipient',
            'sender',
            'recurring',
            'message',
            'timeToLive',
            'created',
            'delivered',
        ];
    }

    /**
     * @return string|null
     * @throws ApiClientException
     */
    public function getIdentifier(): ?string
    {
        throw new ApiClientException('Not relevant to this resource');
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

    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    public function setMerchantId(string $merchantId): self
    {
        $this->merchantId = $merchantId;
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

    public function getSender(): string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getRecurring(): bool
    {
        return $this->recurring;
    }

    public function setRecurring(bool $recurring): self
    {
        $this->recurring = $recurring;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function getTimeToLive(): ?int
    {
        return $this->timeToLive;
    }

    public function setTimeToLive(?int $timeToLive): self
    {
        $this->timeToLive = $timeToLive;
        return $this;
    }

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return OneTimePassword
     * @throws ApiClientException
     */
    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
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
}
