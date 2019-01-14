<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;

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

    public function getIdentifier()
    {
        throw new ApiClientException('Not relevant to this resource');
    }


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

    public function getTransactionId()
    {
        return $this->transactionId;
    }

    public function setTransactionId($transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }

    public function getMerchantId()
    {
        return $this->merchantId;
    }

    public function setMerchantId($merchantId): self
    {
        $this->merchantId = $merchantId;

        return $this;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecurring()
    {
        return $this->recurring;
    }

    public function setRecurring(bool $recurring): self
    {
        $this->recurring = $recurring;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    public function setTimeToLive($timeToLive): self
    {
        $this->timeToLive = $timeToLive;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getDelivered()
    {
        return $this->delivered;
    }

    public function setDelivered($delivered): self
    {
        $this->delivered = $delivered;

        return $this;
    }

}