<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
    * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(UsersRepository $usersRepository)
    {
        $user = $this->getUser();
        $user_id = $user->getId();
        $user_sports = $user->getSport();

        foreach ($user_sports as $sport) {
            $sportUsers = $sport->getUsers();
            foreach ($sportUsers as $users) {
                if ($users->getId() !== $user_id) {
                    $listUsers[] = $users;
                }
            }
        }
        $listUsers = array_unique($listUsers, SORT_REGULAR);
        
        return $this->render('default/dashboard.html.twig', [
            'users' => $listUsers ,
        ]);
    }
}
