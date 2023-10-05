<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class EquipesCrudController extends AbstractCrudController
{
    
    public const EQUIPES_BASE_PATH = 'assets/uploads/equipe';
    public const EQUIPES_UPLOAD_DIR = 'public/assets/uploads/equipe';

    public static function getEntityFqcn(): string
    {
        return Equipes::class;
    }

 
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Collaborateurs')
            ->setEntityLabelInSingular('Collaborateur')
            ->setPageTitle('index', 'Vitrine3p - Administration des Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        yield   IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex()
            ->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('nom');
        yield TextField::new('fonction');
        yield TextEditorField::new('description')
            ->hideOnIndex();
        yield TelephoneField::new('phone', 'Téléphone');
        yield EmailField::new('email');
        yield ImageField::new('photo')
        ->setBasePath(self::EQUIPES_BASE_PATH)
        ->setUploadDir(self::EQUIPES_UPLOAD_DIR)
        ->setSortable(false)
        ;
        yield TextField::new('horaires');
    }
}
