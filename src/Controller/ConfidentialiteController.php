<?php

namespace App\Controller;

use App\Service\SendContactFormService;
use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConfidentialiteController extends AbstractController
{
    #[Route('/confidentialite', name: 'app_confidentialite')]
    public function index(
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

            return $this->redirectToRoute('app_confidentialite');
        }

        return $this->render('confidentialite/index.html.twig', [
            'controller_name' => 'ConfidentialiteController',
        ]);
    }
}
