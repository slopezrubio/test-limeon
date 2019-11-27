<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Building;
use App\Entity\Apartment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BuildingApiController extends AbstractController
{
    /**
     * Returns a JSON Response with all the buildings bound to one or more apartments that simultaneously
     * have one or more rooms linked to them.
     *
     * @Route("/api/buildings", name="api_buildings")
     *
     * @return JsonResponse
     */
    public function index()
    {
        $buildings = $this->getDoctrine()
            ->getRepository(Building::class)
            ->findBuildingsWithRooms();

        return new JsonResponse($buildings);
    }

    /**
     * Returns a JSON Response with
     *
     * @Route("/api/buildings/{id}/apartments")
     *
     * @param $id
     * @return JsonResponse
     */
    public function showApartments($id) {
        $apartments = $this->getDoctrine(Building::class)
                        ->getRepository(Apartment::class)
                        ->findByBuilding($id);
        
        return new JsonResponse($apartments);
    }
}
