<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserManager extends AbstractController
{

    private $nickname;
    private $password;
    private $roles;

    private $passwordEncoder;

    /**
     * UserManager constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function setNickname(string $nickname): self
    {
        $this->nickname = $nickname;

        return $this;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function index()
    {
        $user = new User();
        $user->setNickname($this->nickname);
        $user->setRoles($this->roles);


        //$user->setPassword($this->password);
        //$user->setPassword($this->passwordEncoder);
//        $passwordEncoder->encodePassword(
//            $user,
//            $passwordEncoder
//        );
        $password = $this->passwordEncoder->encodePassword($user, $this->password);
        $user->setPassword($password);



        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

}