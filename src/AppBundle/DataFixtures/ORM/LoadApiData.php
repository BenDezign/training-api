<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Media;
use AppBundle\Entity\Place;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadApiData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        /** @var ContainerInterface container */
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('shinework');
        $user->setPlainPassword('test');
        $this->container->get('app.user_manager')->updatePassword($user);
        $manager->persist($user);

        $place = new Place();
        $place->setName('MOSES');
        $place->setAddress('144 Boulevard Voltaire, 75011 Paris');
        $place->setComment('Super burger, j\'adore');
        $place->setLatitude(48.856498);
        $place->setLongitude(2.3819353);
        $place->setUser($user);

        $media = new Media();
        $media->setUrl('http://placehold.it/350x150');
        $media->setPlace($place);

        $manager->persist($media);
        $manager->persist($place);

        $place = new Place();
        $place->setName('Le comptoir Parmentier');
        $place->setAddress('6 Avenue Parmentier, 75011 Paris');
        $place->setComment('Super tartare italien');
        $place->setLatitude(48.8590405);
        $place->setLongitude(2.3798429);
        $place->setUser($user);

        $media = new Media();
        $media->setUrl('http://placehold.it/250x250');
        $media->setPlace($place);

        $manager->persist($media);
        $manager->persist($place);

        $manager->flush();
    }
}
