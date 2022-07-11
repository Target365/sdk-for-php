<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class OutMessage extends AbstractModel implements DynamicPropertiesInterface
{
    protected $transactionId;
    protected $sessionId;
    protected $correlationId;
    protected $keywordId;
    protected $sender;
    protected $recipient;
    protected $content;
    protected $strex;
    protected $allowUnicode;
    protected $sendTime;
    protected $timeToLive;
    protected $priority;
    protected $deliveryMode;
    protected $deliveryReportUrl;
    protected $statusCode;
    protected $smscTransactionId;
    protected $detailedStatusCode;
    protected $statusDescription;
    protected $delivered;
    protected $operatorId;
    protected $smscMessageParts;
    protected $tags;
    protected $properties;
    protected $lastModified;
    protected $created;

    /**
     * Gets the number of sms message parts are required for a given text and encoding
     *
     * @param string $text
     * @param bool $unicode
     * @return int
     */
    public static function getSmsPartsForText(string $text, ?bool $unicode = null): int
    {
        if ($unicode === true) {
            return (strlen($text) <= 70) ? 1 : (int)ceil(strlen($text) / 67);
        }
        
        $extendedChars = [chr(12), '^', '{', '}', '\\', '[', '~', ']', '|', '€'];
        $totalCharCount = 0;

        $stringLength = strlen($text);
        for ($i = 0; $i < $stringLength; $i++) {
            $totalCharCount++;
            
            if (in_array($text[$i], $extendedChars, true)) {
                $totalCharCount++;
            }
        }

        if ($totalCharCount <= 160) {
            return 1;
        }

        $maxSeptetsPerPart = 153;
        $parts = 1;
        $septets = 0;

        for ($i = 0; $i < $stringLength; $i++) {
            if ($septets === $maxSeptetsPerPart || ($septets === ($maxSeptetsPerPart - 1) && in_array($text[$i], $extendedChars, true))) {
                $parts++;
                $septets = 0;
            }
            
            if (in_array($text[$i], $extendedChars, true)) {
                $septets += 2;
            } else {
                $septets += 1;
            }
        }

        return $parts;
    }
    
    protected function attributes(): array
    {
        return [
            'transactionId',
            'sessionId',
            'correlationId',
            'keywordId',
            'sender',
            'recipient',
            'content',
            'strex',
            'allowUnicode',
            'sendTime',
            'timeToLive',
            'priority',
            'deliveryMode',
            'deliveryReportUrl',
            'statusCode',
            'smscTransactionId',
            'detailedStatusCode',
            'statusDescription',
            'delivered',
            'smscMessageParts',
            'tags',
            'properties',
            'lastModified',
            'created',
        ];
    }
    
    public function getIdentifier(): ?string
    {
        return $this->getTransactionId();
    }

    public function getSmsParts() : int
    {
        return OutMessage::getSmsPartsForText($this->getContent() ?? '', $this->getAllowUnicode());
    }
    
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(?string $transactionId): self
    {
        $this->transactionId = $transactionId;
        return $this;
    }

    public function getCorrelationId(): ?string
    {
        return $this->correlationId;
    }

    public function setCorrelationId(?string $correlationId): self
    {
        $this->correlationId = $correlationId;
        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): self
    {
        $this->sessionId = $sessionId;
        return $this;
    }

    public function getKeywordId(): ?string
    {
        return $this->keywordId;
    }

    public function setKeywordId(?string $keywordId): self
    {
        $this->keywordId = $keywordId;
        return $this;
    }

    public function getSender(): string
    {
        return $this->sender;
    }

    public function setSender(string $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getStrex(): ?StrexData
    {
        return $this->strex;
    }

    public function setStrex(?StrexData $strex): self
    {
        $this->strex = $strex;
        return $this;
    }

    public function getAllowUnicode(): ?bool
    {
        return $this->allowUnicode;
    }

    public function setAllowUnicode(?bool $allowUnicode): self
    {
        $this->allowUnicode = $allowUnicode;
        return $this;
    }
    
    public function getSendTime(): ?DateTimeAttribute
    {
        return $this->sendTime;
    }

    /**
     * @param string $sendTime
     * @return OutMessage
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function setSendTime(string $sendTime): self
    {
        $this->sendTime = new DateTimeAttribute($sendTime);
        return $this;
    }

    public function getTimeToLive(): ?int
    {
        return $this->timeToLive;
    }

    public function setTimeToLive(?int $timeToLive): self
    {
        $this->timeToLive = $timeToLive;
        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(?string $priority): self
    {
        $this->priority = $priority;
        return $this;
    }

    public function getDeliveryMode(): ?string
    {
        return $this->deliveryMode;
    }

    public function setDeliveryMode(?string $deliveryMode): self
    {
        $this->deliveryMode = $deliveryMode;
        return $this;
    }

    public function getDeliveryReportUrl(): ?string
    {
        return $this->deliveryReportUrl;
    }

    public function setDeliveryReportUrl(?string $deliveryReportUrl): self
    {
        $this->deliveryReportUrl = $deliveryReportUrl;
        return $this;
    }

    public function getStatusCode(): ?string
    {
        return $this->statusCode;
    }

    public function setStatusCode(?string $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getSmscTransactionId(): ?string
    {
        return $this->smscTransactionId;
    }

    public function setSmscTransactionId(?string $smscTransactionId): self
    {
        $this->smscTransactionId = $smscTransactionId;
        return $this;
    }

    public function getDetailedStatusCode(): ?string
    {
        return $this->detailedStatusCode;
    }

    public function setDetailedStatusCode(?string $detailedStatusCode): self
    {
        $this->detailedStatusCode = $detailedStatusCode;
        return $this;
    }

    public function getStatusDescription(): ?string
    {
        return $this->statusDescription;
    }

    public function setStatusDescription(?string $statusDescription): self
    {
        $this->statusDescription = $statusDescription;
        return $this;
    }

    public function getDelivered(): ?bool
    {
        return $this->delivered;
    }

    public function setDelivered(?bool $delivered): self
    {
        $this->delivered = $delivered;
        return $this;
    }

    public function getOperatorId(): ?string
    {
        return $this->operatorId;
    }

    public function setOperatorId(?string $operatorId): self
    {
        $this->operatorId = $operatorId;
        return $this;
    }

    public function getSmscMessageParts(): ?int
    {
        return $this->smscMessageParts;
    }

    public function setSmscMessageParts(int $smscMessageParts): self
    {
        $this->smscMessageParts = $smscMessageParts;
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

    public function getProperties(): ?Properties
    {
        return $this->properties;
    }

    public function setProperties(?Properties $properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    public function getLastModified(): ?DateTimeAttribute
    {
        return $this->lastModified;
    }

    /**
     * @param string $lastModified
     * @return OutMessage
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
     * @return OutMessage
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
        return $this;
    }
}
