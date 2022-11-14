<?php

namespace App\Controller\Admin;

use App\Entity\Bookcollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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
            AssociationField::new('books')->onlyOnDetail(),
            IdField::new('id')->hideOnForm(),
        ];
    } 
}