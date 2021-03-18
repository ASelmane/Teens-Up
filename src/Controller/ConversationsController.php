<?php

namespace App\Controller;

use App\Entity\Conversations;
use App\Form\ConversationsType;
use App\Repository\ConversationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/conversations")
 */
class ConversationsController extends AbstractController
{
    /**
     * @Route("/", name="conversations_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('conversations/index.html.twig');
    }

    /**
     * @Route("/{id}", name="conversations_show", methods={"GET"})
     */
    public function show(Conversations $conversation): Response
    {
        return $this->render('conversations/show.html.twig', [
            'conversation' => $conversation,
        ]);
    }

    /**
     * @Route("/{id}", name="conversations_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Conversations $conversation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$conversation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($conversation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('conversations_index');
    }
}
