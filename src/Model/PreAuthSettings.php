<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Exception\ApiClientException;

class PreAuthSettings extends AbstractModel
{
    protected $infoText;
    protected $infoSender;
    protected $prefixMessage;
    protected $postfixMessage;
    protected $delay;
    protected $merchantId;
    protected $serviceDescription;
    protected $active;

    protected function attributes(): array
    {
        return [
            'infoText',
            'infoSender',
            'prefixMessage',
            'postfixMessage',
            'delay',
            'merchantId',
            'serviceDescription',
            'active',
        ];
    }

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return null;
    }

    public function getInfoText(): ?string
    {
        return $this->infoText;
    }

    public function setInfoText(string $infoText): self
    {
        $this->infoText = $infoText;
        return $this;
    }

    public function getInfoSender(): ?string
    {
        return $this->infoSender;
    }

    public function setInfoSender(string $infoSender): self
    {
        $this->infoSender = $infoSender;
        return $this;
    }
    
    public function getPrefixMessage(): ?string
    {
        return $this->prefixMessage;
    }

    public function setPrefixMessage(?string $prefixMessage): self
    {
        $this->prefixMessage = $prefixMessage;
        return $this;
    }

    public function getPostfixMessage(): ?string
    {
        return $this->postfixMessage;
    }

    public function setPostfixMessage(?string $postfixMessage): self
    {
        $this->postfixMessage = $postfixMessage;
        return $this;
    }

    public function getDelay()
    {
        return $this->delay;
    }

    public function setDelay(float $delay): self
    {
        $this->delay = $delay;
        return $this;
    }

    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    public function setMerchantId(?string $merchantId): self
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    public function getServiceDescription(): ?string
    {
        return $this->serviceDescription;
    }

    public function setServiceDescription(?string $serviceDescription): self
    {
        $this->serviceDescription = $serviceDescription;
        return $this;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
