<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;


class StrexData extends AbstractModel
{
    protected $merchantId;
    protected $serviceCode;
    protected $businessModel;
    protected $preAuthServiceId;
    protected $preAuthServiceDescription;
    protected $age;
    protected $isRestricted;
    protected $smsConfirmation;
    protected $invoiceText;
    protected $price;
    protected $timeout;
    protected $billed;
    protected $resultCode;
    protected $resultDescription;

    protected function attributes(): array
    {
        return [
            'merchantId',
            'serviceCode',
            'businessModel',
            'preAuthServiceId',
            'preAuthServiceDescription',
            'age',
            'isRestricted',
            'smsConfirmation',
            'invoiceText',
            'price',
            'timeout',
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

    /**
     * @return static
     */
    public function setMerchantId(string $merchantId): self
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getServiceCode(): string
    {
        return $this->serviceCode;
    }

    /**
     * @return static
     */
    public function setServiceCode(string $serviceCode): self
    {
        $this->serviceCode = $serviceCode;
        return $this;
    }
    
    public function getBusinessModel(): ?string
    {
        return $this->businessModel;
    }

    /**
     * @return static
     */
    public function setBusinessModel(?string $businessModel): self
    {
        $this->businessModel = $businessModel;
        return $this;
    }

    public function getPreAuthServiceId(): ?string
    {
        return $this->preAuthServiceId;
    }

    /**
     * @return static
     */
    public function setPreAuthServiceId(?string $preAuthServiceId): self
    {
        $this->preAuthServiceId = $preAuthServiceId;
        return $this;
    }

    public function getPreAuthServiceDescription(): ?string
    {
        return $this->preAuthServiceDescription;
    }

    /**
     * @return static
     */
    public function setPreAuthServiceDescription(?string $preAuthServiceDescription): self
    {
        $this->preAuthServiceDescription = $preAuthServiceDescription;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @return static
     */
    public function setAge(?int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getIsRestricted(): ?bool
    {
        return $this->isRestricted;
    }

    /**
     * @return static
     */
    public function setIsRestricted(?bool $isRestricted): self
    {
        $this->isRestricted = $isRestricted;
        return $this;
    }

    public function getSmsConfirmation(): ?bool
    {
        return $this->smsConfirmation;
    }

    /**
     * @return static
     */
    public function setSmsConfirmation(?bool $smsConfirmation): self
    {
        $this->smsConfirmation = $smsConfirmation;
        return $this;
    }

    public function getInvoiceText(): string
    {
        return $this->invoiceText;
    }

    /**
     * @return static
     */
    public function setInvoiceText(string $invoiceText): self
    {
        $this->invoiceText = $invoiceText;
        return $this;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return static
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    /**
     * @return static
     */
    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function getBilled(): ?bool
    {
        return $this->billed;
    }

    /**
     * @return static
     */
    public function setBilled(?bool $billed): self
    {
        $this->billed = $billed;
        return $this;
    }

    public function getResultCode(): ?string
    {
        return $this->resultCode;
    }

    /**
     * @return static
     */
    public function setResultCode(?string $resultCode): self
    {
        $this->resultCode = $resultCode;
        return $this;
    }

    public function getResultDescription(): ?string
    {
        return $this->resultDescription;
    }

    /**
     * @return static
     */
    public function setResultDescription(?string $resultDescription): self
    {
        $this->resultDescription = $resultDescription;
        return $this;
    }
}
