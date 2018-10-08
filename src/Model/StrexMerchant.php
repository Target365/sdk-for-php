<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class StrexMerchant extends AbstractModel
{
    protected $merchantId;

    protected $shortNumberId;

    protected $encryptedPassword;

    protected function attributes(): array
    {
        return [
          'merchantId',
          'shortNumberId',
          'encryptedPassword',
        ];
    }

    public function getIdentifier()
    {
        return $this->getMerchantId();
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

    public function getShortNumberId()
    {
        return $this->shortNumberId;
    }

    public function setShortNumberId($shortNumberId): self
    {
        $this->shortNumberId = $shortNumberId;

        return $this;
    }

    public function getEncryptedPassword(): string
    {
        return $this->encryptedPassword;
    }

    public function setEncryptedPassword(string $encryptedPassword): self
    {
        $this->encryptedPassword = $encryptedPassword;

        return $this;
    }

}