<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;

class PlacesController extends FOSRestController
{
    /**
     * @Rest\View()
     */
    public function getUsersPlacesAction($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        return ['places' => $user->getPlaces()];
    }

    public function deleteUsersPlacesAction($userId, $placeId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        $place = $this->getDoctrine()->getRepository(Place::class)->findOneBy([
            'user' => $user,
            'id' => $placeId,
        ]);

        if (!$place instanceof Place) {
            throw $this->createNotFoundException();
        }

        $this->getDoctrine()->getManager()->remove($place);
        $this->getDoctrine()->getManager()->flush();

        return View::create([], Response::HTTP_OK);
    }
}
