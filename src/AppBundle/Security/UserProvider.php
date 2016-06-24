<?php

namespace AppBundle\Security;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    /** @var EntityManager em */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function loadUserByUsername($username)
    {
        return $this->em->getRepository(User::class)->findOneByUsername($username);
    }

    public function refreshUser(UserInterface $user)
    {
    }

    public function supportsClass($class)
    {
    }

}
