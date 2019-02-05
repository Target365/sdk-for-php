<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;


class StrexTransaction extends AbstractModel
{

    protected $transactionId;

    protected $invoiceText;

    protected $lastModified;

    protected $merchantId;

    protected $price;

    protected $recipient;
    
    protected $content;

    protected $serviceCode;

    protected $shortNumber;

    protected $created;

    protected $deliveryMode;

    protected $statusCode;

    protected $accountId;

    protected $strexOtpTransactionId;

    protected $smscTransactionId;

    protected $eTag;

    protected $billed;


    protected function attributes(): array
    {
        return [
            'transactionId',
            'invoiceText',
            'lastModified',
            'merchantId',
            'price',
            'recipient',
            'serviceCode',
            'shortNumber',
            'created',
            'deliveryMode',
            'statusCode',
            'accountId',
            'strexOtpTransactionId',
            'smscTransactionId',
            'eTag',
            'billed',
        ];
    }

    public function getIdentifier()
    {
        return $this->getTransactionId();
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

    public function getInvoiceText()
    {
        return $this->invoiceText;
    }

    public function setInvoiceText($invoiceText): self
    {
        $this->invoiceText = $invoiceText;

        return $this;
    }

    public function getLastModified()
    {
        return $this->lastModified;
    }

    public function setLastModified($lastModified): self
    {
        $this->lastModified = $lastModified;

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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    public function setRecipient($recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    public function setServiceCode($serviceCode): self
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getShortNumber()
    {
        return $this->shortNumber;
    }

    public function setShortNumber($shortNumber): self
    {
        $this->shortNumber = $shortNumber;

        return $this;
    }

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    public function getDeliveryMode()
    {
        return $this->deliveryMode;
    }

    public function setDeliveryMode($deliveryMode): self
    {
        $this->deliveryMode = $deliveryMode;

        return $this;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setStatusCode($statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getAccountId()
    {
        return $this->accountId;
    }

    public function setAccountId($accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getStrexOtpTransactionId()
    {
        return $this->strexOtpTransactionId;
    }

    public function setStrexOtpTransactionId($strexOtpTransactionId): self
    {
        $this->strexOtpTransactionId = $strexOtpTransactionId;

        return $this;
    }

    public function getSmscTransactionId()
    {
        return $this->smscTransactionId;
    }

    public function setSmscTransactionId($smscTransactionId): self
    {
        $this->smscTransactionId = $smscTransactionId;

        return $this;
    }

    public function getETag()
    {
        return $this->eTag;
    }

    public function setETag($eTag): self
    {
        $this->eTag = $eTag;

        return $this;
    }

    public function getBilled()
    {
        return $this->billed;
    }

    public function setBilled($billed): self
    {
        $this->billed = $billed;

        return $this;
    }


}
