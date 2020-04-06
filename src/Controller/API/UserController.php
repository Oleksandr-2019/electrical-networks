<?php

namespace App\Controller\API;

use App\Entity\ApiToken;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class UserController extends AbstractController
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/register", name="api_register", methods={"POST"})
     */
    public function register(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);

        if (!$requestContent['nickname']) {
            return $this->json(['error' => 'Invalid request'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = $this->userService->createApiUser($requestContent['nickname']);
        } catch (BadRequestHttpException $exception) {
            return $this->json([
                'error' => $exception->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'api_token' => $user->getApiTokens()->first()->getToken()
        ]);
    }

    /**
     * @Route("/renew-token", name="api_renew_token", methods={"POST"})
     */
    public function renewToken(Request $request)
    {
        $requestContent = json_decode($request->getContent(), true);

        if (empty($requestContent['token'])) {
            return $this->json(['error' => 'Invalid request'], Response::HTTP_BAD_REQUEST);
        }

        /** @var ApiToken $newToken */
        $newApiToken = $this->userService->renewToken($requestContent['token']);

        return $this->json([
            'api_token' => $newApiToken->getToken()
        ]);
    }
}