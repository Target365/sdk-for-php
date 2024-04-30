<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

class Pincode extends AbstractModel
{
    protected $transactionId;
    protected $recipient;
    protected $sender;
    protected $prefixText;
    protected $suffixText;
    protected $pincodeLength;
    protected $maxAttempts;

    public function attributes(): array
    {
        return [
          'transactionId',
          'recipient',
          'sender',
          'prefixText',
          'suffixText',
          'pincodeLength',
          'maxAttempts',
        ];
    }

    public function getIdentifier(): ?string
    {
        return $this->getTransactionId();
    }

    public function getTransactionId() : ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getRecipient() : ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getSender() : ?string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getPrefixText() : ?string
    {
        return $this->prefixText;
    }

    public function setPrefixText(string $prefixText): self
    {
        $this->prefixText = $prefixText;
        return $this;
    }

    public function getSuffixText() : ?string
    {
        return $this->suffixText;
    }

    public function setSuffixText(string $suffixText): self
    {
        $this->suffixText = $suffixText;
        return $this;
    }

    public function getPincodeLength() : ?int
    {
        return $this->pincodeLength;
    }

    public function setPincodeLength(int $pincodeLength): self
    {
        $this->pincodeLength = $pincodeLength;
        return $this;
    }

    public function getMaxAttempts() : ?int
    {
        return $this->maxAttempts;
    }

    public function setMaxAttempts(int $maxAttempts): self
    {
        $this->maxAttempts = $maxAttempts;
        return $this;
    }
}
