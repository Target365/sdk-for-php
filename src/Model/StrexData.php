<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;

class StrexData extends AbstractModel
{
    protected $merchantId;
    protected $serviceCode;
    protected $businessModel;
    protected $smsConfirmation;
    protected $invoiceText;
    protected $price;
    protected $billed;
    protected $resultCode;
    protected $resultDescription;

    protected function attributes(): array
    {
        return [
            'merchantId',
            'serviceCode',
            'businessModel',
            'smsConfirmation',
            'invoiceText',
            'price',
            'billed',
            'resultCode',
            'resultDescription',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return null;
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

    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    public function setServiceCode(string $serviceCode): self
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }
    
    public function getBusinessModel(): ?string
    {
        return $this->businessModel;
    }

    public function setBusinessModel(?string $businessModel): self
    {
        $this->businessModel = $businessModel;
        return $this;
    }

    public function getSmsConfirmation(): ?bool
    {
        return $this->smsConfirmation;
    }

    public function setSmsConfirmation(?bool $smsConfirmation): self
    {
        $this->smsConfirmation = $smsConfirmation;
        return $this;
    }

    public function getInvoiceText(): string
    {
        return $this->invoiceText;
    }

    public function setInvoiceText(string $invoiceText): self
    {
        $this->invoiceText = $invoiceText;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
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

    public function getResultCode(): ?string
    {
        return $this->resultCode;
    }

    public function setResultCode(?string $resultCode): self
    {
        $this->resultCode = $resultCode;
        return $this;
    }

    public function getResultDescription(): ?string
    {
        return $this->resultDescription;
    }

    public function setResultDescription(?string $resultDescription): self
    {
        $this->resultDescription = $resultDescription;
        return $this;
    }
}
