<?php

namespace App\Controller;

use App\Entity\Ad;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AdController extends AbstractController
{
    protected $headers = array();
    public function __construct()
    {
        $this->headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Request-Method' => 'POST',
            'Access-Control-Request-Headers' =>'Content-Type, Authorization',
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
    public function addAd(Request $request, SerializerInterface $serializer): JsonResponse {
        $data = $request->getContent();
        $entityManager = $this->getDoctrine()->getManager();

        $ad = $serializer->deserialize($data, Ad::class, 'json');
        if (null == $ad->getId() || $ad->getId() == 0) {
           // add new ad
            $entityManager->persist($ad);
        } else {
            //update ad
            $adUpdated = $this->getDoctrine()
                ->getRepository(Ad::class)
                ->find((int)$ad->getId());
            $adUpdated->setTitle($ad->getTitle());
            $adUpdated->setComment($ad->getComment());
           // $entityManager->persist($ad);
        }

        $entityManager->flush();
        return new JsonResponse($data, Response::HTTP_OK, $this->headers);


       //  $article = $this->get('jms_serializer')->deserialize($data, 'App\Entity\Ad', 'json');
    }



    /**
     * @Route("/ads/list", name="get_all_ads", methods={"GET"})
     */
    public function getAdsList(SerializerInterface $serializer): JsonResponse {
        $ads = $this->getDoctrine()->getRepository(Ad::class)
            ->findAll();



        $data = $serializer->serialize($ads, 'json');
        dd($data);
        return new JsonResponse($data, Response::HTTP_OK, $this->headers);
    }
}
