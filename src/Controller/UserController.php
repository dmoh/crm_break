<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }



    /**
     * @Route("/users", name="get_all_users", methods={"GET"})
     */
    public function getAllUsers(): JsonResponse
    {
        $data = [];
        $entityManager = $this->getDoctrine()->getManager();
        $customers = $entityManager->getRepository(User::class)->findAll();




        foreach ($customers as $customer) {
            $data[] = [
                'id' => $customer->getId(),
                'firstname' => $customer->getFirstname(),
                'lastname' => $customer->getLastname(),
                'email' => $customer->getEmail(),
                'phoneNumber' => $customer->getPhoneNumber(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
