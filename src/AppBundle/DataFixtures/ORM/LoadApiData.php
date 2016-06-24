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
use Faker\Factory;

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

        $faker = Factory::create();

        for ($i=0; $i <= 12; $i++) {
            $place = new Place();
            $place->setName($faker->name);
            $place->setAddress($faker->address);
            $place->setComment($faker->text(100));
            $place->setLatitude($faker->latitude);
            $place->setLongitude($faker->longitude);
            $place->setUser($user);

            $media = new Media();
            $media->setUrl($faker->imageUrl());
            $media->setPlace($place);

            $manager->persist($media);
            $manager->persist($place);
        }

        $manager->flush();

        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setAllowedGrantTypes(['password', 'refresh_token']);
        $clientManager->updateClient($client);
    }
}


http://127.0.0.1:4242/oauth/v2/token
//?grant_type=password
//&client_id=2_396l4l2okackc48w0go04o4cgc4w00g0sg4oc4kg0kws4kgckw
//&client_secret=1hc96n9p1i9wocogkg80g4gsc000c0o0gcscc0c44wsoss4csk
//&username=shinework
//&password=test
