<?php

namespace App\Controller;

use App\Entity\Equipes;
use App\Form\EquipesType;
use App\Repository\EquipesRepository;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/equipe')]
class EquipesController extends AbstractController
{
    #[Route('/', name: 'app_equipes_index', methods: ['GET','POST'])]
    public function index(
        EquipesRepository $equipesRepository,
        Request $request,
        SendMailService $sendMailService,
        ): Response
    {
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

            return $this->redirectToRoute('app_equipes_index');   
        }

        return $this->render('equipes/index.html.twig', [
            'equipes' => $equipesRepository->findAll(),
        ]);
    }

    // #[Route('/new', name: 'app_equipes_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $equipe = new Equipes();
    //     $form = $this->createForm(EquipesType::class, $equipe);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($equipe);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_equipes_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('equipes/new.html.twig', [
    //         'equipe' => $equipe,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_equipes_show', methods: ['GET'])]
    // public function show(Equipes $equipe): Response
    // {
    //     return $this->render('equipes/show.html.twig', [
    //         'equipe' => $equipe,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_equipes_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Equipes $equipe, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(EquipesType::class, $equipe);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_equipes_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('equipes/edit.html.twig', [
    //         'equipe' => $equipe,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_equipes_delete', methods: ['POST'])]
    // public function delete(Request $request, Equipes $equipe, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$equipe->getId(), $request->request->get('_token'))) {
    //         $entityManager->remove($equipe);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_equipes_index', [], Response::HTTP_SEE_OTHER);
    // }
}
