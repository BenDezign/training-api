<?php

namespace AppBundle\Manager;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserManager
{
    /** @var EntityManager */
    protected $entityManager;

    /** @var UserPasswordEncoderInterface  */
    protected $userPasswordEncoder;

    public function __construct(EntityManager $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function updatePassword(UserInterface $user)
    {
        if (!empty($user->getPlainPassword())) {
            $password = $this->userPasswordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->eraseCredentials();
        }
    }
}
