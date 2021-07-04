<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
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
     * @Route("/contact", name="contact")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ContactController.php',
        ]);
    }

    /**
     * @Route("/contact/list", name="contact_list", methods={"GET"})
     */
    public function getContactList() {
        $data = [];
        $entityManager = $this->getDoctrine()->getManager();
        $contacts = $entityManager->getRepository(Contact::class)->findAll();
        // $response->headers->set('Access-Control-Allow-Origin', '*');

        foreach ($contacts as $contact) {
            $data[] = $contact->toArray();
        }

        return new JsonResponse($data, Response::HTTP_OK, $this->headers);
    }



    /**
     * @Route("/contact/add", name="add_contact", methods={"POST"})
     */
    public function addContact(Request $request, MailerInterface $mailer) {
        $data = $request->getContent();
        $entityManager = $this->getDoctrine()->getManager();
        $contacts = json_decode($data, false);
        /*$dataDB = $this->getDoctrine()->getRepository(Contact::class)
            ->findAll();
        //todo filtrer par email dd($dataDB);
        foreach ($contacts as $contact) {
            if ($contact['id'] == null || $contact['id'] == 0) {
                $newContact = new Contact();
                $newContact->setEmail($contact['email']);
                // $newContact->setDe($contact['email']);
                $newContact->setCreatedAt(now());
                if (trim($contact['name']) != '') {
                    $newContact->setName($contact['name']);
                }

                $entityManager->persist($newContact);
            }
        }

        $entityManager->flush();*/
        dd($contacts);
        /*$email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to(new Address('mkanoute74@gmail.com')) // send To Contacts
            ->subject('Proposition de bien')

            // path of the Twig template to render
            ->htmlTemplate('emails/contact.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
                ''
            ]);

        $mailer->send($email);*/
        return new JsonResponse(['ok' => 'les infos sont enregistrés et envoyés'], Response::HTTP_OK, $this->headers);
    }


}
