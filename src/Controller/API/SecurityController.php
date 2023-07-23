<?php

namespace App\Controller\API;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api')]
class SecurityController extends AbstractController
{
    #[Route(path: '/registration', name: 'api_registration', methods: ['POST'])]
    public function registration(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $requestArrayData = json_decode($request->getContent(), true);

        $form = $this->createForm(RegistrationType::class);
        $form->submit($requestArrayData);

        $user = new User();
        $user->setUsername($requestArrayData['username']);
        $user->setPassword($passwordHasher->hashPassword($user, $requestArrayData['password']));

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['ok']);
    }

    #[Route(path: '/foo', name: 'api_foo')]
    public function foo(Request $request): JsonResponse
    {
        return new JsonResponse([]);
    }
}
