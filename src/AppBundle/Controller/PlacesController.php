<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Place;
use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PlacesController extends FOSRestController
{
    /**
     * Get user places
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Retrieves a user places"
     * )
     *
     * @Rest\View()
     */
    public function getUsersPlacesAction($userId)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findOneById($userId);
        return ['places' => $user->getPlaces()];
    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  description="Create a user place"
     * )
     *
     * @Rest\View()
     */
    public function postUsersPlacesAction(Request $request, $userId)
    {

    }

    /**
     * @ApiDoc(
     *  description="Delete a user place"
     * )
     *
     * @Rest\View()
     */
    public function deleteUsersPlacesAction($userId, $placeId)
    {
        $place = $this->getDoctrine()->getRepository(Place::class)->findOneBy([
            'user' => $this->getUser(),
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
