<?php

namespace App\Service;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Repository\ApiTokenRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserService
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var ApiTokenRepository
     */
    private $tokenRepository;

    public function __construct(ValidatorInterface $validator, ManagerRegistry $registry, ApiTokenRepository $tokenRepository)
    {
        $this->validator = $validator;
        $this->registry = $registry;
        $this->tokenRepository = $tokenRepository;
    }

    public function createApiUser(string $nickname)
    {

        $violations = $this->validator->validate($nickname, [
            new Email()
        ]);

        if (!empty($violations)) {
            foreach ($violations as $violation) {
                throw new BadRequestHttpException($violation->getMessage());
            }
        }

        $user = new User();
        $user->setNickname($nickname);
        $apiToken = new ApiToken($user);

        $em = $this->registry->getManager();
        $em->persist($user);
        $em->persist($apiToken);
        $em->flush();

        return $user;
    }

    public function renewToken(string $oldToken)
    {
        /** @var ApiToken $oldApiToken */
        $oldApiToken = $this->tokenRepository->findOneBy([
            'token' => $oldToken
        ]);

        if (!$oldApiToken) {
            throw new BadRequestHttpException("Invalid token");
        }

        $user = $oldApiToken->getUser();
        $newApiToken = new ApiToken($user);

        $em = $this->registry->getManager();

        $em->remove($oldApiToken);
        $em->persist($newApiToken);
        $em->flush();

        return $newApiToken;
    }
}