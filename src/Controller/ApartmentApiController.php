<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApartmentApiController extends AbstractController
{
    /**
     * @Route("/apartment/api", name="apartment_api")
     */
    public function index()
    {

    }

    /*
     * @Route("/api/apartments/{id}/rooms")
     */
    public function showRooms($id) {
        $rooms = $this->getDoctrine(Apartment::class)
                    ->getRepository(Room::class)
                    ->findByApartment($id);

        return new JsonResponse($rooms);
    }
}
