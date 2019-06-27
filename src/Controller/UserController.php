<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DocumentController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @Route(path="/login", name="user_login", methods={"POST"})
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function login(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $params = $request->request->all();

        $email = $params['email'];
        $password = $params['password'];

        /**
         * @var User $user
         */
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        $apiToken = new ApiToken($user);

        $entityManager->persist($apiToken);
        $entityManager->flush();

        return new JsonResponse(['token' => $apiToken->getToken()], 200);
    }
}
