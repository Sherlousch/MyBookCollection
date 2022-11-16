<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('author'),
            AssociationField::new('genres')
                ->onlyOnDetail()
                ->formatValue(function ($value, $entity) 
                {
                    return implode(', ', $entity->getGenres()->toArray());
                }),
            AssociationField::new('collection'),
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
