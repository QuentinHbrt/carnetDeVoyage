<?php

namespace App\Controller;

use DateTime;
use App\Entity\Utilisateur;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,\Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator ): Response
    {
        $user = new Utilisateur();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Génération d'un token
            $token = $tokenGenerator->generateToken();
            $membre = $form->getData();
            // echo '<pre>';
            // var_dump($token);
            // echo '</pre>';
            // dd();

            // Generation de l'url avec le token qui correspond
            $url = $this->generateUrl('carnetvoyage_utilisateur_validation', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            // echo '<pre>';
            // var_dump($url);
            // echo '</pre>';
            // dd();

            $user->setCreatedAt(new DateTime("now"));
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setToken($token);
            $message = (new \Swift_Message('Activation de votre compte'))
            ->setFrom('horizons.appli5@gmail.com')
            ->setTo($membre->getEmail())
            ->setBody(
                "Vous avez créé un compte sur notre site, veuillez cliquer sur le lien ci-dessous pour l'activer : " . $url,
                'text/html'
            );

            $mailer->send($message);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    
    public function index(\Swift_Mailer $mailer)
    {
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('horizons.appli5@gmail.com')
        ->setTo('quentin.hebert@hotmail.fr')
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'registration/registration.html.twig',
                // ['name' => $name]
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                ['name' => $name]
            ),
            'text/plain'
        )
        */
    ;
    return $this->render('registration/registration.html.twig');
    
    }

}