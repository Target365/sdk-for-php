<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

class PublicKey extends AbstractModel
{

    protected $accountId;

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
            'accountId',
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

    public function getIdentifier()
    {
        return $this->getName();
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExpiry()
    {
        return $this->expiry;
    }

    public function setExpiry($expiry): self
    {
        $this->expiry = $expiry;

        return $this;
    }

    public function getSignAlgo()
    {
        return $this->signAlgo;
    }

    public function setSignAlgo($signAlgo): self
    {
        $this->signAlgo = $signAlgo;

        return $this;
    }

    public function getHashAlgo()
    {
        return $this->hashAlgo;
    }

    public function setHashAlgo($hashAlgo): self
    {
        $this->hashAlgo = $hashAlgo;

        return $this;
    }

    public function getPublicKeyString()
    {
        return $this->publicKeyString;
    }

    public function setPublicKeyString($publicKeyString): self
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

    public function getCreated()
    {
        return $this->created;
    }

    public function setCreated($created): self
    {
        $this->created = $created;

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



}