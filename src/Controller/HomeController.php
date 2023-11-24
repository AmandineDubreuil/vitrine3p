<?php

namespace App\Controller;

use App\Entity\Formations;
use App\Repository\FormationsRepository;
use App\Service\SendMailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        SendMailService $sendMailService,
      FormationsRepository $formationsRepository,
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

            return $this->redirectToRoute('app_home');
        }

        /* FORMATIONS */
         $formations = $formationsRepository->findlastXFormations(3); 


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'formations' => $formations,
        ]);
    }
}
