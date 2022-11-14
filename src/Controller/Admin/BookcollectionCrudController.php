<?php

namespace App\Controller\Admin;

use App\Entity\Bookcollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class BookcollectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bookcollection::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('description'),
            AssociationField::new('membre'),
            AssociationField::new('books')
                ->onlyOnDetail()
                ->setTemplatePath('admin/fields/bookcollection_books.html.twig'),
            IdField::new('id')->hideOnForm(),
        ];
    } 

    public function configureActions(Actions $actions): Actions
    {

    return $actions
        ->add(Crud::PAGE_INDEX, Action::DETAIL)
    ;
    }
}