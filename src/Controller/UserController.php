<?php

namespace App\Controller;
use App\Repository\UserRepository;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;

class UserController extends AbstractController
{
    private $headers = array();
    public function __construct()
    {
        $this->headers = [
            'Access-Control-Allow-Origin' => '*',
            'Allow' => 'GET, POST, HEAD, OPTIONS'
            /*,
            'Access-Control-Request-Method' => 'POST, GET, OPTIONS',
            'Access-Control-Request-Headers' =>'Origin, Content-Type, Accept',
            'Access-Control-Allow-Credentials' => 'true'*/
        ]; // TODO ATTENTION LORS DU DEPLOIEMENT !!!!
    }

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
     * @Route("/user/log_check", name="login", methods={"POST"})
     */
    public function login(Request $request) : JsonResponse
    {
        $data = $request->getContent();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }


    /**
     * @Route("/api/login_check", name="api_login")
     * @return JsonResponse
     */
    public function api_login(): JsonResponse
    {
       // $user = $this->getUser();

        return new JsonResponse([
            'email' => '$user->getEmail()',
            'roles' => 'fgfdfxgfdgf',
        ]);
    }

    /**
     * @Route("/user/list", name="get_all_users", methods={"GET"})
     */
    public function getAllUsers(MailerInterface $mailer): JsonResponse
    {
        $data = [];
        $entityManager = $this->getDoctrine()->getManager();
        $users = $entityManager->getRepository(User::class)->findAll();
        // $response->headers->set('Access-Control-Allow-Origin', '*');

        foreach ($users as $user) {
            $data[] = $user->toArray();
        }

        // test envoie d email
        $email = (new Email())
            ->from('hello@example.com')
            ->to('mkanoute74@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        /// $mailer->Host = 'tls://smtp.gmail.com:587';


       // $mailer->send($email);

        return new JsonResponse($data, Response::HTTP_OK, $this->headers);
    }


}
