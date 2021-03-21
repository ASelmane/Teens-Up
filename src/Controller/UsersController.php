<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profil")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="profil")
     */
    public function show(): Response
    {
        return $this->render('users/index.html.twig', [
        ]);
    }

    /**
    * @Route ("/edit" , name="profil_edit")
    */
    public function edit(Request $request)
    {
        $user= $this->getUser();
        $img = $user->getImages();
        $form = $this->createForm(UsersType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $file = $_FILES['users']['name']['images'];
            
            if (isset($_FILES) && ($file != '')) {
                //upload des images
                $extension = array('.jpg', '.jpeg','.png');
                $extensionUpload = strtolower(strrchr($file, '.'));
                $name = '';
                if (in_array($extensionUpload, $extension)) {
                    for ($i=0; $i < 9; $i++) {
                        $name .= random_int(0, 9);
                    }
                    $chemin = 'images/profil/'.$name.$extensionUpload;
                    $upload = move_uploaded_file($_FILES['users']['tmp_name']['images'], $chemin);
                    
                    if ($upload) {
                        if ($img != '') {
                            unlink($img);
                        }
                        $user->setImages($chemin);
                    } else {
                        $this->addFlash('danger', 'Erreur lors de l\'upload');
                        return $this->render('users/edit.html.twig', [
                        'form' => $form->createView(),
                    ]);
                    }
                } else {
                    $this->addFlash('danger', 'Veuillez ajouter une image valable');
                    return $this->render('users/edit.html.twig', [
                    'form' => $form->createView(),
                ]);
                }
            }else $user->setImages($img);
                
                $em->persist($user);
                $em->flush();
                
                
                $this->addFlash('success', '<p>Profil mis à jour avec succès.</p>');
                return $this->redirectToRoute('profil');
            
        }

        return $this->render('users/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
    * @Route ("/editPassword" , name="password_edit")
    */
    public function editPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $old_pwd = $request->get('old_password'); 
            $new_pwd = $request->get('new_password'); 
            $new_pwd_confirm = $request->get('new_password_confirm');
            $user = $this->getUser();
            $checkPass = $passwordEncoder->isPasswordValid($user, $old_pwd);
            if($checkPass === true) {
                if(($new_pwd != '') && ($new_pwd == $new_pwd_confirm)){
                    $new_pwd_encoded = $passwordEncoder->encodePassword($user, $new_pwd_confirm); 
                    $user->setPassword($new_pwd_encoded);
                    $em->flush();
                    $this->addFlash('success', 'Mot de passe mis à jour');

                    return $this->redirectToRoute('profil');
                }
                else $this->addFlash('warning', 'Les deux mots de passe sont différents');
            } 
            else {
                $this->addFlash('danger', 'Ancien mot de passe incorrect');
            }
        }
        return $this->render('users/editPassword.html.twig');
    }

    /**
     * @Route("/{id}", name="users_delete", methods={"DELETE"})
     */
    public function delete(Request $request,Users $user): Response
    {
        if($user == $this->getUser()){

            unlink($user->getImages());
            if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($user);
                $entityManager->flush();
            }
            $token = new AnonymousToken('','anon.');
            $this->get('security.token_storage')->setToken($token);

            return $this->redirectToRoute('index');
        }
        return $this->redirectToRoute('profil');
    }
}
