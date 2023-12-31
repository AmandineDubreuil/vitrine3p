<?php

namespace App\Controller;

use App\Service\SendMailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LegalController extends AbstractController
{
    #[Route('/legal', name: 'app_legal')]
    public function index(
        Request $request,
        SendMailService $sendMailService

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

            return $this->redirectToRoute('app_legal');   
        }

        
        return $this->render('legal/index.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }
}
