<?php

namespace App\Controller\Admin;

use App\Entity\Equipes;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
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


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setIcon('fas fa-plus')
                    ->setLabel('Ajouter un collaborateur')
                    ;
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-edit text-warning')
                    ->setLabel('Editer');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash text-danger')
                    ->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action
                    ->setIcon('fas fa-eye text-info')
                    ->setLabel('Consulter');
                //  ->addCssClass('text-dark')
            })
            ->update(Crud::PAGE_DETAIL, Action::EDIT, function (Action $action) {
                return $action
                    ->setIcon('fas fa-edit text-warning')
                    ->setLabel('Editer');
            }) 
            ->update(Crud::PAGE_DETAIL, Action::DELETE, function (Action $action) {
                return $action
                    ->setIcon('fas fa-trash text-danger')
                    ->setLabel('Supprimer');
            })
            ->update(Crud::PAGE_DETAIL, Action::INDEX, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Retour');
            })
            ->reorder(Crud::PAGE_DETAIL, [Action::INDEX, Action::EDIT, Action::DELETE])

            ->add(Crud::PAGE_EDIT, Action::INDEX)
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_CONTINUE, function (Action $action) {
                return $action
                   // ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Enregistrer et continuer');
            })
            ->update(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                   // ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Enregistrer');
            })
            ->update(Crud::PAGE_EDIT, Action::INDEX, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Retour');
            })

            ->add(Crud::PAGE_NEW, Action::INDEX)

            ->update(Crud::PAGE_NEW, Action::SAVE_AND_ADD_ANOTHER, function (Action $action) {
                return $action
                   // ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Créer et ajouter un nouveau');
            })
            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action
                   // ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Créer');
            })
            ->update(Crud::PAGE_NEW, Action::INDEX, function (Action $action) {
                return $action
                    ->setIcon('fa-solid fa-arrow-left')
                    ->setLabel('Retour');
            })

            ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Collaborateurs')
            ->setEntityLabelInSingular('Collaborateur')
            ->setPageTitle('index', 'Vitrine3p - Administration des Utilisateurs')
            
            ;
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
            ->setSortable(false);
        yield TextField::new('horaires');
    }


}
