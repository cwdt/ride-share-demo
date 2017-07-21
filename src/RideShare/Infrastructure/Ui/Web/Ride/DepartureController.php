<?php

namespace RideShare\Infrastructure\Ui\Web\Ride;

use Elasticsearch\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * @return JsonResponse
     */
    public function all()
    {
        $response = $this->client->search([
            'index' => 'rides',
            'type' => 'ride-departure',
            'body' => [
                'sort' => [
                    'departure' => ['order' => 'desc']
                ]
            ]
        ]);

        return new JsonResponse($response);
    }
}