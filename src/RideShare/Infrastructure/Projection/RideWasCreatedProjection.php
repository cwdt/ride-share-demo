<?php

namespace RideShare\Infrastructure\Projection;

use Doctrine\DBAL\Connection;
use Elasticsearch\Client;
use RideShare\Domain\Ride\Events\RideWasCreated;
use RideShare\Infrastructure\Projection\Projection;

class RideWasCreatedProjection implements Projection
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
        return RideWasCreated::class;
    }

    /**
     * @param RideWasCreated $event
     */
    public function project($event)
    {
        $this->elasticSearchClient->create([
            'index' => 'rides',
            'type' => 'ride-departure',
            'id' => $event->getId(),
            'body' => [
                'departure' => $event->getDepartureTime()->format(DATE_ATOM)
            ]
        ]);
    }
}