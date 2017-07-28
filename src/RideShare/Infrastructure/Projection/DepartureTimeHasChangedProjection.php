<?php

namespace RideShare\Infrastructure\Projection;

use Doctrine\DBAL\Connection;
use Elasticsearch\Client;
use RideShare\Domain\Ride\Events\DepartureTimeHasChanged;
use RideShare\Domain\Ride\Events\RideWasCreated;
use RideShare\Infrastructure\Projection\Projection;

class DepartureTimeHasChangedProjection implements Projection
{
    /** @var Client */
    protected $elasticSearchClient;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->elasticSearchClient = $client;
    }

    /**
     * @inheritdoc
     */
    public function listensTo(): string
    {
        return DepartureTimeHasChanged::class;
    }

    /**
     * @param DepartureTimeHasChanged $event
     */
    public function project($event)
    {
        $this->elasticSearchClient->update([
            'index' => 'rides',
            'type' => 'ride-departure',
            'id' => (string)$event->getRideId(),
            'body' => [
                'doc' => [
                    'id' => (string)$event->getRideId(),
                    'departure' => $event->getDepartureTime()->format(DATE_ATOM)
                ]
            ]
        ]);
    }
}