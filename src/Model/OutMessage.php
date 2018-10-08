<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class OutMessage extends AbstractModel
{
    protected $transactionId;

    protected $correlationId;

    protected $sender;

    protected $recipient;

    protected $content;

    protected $sendTime;

    protected $timeToLive;

    protected $priority;

    protected $deliveryMode;

    protected $deliveryReportUrl;

    protected $lastModified;

    protected $created;

    protected $tags;


    protected function attributes(): array
    {
        return [
            'transactionId',
            'correlationId',
            'sender',
            'recipient',
            'content',
            'sendTime',
            'timeToLive',
            'priority',
            'deliveryMode',
            'deliveryReportUrl',
            'lastModified',
            'created',
            'tags',
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

    public function getCorrelationId()
    {
        return $this->correlationId;
    }

    public function setCorrelationId($correlationId): self
    {
        $this->correlationId = $correlationId;
        
        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): self
    {
        $this->sender = $sender;
        
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

    public function getSendTime(): DateTimeAttribute
    {
        return $this->sendTime;
    }

    public function setSendTime($sendTime): self
    {
        $this->sendTime = new DateTimeAttribute($sendTime);
        
        return $this;
    }

    public function getTimeToLive()
    {
        return $this->timeToLive;
    }

    public function setTimeToLive($timeToLive): self
    {
        $this->timeToLive = $timeToLive;
        
        return $this;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function setPriority($priority): self
    {
        $this->priority = $priority;

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

    public function getDeliveryReportUrl()
    {
        return $this->deliveryReportUrl;
    }

    public function setDeliveryReportUrl($deliveryReportUrl): self
    {
        $this->deliveryReportUrl = $deliveryReportUrl;

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

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags)
    {
        $this->tags = $tags;

        return $this;
    }



}