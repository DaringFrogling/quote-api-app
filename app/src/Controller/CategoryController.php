<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractApiController
{
    public function indexAction(Request $request): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->respond($categories);
    }

    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(CategoryType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid())
        {
           return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Category $category */
        $category = $form->getData();

        $this->getDoctrine()->getManager()->persist($category);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($category);
    }
}