<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;
use Target365\ApiSdk\Exception\ApiClientException;

class OneClickConfig extends AbstractModel
{
    protected $configId;
    protected $shortNumber;
    protected $merchantId;
    protected $serviceCode;
    protected $businessModel;
    protected $recurring;
    protected $redirectUrl;
    protected $onlineText;
    protected $offlineText;
    protected $age;
    protected $isRestricted;
    protected $invoiceText;
    protected $price;
    protected $subscriptionPrice;
    protected $subscriptionInterval;
    protected $subscriptionStartSms;
    protected $timeout;
    protected $created;
    protected $lastModified;

    protected function attributes(): array
    {
        return [
            'configId',
            'shortNumber',
            'merchantId',
            'serviceCode',
            'businessModel',
            'recurring',
            'redirectUrl',
            'onlineText',
            'offlineText',
            'age',
            'isRestricted',
            'invoiceText',
            'price',
            'subscriptionPrice',
            'subscriptionInterval',
            'subscriptionStartSms',
            'timeout',
            'created',
            'lastModified',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->configId;
    }

    public function getConfigId(): string
    {
        return $this->configId;
    }

    public function setConfigId(string $configId): self
    {
        $this->configId = $configId;
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

    public function getRecurring(): ?bool
    {
        return $this->recurring;
    }

    public function setRecurring(?bool $recurring): self
    {
        $this->recurring = $recurring;
        return $this;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function setRedirectUrl(?string $redirectUrl): self
    {
        $this->redirectUrl = $redirectUrl;
        return $this;
    }

    public function getOnlineText(): ?string
    {
        return $this->onlineText;
    }

    public function setOnlineText(?string $onlineText): self
    {
        $this->onlineText = $onlineText;
        return $this;
    }

    public function getOfflineText(): ?string
    {
        return $this->offlineText;
    }

    public function setOfflineText(?string $offlineText): self
    {
        $this->offlineText = $offlineText;
        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): self
    {
        $this->age = $age;
        return $this;
    }

    public function getIsRestricted(): ?bool
    {
        return $this->isRestricted;
    }

    public function setIsRestricted(?bool $isRestricted): self
    {
        $this->isRestricted = $isRestricted;
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

    public function getSubscriptionPrice(): ?float
    {
        return $this->subscriptionPrice;
    }

    public function setSubscriptionPrice(float $subscriptionPrice): self
    {
        $this->subscriptionPrice = $subscriptionPrice;
        return $this;
    }

    public function getSubscriptionInterval(): ?string
    {
        return $this->subscriptionInterval;
    }

    public function setSubscriptionInterval(string $subscriptionInterval): self
    {
        $this->subscriptionInterval = $subscriptionInterval;
        return $this;
    }

	public function getSubscriptionStartSms(): ?string
    {
        return $this->subscriptionStartSms;
    }

    public function setSubscriptionStartSms(string $subscriptionStartSms): self
    {
        $this->subscriptionStartSms = $subscriptionStartSms;
        return $this;
    }

    public function getTimeout(): ?int
    {
        return $this->timeout;
    }

    public function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout;
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
