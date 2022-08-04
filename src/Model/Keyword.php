<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class Keyword extends AbstractModel implements DynamicPropertiesInterface
{
    protected $keywordId;
    protected $shortNumberId;
    protected $keywordText;
    protected $mode;
    protected $forwardUrl;
    protected $preAuthSettings;
    protected $enabled;
    protected $created;
    protected $lastModified;
    protected $customProperties;
    protected $tags;
    protected $aliases;

    public function attributes(): array
    {
        return [
          'keywordId',
          'shortNumberId',
          'keywordText',
          'mode',
          'forwardUrl',
          'preAuthSettings',
          'enabled',
          'created',
          'lastModified',
          'customProperties',
          'tags',
          'aliases',
        ];
    }

    public function getIdentifier(): ?string
    {
        return $this->getKeywordId();
    }

    public function getKeywordId() : ?string
    {
        return $this->keywordId;
    }

    public function setKeywordId(string $keywordId): self
    {
        $this->keywordId = $keywordId;
        return $this;
    }

    public function getShortNumberId(): string
    {
        return $this->shortNumberId;
    }

    public function setShortNumberId(string $shortNumberId): self
    {
        $this->shortNumberId = $shortNumberId;
        return $this;
    }

    public function getKeywordText(): string
    {
        return $this->keywordText;
    }

    public function setKeywordText(string $keywordText): self
    {
        $this->keywordText = $keywordText;
        return $this;
    }

    public function getMode(): string
    {
        return $this->mode;
    }

    public function setMode(string $mode): self
    {
        $this->mode = $mode;

        return $this;
    }

    public function getForwardUrl(): string
    {
        return $this->forwardUrl;
    }

    public function setForwardUrl(string $forwardUrl): self
    {
        $this->forwardUrl = $forwardUrl;
        return $this;
    }

    public function getPreAuthSettings(): ?PreAuthSettings
    {
        return $this->preAuthSettings;
    }

    public function setPreAuthSettings(?PreAuthSettings $preAuthSettings): self
    {
        $this->preAuthSettings = $preAuthSettings;
        return $this;
    }

    public function getEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
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

    public function getProperties(): ?Properties
    {
        return $this->customProperties;
    }

    public function setProperties(?Properties $customProperties): self
    {
        $this->customProperties = $customProperties;
        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function getAliases(): ?array
    {
        return $this->aliases;
    }

    public function setAliases(?array $aliases): self
    {
        $this->aliases = $aliases;
        return $this;
    }
}
