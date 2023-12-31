<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use App\Entity\Formations;
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
            ->setController(FormationsCrudController::class)
            ->generateUrl();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

         return $this->redirect($url);


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration du site Vitrine3p');
        //    ->renderContentMaximized();
    }


    public function configureMenuItems(): iterable
    {
      //  yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
      yield MenuItem::linktoRoute('Site Vitrine3p', 'fas fa-home', 'app_home');
        yield MenuItem::section('Equipe');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
             MenuItem::linkToCrud('Ajout Collaborateur', 'fas fa-plus', Equipes::class)->setAction(Crud::PAGE_NEW),
             MenuItem::linkToCrud('Consulter Collaborateurs', 'fas fa-eye', Equipes::class)
        ]);
        yield MenuItem::section('Formations');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajout Formation', 'fas fa-plus', Formations::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Consulter Formations', 'fas fa-eye', Formations::class)
       ]);
        yield MenuItem::section('Utilisateurs');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
            MenuItem::linkToCrud('Consulter Utilisateurs', 'fas fa-eye', User::class)
       ]);

    }
}
