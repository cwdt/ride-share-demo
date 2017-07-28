<?php

namespace RideShare\Infrastructure\Ui\Web\Controllers\Ride;

use DateTime;
use DateTimeImmutable;
use Elasticsearch\Client;
use RideShare\Application\ChangeDepartureTime\ChangeDepartureTimeCommand;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DepartureController extends Controller
{
    /** @var Client */
    protected $client;

    /** @var MessageBus */
    protected $commandBus;

    /**
     * @param Client $client
     * @param MessageBus $commandBus
     */
    public function __construct(Client $client, MessageBus $commandBus)
    {
        $this->client = $client;
        $this->commandBus = $commandBus;
    }


    public function change($rideId, $departureTime)
    {
        $this->commandBus->handle(
            new ChangeDepartureTimeCommand(
                $rideId,
                new DateTimeImmutable($departureTime)
            )
        );

        $this->addFlash('success',
            'The new departure is changed'
        );

        return $this->redirectToRoute('ride_departure_all');
    }

    /**
     * @return Response
     */
    public function all()
    {
        $response = $this->client->search(
            [
                'index' => 'rides',
                'type'  => 'ride-departure',
                'body'  => [
                    'query' => [
                        'bool' => [
                            'filter' => [
                                'range' => [
                                    'departure' => [
                                        'gte' => (new DateTime())->format(DATE_ATOM),
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'sort'  => [
                        'departure' => [
                            'order' => 'asc',
                        ],
                    ],
                ],
            ]
        );

        $rides = [];
        foreach ($response['hits']['hits'] as $hit) {
            $rides[] = $hit['_source'];
        }

        return $this->render('@WebUI/ride/departure/all.twig', ['rides' => $rides]);
    }
}