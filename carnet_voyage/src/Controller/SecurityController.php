<?php

namespace App\Controller;

use LogicException;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        
        // echo '<pre>';
        // var_dump($lastUsername);
        // echo '</pre>';
        // $user = $this->getDoctrine()->getRepository()->findOneByEmail($lastUsername);
          
            // $this->addFlash('message', 'Vous n\'avez pas encore validé votre email ');
            // return redirectToRoute('app_login');
        

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function emailValidate(Request $request, string $token ){
        if ($request->isMethod('GET')) {
            $entityManager = $this->getDoctrine()->getManager();
            // Récupération de l'utilisateur correspondant au token présent dans l'url
            $membre = $entityManager->getRepository(Utilisateur::class)->findOneByToken($token);
            /* @var $membre Membre */

            if ($membre === null) {
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('index');
            }

            // Reset du token
            $membre[0]->setToken(null);
            $membre[0]->setIsVerified(true);
            $entityManager->flush();

            $this->addFlash('notice', 'Votre mail a bien été activé');

            return $this->redirectToRoute('carnetvoyage_utilisateur_login');
        }else {
            return $this->render('security/login.html.twig', ['token' => $token]);
        }
    }
}
