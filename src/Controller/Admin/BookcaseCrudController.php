<?php

namespace App\Controller\Admin;

use App\Entity\Bookcase;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class BookcaseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bookcase::class;
    }

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm(),

            AssociationField::new('membre'),

            BooleanField::new('released'),

            TextField::new('description'),

            AssociationField::new('books')
            ->onlyOnForms()
            // on ne souhaite pas gérer l'association entre les
            // books et la bookcase dès la création de la
            // bookcase
            ->hideWhenCreating()
            ->setTemplatePath('admin/fields/bookcollection_books.html.twig')
            // Ajout possible seulement pour des books qui
            // appartiennent même propriétaire de la bookcollection
            // que le membre de la bookcase
            ->setQueryBuilder(
                function (QueryBuilder $queryBuilder) 
                {
                    // récupération de l'instance courante de bookcase
                    $currentBookcase = $this->getContext()->getEntity()->getInstance();
                    $membre = $currentBookcase->getMembre();
                    $membreId = $membre->getId();
                    // charge les seuls books dont le 'membre' de la bookcollection
                    // est le membre de la galerie
                    $queryBuilder->leftJoin('entity.bookcollection', 'i')
                        ->leftJoin('i.membre', 'm')
                        ->andWhere('m.id = :membre_id')
                        ->setParameter('membre_id', $membreId);    
                    return $queryBuilder;
                }
            ),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {

    return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
    ;
    }
}
