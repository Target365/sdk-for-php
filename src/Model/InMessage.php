<?php

declare(strict_types = 1);

namespace Target365\ApiSdk\Model;

use Psr\Http\Message\RequestInterface;
use Target365\ApiSdk\Attribute\DateTimeAttribute;

class InMessage extends AbstractModel implements DynamicPropertiesInterface
{
    protected $transactionId;
    protected $keywordId;
    protected $sender;
    protected $recipient;
    protected $content;
    protected $isStopMessage;
    protected $processAttempts;
    protected $processed;
    protected $created;
    protected $tags;
    protected $properties;

    /**
     * Creates a Message object from the raw POST data
     *
     * @return InMessage
     * @throws \RuntimeException If the POST data is absent, or not a valid JSON document
     * @throws \InvalidArgumentException
     */
    public static function fromRawPostData(): InMessage
    {
        // Read the raw POST data and JSON-decode it into a message.
        return self::fromJsonString(file_get_contents('php://input'));
    }

    /**
     * Creates a Message object from a PSR-7 Request or ServerRequest object.
     *
     * @param RequestInterface $request
     * @return InMessage
     * @throws \InvalidArgumentException
     */
    public static function fromPsrRequest(RequestInterface $request): InMessage
    {
        return self::fromJsonString($request->getBody()->getContents());
    }

    /**
     * Creates a Message object from a JSON-decodable string.
     *
     * @param string $json
     * @return InMessage
     * @throws \InvalidArgumentException
     */
    public static function fromJsonString(string $json): InMessage
    {
        $data = \GuzzleHttp\json_decode($json, true);
        $inMessage = new self();
        $inMessage->populate($data);
        return $inMessage;
    }
    
    protected function attributes(): array
    {
        return [
            'transactionId',
            'keywordId',
            'sender',
            'recipient',
            'content',
            'isStopMessage',
            'processAttempts',
            'processed',
            'created',
            'tags',
            'properties',
        ];
    }

    public function getIdentifier(): string
    {
        return $this->getTransactionId();
    }

    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;
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

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function getIsStopMessage(): bool
    {
        return $this->isStopMessage;
    }

    public function setIsStopMessage(bool $isStopMessage): self
    {
        $this->isStopMessage = $isStopMessage;
        return $this;
    }

    public function getProcessAttempts(): int
    {
        return $this->processAttempts;
    }

    public function setProcessAttempts(int $processAttempts): self
    {
        $this->processAttempts = $processAttempts;
        return $this;
    }

    public function getProcessed(): bool
    {
        return $this->processed;
    }

    public function setProcessed(bool $processed): self
    {
        $this->processed = $processed;
        return $this;
    }

    public function getCreated(): ?DateTimeAttribute
    {
        return $this->created;
    }

    /**
     * @param string $created
     * @return InMessage
     * @throws \Target365\ApiSdk\Exception\ApiClientException
     */
    public function setCreated(string $created): self
    {
        $this->created = new DateTimeAttribute($created);
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

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }
}
