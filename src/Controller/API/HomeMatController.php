<?php

namespace App\Controller\API;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/mat")
 */
class HomeMatController extends AbstractController
{
    /**
     * @Route("/", methods={"GET"})
     */
    public function list(UserRepository $repository)
    {
        $user = array_map(function($user) {
            return [
                'id' => $user->getId(),
                'userName' => $user->getUsername(),
                'nickName' => $user->getNickname(),
            ];
        }, $repository->findAll());

        return $this->json([
            'user' => $user,
        ]);
        
    }
}