<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        //return $this->render('admin/dashboard.html.twig');

        $url = $this->adminUrlGenerator
            ->setController(EquipesCrudController::class)
            ->generateUrl();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         return $this->redirect($url);


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Vitrine3p');
        //    ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
      //  yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Equipe');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Ajout Collaborateur', 'fas fa-plus', Equipes::class)->setAction(Crud::PAGE_NEW),
             MenuItem::linkToCrud('Voir Collaborateurs', 'fas fa-eye', Equipes::class)
        ]);
        yield MenuItem::section('Formations');
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir Utilisateurs', 'fas fa-eye', User::class)
       ]);

    }
}
