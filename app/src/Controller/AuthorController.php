<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Author;
use App\Form\Type\AuthorType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractApiController
{
    public function indexAction(Request $request): Response
    {
        $authors = $this->getDoctrine()->getRepository(Author::class)->findAll();

        return $this->respond($authors);
    }

    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(AuthorType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid())
        {
           return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Author $author */
        $author = $form->getData();

        $this->getDoctrine()->getManager()->persist($author);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($author);
    }
}