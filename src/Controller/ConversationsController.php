<?php

namespace App\Controller;

use App\Entity\Conversations;
use App\Entity\Messages;
use App\Form\MessagesType;
use App\Repository\ConversationsRepository;
use App\Repository\MessagesRepository;
use DateTime;
use DateTimeZone;
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
        $user =$this->getUser();
        $lastMsg = array();
        foreach ($user->getConversations() as $conversations) {
            foreach ($conversations->getMessages() as $message) {
                    if($conversations->getLastMessage() == $message->getDate()){
                        $lastMsg[]= $message;
                    }
            }
        }
        
        return $this->render('conversations/index.html.twig', [
            'lastMsg' => $lastMsg
        ]);
    }

    /**
     * @Route("/{id}", name="conversations_show", methods={"GET"})
     */
    public function show(Conversations $conversation, MessagesRepository $messagesRepository): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);

        return $this->render('conversations/show.html.twig', [
            'conversation' => $conversation,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/new", name="messages_new", methods={"GET","POST"})
     */
    public function new(Request $request, Conversations $conversations): Response
    {
        $message = new Messages();
        $message -> setUsers($this->getUser());
        $message -> setConversations($conversations);
        $message -> setDate(new DateTime('', new DateTimeZone('Europe/Paris')));
        $conversations -> setLastMessage(new DateTime('', new DateTimeZone('Europe/Paris')));
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->persist($conversations);
            $entityManager->flush();

            return $this->redirectToRoute('conversations_show', array('id' => $conversations->getId()));
        }
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
