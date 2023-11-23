<?php

namespace App\Controller\Admin;

use App\Entity\Formations;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class FormationsCrudController extends AbstractCrudController
{
    public const FORMATIONS_BASE_PATH = 'assets/uploads/formation';
    public const FORMATIONS_UPLOAD_DIR = 'public/assets/uploads/formation';

    public static function getEntityFqcn(): string
    {
        return Formations::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action
                    ->setIcon('fas fa-plus')
                    ->setLabel('Ajouter une formation');
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
                    ->setLabel('Créer et ajouter une nouvelle');
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
            });
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Formations')
            ->setEntityLabelInSingular('Formation')
            ->setPageTitle('index', 'Vitrine3p - Administration des Collaborateurs');
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex()
            ->setFormTypeOption('disabled', 'disabled');
        yield TextField::new('titre', 'Titre')
            ->setColumns(12);
        yield TextField::new('reference', 'Réf.')
            ->setColumns(3);
        yield TextField::new('duree', 'Durée')
            ->setColumns(3)
            ->hideOnIndex();
        yield BooleanField::new('cpf', 'Eligible au CPF')
            ->hideOnIndex();
        yield TextField::new('effectif', 'Effectifs')
            ->setColumns(3)
            ->hideOnIndex();
        yield TextField::new('modalitepedago', 'Modalités pégagogiques')
            ->setColumns(3)
            ->hideOnIndex();

        yield TextField::new('public', 'Public')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextField::new('prerequis', 'Prérequis')
            ->setColumns(3)
            ->hideOnIndex();

        yield AssociationField::new('referentpedagogique')
            ->setLabel('Référent pédagogique')
            ->setColumns(12)
            ->hideOnIndex();

        yield TextEditorField::new('objectifs', 'Objectifs')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextField::new('validation', 'Validation')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextEditorField::new('moyenspedago', 'Moyens pédagogiques')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextEditorField::new('documents', 'Liste des documents remis au stagiaire')
            ->setColumns(12)
            ->hideOnIndex();

        yield TextEditorField::new('programme', 'Programme de formation')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextEditorField::new('tarif', 'Tarif')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextField::new('acces', 'Modalités et délai d\'accès (par défaut : "Inscription par retour de la convention de formation complétée, signée et date au plus tard 15 jours avant le début de la formation.") ')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextEditorField::new('referencesreglementaires', 'Références réglementaires')
            ->setColumns(12)
            ->hideOnIndex();
        yield TextField::new('reussite', 'Tx de réussite')
            ->setColumns(3)
            ->hideOnIndex();
        yield TextField::new('satisfaction', 'Tx de satisfaction')
            ->setColumns(3)
            ->hideOnIndex();

        yield ImageField::new('photo')
            ->setBasePath(self::FORMATIONS_BASE_PATH)
            ->setUploadDir(self::FORMATIONS_UPLOAD_DIR)
            ->setSortable(false);
        yield DateField::new('modifiedAt', 'Date de mise à jour');
    }
}
