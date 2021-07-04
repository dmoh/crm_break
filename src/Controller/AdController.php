<?php

namespace App\Controller;

use App\Entity\Ad;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdController extends AbstractController
{
    protected $headers = array();
    protected $mailer = null;
    // protected $jsonResponse = new JsonResponse('', )
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
        $this->headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Request-Method' => '*',
            // 'Access-Control-Request-Headers' =>'Content-Type, Authorization',
            'Accept' => '*/*'
        ];
    }

    /**
     * @Route("/ad", name="ad")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AdController.php',
        ]);
    }


    /**
     * @Route("/ad/update", name="post_ad", methods={"POST"})
     */
    public function addOrUpdateAd(Request $request, SerializerInterface $serializer): JsonResponse {
        $data = $request;
        dd($data);


        $data = $request->get('ad');
        // $serializer->deserialize($data, Ad::class, 'json');
        $entityManager = $this->getDoctrine()->getManager();
        $adToControl = json_decode($data, true);
        dd($data);
        $ads = $serializer->deserialize($data, Ad::class, 'json');
        $adId = (int) $adToControl['id'];
        if($adId != 0 && $adId != null) {
            $adOnDb = $entityManager->getRepository(Ad::class)->find($adId);
        }


        $ad = new Ad();
        $ad->arrayToAdObject($adToControl);
        $ad->setCreatedAt(new \DateTime());
        // $ad = $serializer->serialize($data, Ad::class, 'json');
        if (null == $adId || $adId == 0) {
            $ad = new Ad();
            $ad->setCreatedAt(new \DateTime());
        }

        $ad->arrayToAdObject($adToControl);
        $ad->setUpdatedAt(new \DateTime());
        // add new ad
        $entityManager->persist($ad);
        //update ad

        $entityManager->flush();
        if($ad->getPublished()) {
            $this->sendMailAdToContact($ad, [], '', [], '');
        }
        return new JsonResponse($data, Response::HTTP_OK, $this->headers);


       //  $article = $this->get('jms_serializer')->deserialize($data, 'App\Entity\Ad', 'json');
    }


    /**
     * @Route("/ad/{id}/opinion/customer",
     *     name="comment_customer",
     *     methods={"POST"},
     *     requirements={"id": "\d+"}
     *     )
     */
    public function commentLeftByCustomer(Request $request, Ad $ad, SerializerInterface $serializer): JsonResponse {

        $data = json_decode($request->getContent(), true);
        dd($data);
        // send notification
        $data = $request->getContent();
        $entityManager = $this->getDoctrine()->getManager();

        $ad = $serializer->deserialize($data, Ad::class, 'json');

        $adDb = $this->getDoctrine()->getManager()->find($ad->getId());


        $response = new JsonResponse($ad, Response::HTTP_OK, $this->headers);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;

    }

    /**
     * @Route("/ad/{id}", name="get_ad", methods={"GET"}, requirements={"id": "\d+"})
     */
    public function getAd(Ad $ad): JsonResponse {
        // $data = $request->getContent();
        if(!$ad) {
            throw new NotFoundHttpException("Cette annonce n'existe pas");
        }


        return new JsonResponse($ad->toArray(), Response::HTTP_OK, $this->headers);
        //  $article = $this->get('jms_serializer')->deserialize($data, 'App\Entity\Ad', 'json');
    }


    private function sendMailAdToContact(Ad $ad, $mails, $subject = 'Proposition de bien', $images = [], $sendBy = 'info@brec.com') : bool {

        if (!empty($images)) {
            // take 2 image
        }

        $email = (new TemplatedEmail())
            ->from('info@brec.com')
            ->to(new Address('mkanoute74@gmail.com')) // send To Contacts
            ->subject($subject)
            ->htmlTemplate('emails/contact.html.twig')
            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'username' => 'foo',
                'link_to_ad' => 'http://localhost:4200/contact-view?infos='.base64_decode(urlencode('mail@ffff.ff')).'&idAd='.$ad->getId()
            ]);

        $this->mailer->send($email);
        // set Send To and By to Inform the Administrator Or NOT IF IS THE ADMIN
       // if($user->getRoles())

        return true;
    }


    /**
     * @Route("/ad/list", name="get_all_ads", methods={"GET"})
     */
    public function getAdsList(SerializerInterface $serializer): JsonResponse {
        $ads = $this->getDoctrine()->getRepository(Ad::class)
            ->transformAll();

        //$data = $serializer->serialize($ads, 'json');


        $response = new JsonResponse($ads, Response::HTTP_OK, $this->headers);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

         return $response;
    }



    /**
     * @Route("/ad/delete", name="delete_ad", methods={"DELETE"})
     */
    public function deleteAd(Request $request, SerializerInterface $serializer): JsonResponse {

        $data = $request->getContent();
        $entityManager = $this->getDoctrine()->getManager();

        $ad = $serializer->deserialize($data, Ad::class, 'json');

        $adDb = $this->getDoctrine()->getManager()->find($ad->getId());


        $response = new JsonResponse($ad, Response::HTTP_OK, $this->headers);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;

    }


    /**
     * @Route("/ad/contact", name="get_ads_contact", methods={"GET"})
     */
    public function getAdsContact(SerializerInterface $serializer): JsonResponse {

        $entityManager = $this->getDoctrine()->getManager();
        $ads = $this->getDoctrine()
            ->getRepository(Ad::class)
            ->find(1);
        dd($ads->getContacts());
        $ad = $serializer->deserialize($data, Ad::class, 'json');

        $adDb = $this->getDoctrine()->getManager()->find($ad->getId());


        $response = new JsonResponse($ad, Response::HTTP_OK, $this->headers);
        $response->setEncodingOptions(JSON_UNESCAPED_UNICODE);
        $response->setCharset('UTF-8');
        $response->setEncodingOptions(JSON_PRETTY_PRINT);

        return $response;

    }

}
