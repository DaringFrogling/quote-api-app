<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Quote;
use App\Form\Type\QuoteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuoteController extends AbstractApiController
{
    public function indexAction(Request $request): Response
    {
        $quotes = $this->getDoctrine()->getRepository(Quote::class)->findAll();

        return $this->respond($quotes);
    }

    public function createAction(Request $request): Response
    {
        $form = $this->buildForm(QuoteType::class);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid())
        {
           return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        /** @var Quote $quote */
        $quote = $form->getData();

        $this->getDoctrine()->getManager()->persist($quote);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($quote);
    }
}