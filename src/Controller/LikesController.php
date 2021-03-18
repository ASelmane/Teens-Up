<?php

namespace App\Controller;

use App\Entity\Likes;
use App\Entity\Users;
use App\Repository\LikesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikesController extends AbstractController
{
    /**
     * @Route("/likes/{id}", name="likes")
     */
    public function like(Users $user_liked): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        
        if (!$user)  return $this->json([
            'code' => 403,
            'message' => "Pas connecté"
        ], 403);
        
        foreach ($user_liked->getLikedBy($user) as $like) {
            if($user_liked->getLikedBy($user)){
            return $this->json([
            'code' => 403,
            'message' => 'Existe deja',
            ], 403);
            }
        }

        $like = new Likes();
        $like-> setUsers($user)
             -> setUsersLiked($user_liked)
             -> setLiked(1);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => $user_liked->getPrenom().' : like',
            ], 200);
    }

    /**
     * @Route("/dislikes/{id}", name="dislikes")
     */
    public function dislike(Users $user_liked): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        
        if (!$user)  return $this->json([
            'code' => 403,
            'message' => "Pas connecté"
        ], 403);

        foreach ($user_liked->getLikedBy($user) as $like) {
            if($user_liked->getLikedBy($user)){
            return $this->json([
            'code' => 403,
            'message' => 'Existe deja',
            ], 403);
            }
        }

        $like = new Likes();
        $like-> setUsers($user)
             -> setUsersLiked($user_liked)
             -> setLiked(0);

        $entityManager->persist($like);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => $user_liked->getPrenom().' : dislike',
            ], 200);
    }
}
