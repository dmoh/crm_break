<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractController
{
    protected $headers;


    public function __construct()
    {
        $this->headers = [
            'Content-type' => 'application/json'
        ];
    }

    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }


    /**
     * @Route("/category/list", name="category_list")
     */
    public function getAllCategories(SerializerInterface $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $datas = $entityManager->getRepository(Category::class)->findAll();
        $categories = $serializer->serialize($datas, 'json');
        return new JsonResponse($categories, 200, $this->headers, true);
    }


}
