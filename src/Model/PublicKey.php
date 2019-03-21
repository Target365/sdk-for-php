<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class PublicKey extends AbstractModel
{
    protected $name;
    protected $expiry;
    protected $signAlgo;
    protected $hashAlgo;
    protected $publicKeyString;
    protected $notUsableBefore;
    protected $created;
    protected $lastModified;

    protected function attributes(): array
    {
        return [
            'name',
            'expiry',
            'signAlgo',
            'hashAlgo',
            'publicKeyString',
            'notUsableBefore',
            'created',
            'lastModified',
        ];
    }

    public function getIdentifier(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExpiry(): ?DateTimeAttribute
    {
        return $this->expiry;
    }

    public function setExpiry(string $expiry): self
    {
        $this->expiry = new DateTimeAttribute($expiry);
        return $this;
    }

    public function getSignAlgo(): string
    {
        return $this->signAlgo;
    }

    public function setSignAlgo(string $signAlgo): self
    {
        $this->signAlgo = $signAlgo;
        return $this;
    }

    public function getHashAlgo(): string
    {
        return $this->hashAlgo;
    }

    public function setHashAlgo(string $hashAlgo): self
    {
        $this->hashAlgo = $hashAlgo;
        return $this;
    }

    public function getPublicKeyString(): string
    {
        return $this->publicKeyString;
    }

    public function setPublicKeyString(string $publicKeyString): self
    {
        $this->publicKeyString = $publicKeyString;
        return $this;
    }

    public function getNotUsableBefore()
    {
        return $this->notUsableBefore;
    }

    public function setNotUsableBefore($notUsableBefore): self
    {
        $this->notUsableBefore = $notUsableBefore;

        return $this;
    }

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
        return $this;
    }

    public function getLastModified(): ?DateTimeAttribute
    {
        return $this->lastModified;
    }

    public function setLastModified(string $lastModified): self
    {
        $this->lastModified = new DateTimeAttribute($lastModified);
        return $this;
    }
}
