<?php

namespace RideShare\Infrastructure\Ui\Web\Controllers\Ride;

use DateTime;
use Elasticsearch\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DepartureController extends Controller
{
    /** @var Client */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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