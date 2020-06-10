<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

class StrexRegistrationSms extends AbstractModel
{
    protected $merchantId;
    protected $transactionId;
    protected $recipient;
    protected $smsText;

    protected function attributes(): array
    {
        return [
            'merchantId',
            'transactionId',
            'recipient',
            'smsText',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->transactionId;
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

    public function getSmsText(): ?string
    {
        return $this->smsText;
    }

    public function setSmsText(string $smsText): self
    {
        $this->smsText = $smsText;
        return $this;
    }
}
