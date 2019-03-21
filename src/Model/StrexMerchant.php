<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

class StrexMerchant extends AbstractModel
{
    protected $merchantId;
    protected $shortNumberIds;
    protected $password;

    protected function attributes(): array
    {
        return [
          'merchantId',
          'shortNumberIds',
          'password',
        ];
    }

    public function getIdentifier(): string
    {
        return $this->getMerchantId();
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

    public function getShortNumberIds(): ?array
    {
        return $this->shortNumberIds;
    }

    public function setShortNumberIds(?array $shortNumberIds): self
    {
        $this->shortNumberIds = $shortNumberIds;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;
        return $this;
    }
}
