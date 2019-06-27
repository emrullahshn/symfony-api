<?php

namespace App\Controller;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Library\Utils;
use App\Service\RedisService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Predis\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

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
     * @param RedisService $redisService
     * @param UserPasswordEncoder $passwordEncoder
     * @return JsonResponse
     * @throws Exception
     */
    public function login(Request $request, EntityManagerInterface $entityManager, RedisService $redisService, UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {
        $params = $request->request->all();

        $email = $params['email'];
        $password = $params['password'];

        /**
         * @var User $user
         */
        $user = $entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        $isPasswordValid = $passwordEncoder->isPasswordValid($user, $password);

        if ($isPasswordValid === false) {
            return new JsonResponse(
                ['errorMessage' => 'Check user credentials!'],
                JsonResponse::HTTP_FORBIDDEN
            );
        }

        $apiToken = Utils::generateToken();

        $redisService->set($apiToken, $user->getId(), 30);

        $entityManager->flush();

        return new JsonResponse(['token' => $apiToken], 200);
    }
}
