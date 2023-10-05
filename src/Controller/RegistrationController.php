<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\JWTService;
use App\Security\Authenticator;
use App\Security\EmailVerifier;
use App\Service\SendMailService;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        Authenticator $authenticator,
        EntityManagerInterface $entityManager,
        JWTService $jWTService,
        SendMailService $sendMailService,
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles(['ROLE_USER']);

            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email


            // Génération du JWT de l'utilisateur
            // créer le header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];
            //créer le payload
            $payload = [
                'user_id' => $user->getId()
            ];
            //définir la durée de validité en nb de secondes
            $validity = 86400;
            // générer le token
            $token = $jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'), $validity);
            //envoi d'un mail
            $sendMailService->send(
                'no-reply@vitrine3p.fr',
                $user->getEmail(),
                'Activation de votre compte vitrine3p',
                'register',
                compact('user', 'token')
            );

            $this->addFlash('success', 'Félicitations ! Votre compte vient d\'être créé. Un e-mail vient de vous être envoyé à l\'adresse que vous nous avez communiquée. Merci de cliquer sur le lien d\'activation afin de finaliser votre inscription.');

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        } else {
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
                'passError' => 'Les mots de passe ne sont pas identiques.'
            ]);
        }
    }

    #[Route('/verify/{token}', name: 'app_verify_user')]
    public function verifyUser(
        $token,
        JWTService $jWTService,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // vérifier si le token est valide, n'a pas expiré et n'a pas été modifié
        if ($jWTService->isValidToken($token) && !$jWTService->isExpiredToken($token) && $jWTService->checkSignatureToken($token, $this->getParameter('app.jwtsecret'))) {
            // récupération du payload
            $payload = $jWTService->getPayload($token);
            // récupération du user du token
            $user = $userRepository->find($payload['user_id']);
            //vérification que le user existe et n'a pas encore activé so compte
            if ($user && !$user->isVerified()) {
                $user->setIsVerified(true);
                $entityManager->flush($user);

                // dd($user);
                $this->addFlash('success', 'Félicitations ! Votre compte est activé !');
                return $this->redirectToRoute('app_user_index');
            }
        }
        // ici un problème dans le token
        $this->addFlash('danger', 'Le Token est invalide ou a expiré.');
        return $this->redirectToRoute('app_login');
    }

    // renvoi de la vérification
    #[Route('/renvoiverif', name: 'app_resend_verif')]
    public function resendVerif(
        JWTService $jWTService,
        SendMailService $sendMailService,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $user = $this->getUser();

        // vérifie que l'utilisateur est connecté
        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page.');
            return $this->redirectToRoute('app_login');
        }

        //vérifie que l'utilisateur n'a pas déjà été vérifié
        //dd($user->getIsVerified());
        if ($user->isVerified()) {
            $this->addFlash('warning', 'Ce compte utilisateur est déjà activé.');
            return $this->redirectToRoute('app_user_index');
        }

        // Génération du JWT de l'utilisateur
        // créer le header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //créer le payload
        $payload = [
            'user_id' => $user->getId()
        ];
        //définir la durée de validité en nb de secondes
        $validity = 86400;

        // générer le token
        $token = $jWTService->generate($header, $payload, $this->getParameter('app.jwtsecret'), $validity);

        // dd($token);

        //envoi d'un mail
        $sendMailService->send(
            'no-reply@vitrine3p.fr',
            $user->getEmail(),
            'Activation de votre compte vitrine3p.fr',
            'register',
            compact('user', 'token')
        );
        $this->addFlash('success', 'Un e-mail vient de vous être envoyé à l\'adresse que vous nous avez communiquée.');
        return $this->redirectToRoute('app_user_index');
    }
}
