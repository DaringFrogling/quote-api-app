<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Quote;
use App\Form\Type\QuoteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuoteController extends AbstractApiController
{

    public function showAction(Request $request): Response
    {
        $authorId = $request->get('id');

        $author = $this->getDoctrine()->getRepository(Author::class)->findOneBy([
            'id' => $authorId
        ]);

        if (!$author) {
            throw new NotFoundHttpException('Author does not exist');
        }

        $quote = $this->getDoctrine()->getRepository(Quote::class)->findBy([
            'author' => $author
        ]);

        if (!$quote) {
            throw new NotFoundHttpException('Quotes does not exist for this author');
        }
        return $this->respond($quote);
    }

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

    public function deleteAction(Request $request): Response
    {
        $quoteId = $request->get('id');

        $quote = $this->getDoctrine()->getRepository(Quote::class)->findOneBy([
            'id' => $quoteId
        ]);

        if (!$quote) {
            throw new NotFoundHttpException('Quote does not exist');
        }

        $this->getDoctrine()->getManager()->remove($quote);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond('Quote deleted');
    }

    public function updateAction(Request $request): Response
    {
        $quoteId = $request->get('id');

        $quote = $this->getDoctrine()->getRepository(Quote::class)->findOneBy([
            'id' => $quoteId
        ]);

        if (!$quote) {
            throw new NotFoundHttpException('Quote does not exist');
        }

        $form = $this->buildForm(QuoteType::class, $quote, [
            'method' => $request->getMethod(),
        ]);

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