<?php

namespace RideShare\Domain\Core\Events;

use DateTimeImmutable;

abstract class DomainEvent
{
    /** @var DateTimeImmutable */
    protected $occurredOn;

    /**
     * @return DateTimeImmutable
     */
    public function getOccurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}