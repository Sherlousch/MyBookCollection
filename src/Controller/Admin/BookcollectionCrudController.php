<?php

namespace App\Controller\Admin;

use App\Entity\Bookcollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookcollectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bookcollection::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
