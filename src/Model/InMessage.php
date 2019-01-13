<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Target365\ApiSdk\Attribute\DateTimeAttribute;

class InMessage extends AbstractModel
{

    protected $messageId;

    protected $transactionId;

    protected $processed;

    protected $processAttempts;

    protected $sender;

    protected $recipient;

    protected $content;

    protected $keywordId;

    protected $isStopMessage;

    protected $created;

    protected $properties;

    protected $tags;

    protected $eTag;


    protected function attributes(): array
    {
        return [
            'messageId',
            'transactionId',
            'processed',
            'processAttempts',
            'sender',
            'recipient',
            'content',
            'keywordId',
            'isStopMessage',
            'created',
            'properties',
            'tags',
            'eTag',
        ];
    }

    public function getIdentifier()
    {
        return $this->getMessageId();
    }

    public function getMessageId()
    {
        return $this->messageId;
    }

    public function setMessageId($messageId): self
    {
        $this->messageId = $messageId;

        return $this;
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

    public function getProcessed()
    {
        return $this->processed;
    }

    public function setProcessed($processed): self
    {
        $this->processed = $processed;

        return $this;
    }

    public function getProcessAttempts()
    {
        return $this->processAttempts;
    }

    public function setProcessAttempts($processAttempts): self
    {
        $this->processAttempts = $processAttempts;

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

    public function getKeywordId()
    {
        return $this->keywordId;
    }

    public function setKeywordId($keywordId): self
    {
        $this->keywordId = $keywordId;
        return $this;
    }

    public function getIsStopMessage()
    {
        return $this->isStopMessage;
    }

    public function setIsStopMessage($isStopMessage): self
    {
        $this->isStopMessage = $isStopMessage;
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

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties): self
    {
        $this->properties = $properties;
        return $this;
    }

    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags): self
    {
        $this->tags = $tags;

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


}
