<?php

namespace RideShare\Infrastructure\Ui\Web\Controllers\Ride;

use RideShare\Application\RegisterRide\RegisterRideCommand;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RideController extends Controller
{
    /** @var MessageBus */
    protected $commandBus;

    /**
     * @param MessageBus $commandBus
     */
    public function __construct(MessageBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('departure_latitude', NumberType::class)
            ->add('departure_longitude', NumberType::class)
            ->add('destination_latitude', NumberType::class)
            ->add('destination_longitude', NumberType::class)
            ->add('departure_time', DateTimeType::class, ['widget' => 'single_text'])
            ->add('save', SubmitType::class, array('label' => 'Register'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $this->commandBus->handle(new RegisterRideCommand(
                uniqid(),
                $data['departure_latitude'],
                $data['departure_longitude'],
                $data['destination_latitude'],
                $data['destination_longitude'],
                $data['departure_time']->format(DATE_ATOM)
            ));

            $this->addFlash('success',
                'The ride was registered'
            );

            return $this->redirectToRoute('ride_departure_all');
        }

        return $this->render('@WebUI/ride/register.twig', ['form' => $form->createView()]);
    }
}