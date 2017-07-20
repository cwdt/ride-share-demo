<?php

namespace RideShare\Infrastructure\EventStore\Doctrine;

use DateTimeImmutable;

class StoredEvent
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $event;

    /** @var DateTimeImmutable */
    protected $occurredOn;

    /** @var string */
    protected $body;

    /**
     * @param string $event
     * @param DateTimeImmutable $occurredOn
     * @param string $body
     */
    public function __construct(string $event, DateTimeImmutable $occurredOn, string $body)
    {
        $this->event = $event;
        $this->occurredOn = $occurredOn;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}