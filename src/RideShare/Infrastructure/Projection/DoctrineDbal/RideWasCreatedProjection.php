<?php

namespace RideShare\Infrastructure\Projection\DoctrineDbal;

use Doctrine\DBAL\Connection;
use RideShare\Domain\Ride\Events\RideWasCreated;
use RideShare\Infrastructure\Projection\Projection;

class RideWasCreatedProjection implements Projection
{
    /** @var Connection */
    protected $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @inheritdoc
     */
    public function listensTo(): string
    {
        return RideWasCreated::class;
    }

    /**
     * @param RideWasCreated $event
     */
    public function project($event)
    {
        $statement = $this->connection->prepare(
            'INSERT INTO departure_times (ride_id, departure) VALUES (:ride_id, :departure)'
        );

        $statement->execute(['ride_id' => $event->getId(), 'departure' => $event->getDepartureTime()->format(DATE_ATOM)]);
    }
}