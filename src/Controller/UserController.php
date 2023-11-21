<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserEmailType;
use App\Service\JWTService;
use App\Service\SendMailService;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(
        UserRepository $userRepository,
        Request $request,
        SendMailService $sendMailService
    ): Response {
        if ($request->isMethod('POST') && $request->request->has('submitContact')) {

            $civilite = $request->request->get("civilite");
            $nom = $request->request->get("nom");
            $mail = $request->request->get("mail");
            $societe = $request->request->get("societe");
            $telephone = $request->request->get("telephone");
            $objet = $request->request->get("objet");
            $commentaire = $request->request->get("commentaire");

            $objetMail = 'Contact Vitrine3p.fr : ' . $objet;

            $sendMailService->send(
                $mail,
                'contact@vitrine3p.fr',
                $objetMail,
                'contact',
                compact('commentaire', 'nom', 'societe', 'telephone', 'mail', 'objet')

            );
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('app_user_index');
        }

        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    // public function show(User $user): Response
    // {
    //     return $this->render('user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        SendMailService $sendMailService,
    ): Response {

        /* MODALE CONTACT */

        if ($request->isMethod('POST') && $request->request->has('submitContact')) {


            $civilite = $request->request->get("civilite");
            $nom = $request->request->get("nom");
            $mail = $request->request->get("mail");
            $societe = $request->request->get("societe");
            $telephone = $request->request->get("telephone");
            $objet = $request->request->get("objet");
            $commentaire = $request->request->get("commentaire");

            $objetMail = 'Contact Vitrine3p.fr : ' . $objet;

            $sendMailService->send(
                $mail,
                'contact@vitrine3p.fr',
                $objetMail,
                'contact',
                compact('commentaire', 'nom', 'societe', 'telephone', 'mail', 'objet')

            );
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('app_user_edit');
        }

        /* FORMULAIRE EDIT */

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/editEmail', name: 'app_user_edit_email', methods: ['GET', 'POST'])]
    public function editEmail(
        Request $request,
        User $user,
        EntityManagerInterface $entityManager,
        SendMailService $sendMailService,
        JWTService $jWTService
    ): Response {

        /* MODALE CONTACT */

        if ($request->isMethod('POST') && $request->request->has('submitContact')) {
$userId = $user->getId();


            $civilite = $request->request->get("civilite");
            $nom = $request->request->get("nom");
            $mail = $request->request->get("mail");
            $societe = $request->request->get("societe");
            $telephone = $request->request->get("telephone");
            $objet = $request->request->get("objet");
            $commentaire = $request->request->get("commentaire");

            $objetMail = 'Contact Vitrine3p.fr : ' . $objet;

            $sendMailService->send(
                $mail,
                'contact@vitrine3p.fr',
                $objetMail,
                'contact',
                compact('commentaire', 'nom', 'societe', 'telephone', 'mail', 'objet')

            );
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            return $this->redirectToRoute('app_user_edit_email', [
                'id' => $userId,
            ], Response::HTTP_SEE_OTHER);
        }

        /* FORMULAIRE EDIT MAIL */

        $form = $this->createForm(UserEmailType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //passer isVerified à false puis génération du token de confirmation adresse e-mail :

            $user->setIsVerified(false);

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
                'Modification de votre adresse e-mail',
                'modif_email',
                compact('user', 'token')
            );

            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit_email.html.twig', [
            'user' => $user,
            'formEmail' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    // public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($user);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    // }
}
